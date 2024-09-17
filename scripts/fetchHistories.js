var url = window.location.href;

if (url.includes('history')) {
    document.addEventListener('DOMContentLoaded', () => {

        fetch(`../../backend/fetch_histories.php`)
            .then(response => response.json()) // Parse the response as JSON
            .then(dataByDate => {

                const container = document.getElementById('historyContainer');

                // Check if there is no data
                if (dataByDate.length === 0) {
                    let tileHTML = `<p>No abstracts viewed yet.</p>`;
                    // Append the generated HTML to the 'container' element
                    container.innerHTML += tileHTML;
                    return; // Exit the function if no data is found
                }
                
                // Iterate over the fetched data grouped by date
                for (const [date, recordsOnDate] of Object.entries(dataByDate)) {

                    const div = document.createElement('div');
                    div.classList.add('mb-4');
    
                    const storedDate = new Date(date);
    
                    const today = new Date();
                    
                    const yesterday = new Date();
                    yesterday.setDate(yesterday.getDate() - 1);
    
                    // Define options for formatting the date
                    const dateOptions = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    };
                    // Format the date to a readable string
                    const formattedDate = storedDate.toLocaleDateString('en-US', dateOptions);
    
                    const isToday = today.toDateString() === storedDate.toDateString();
                    const isYesterday = yesterday.toDateString() === storedDate.toDateString();
                    
                    const dateHeader = document.createElement('div');
                    dateHeader.classList.add('text-start', 'text-muted', 'mb-2');
                    dateHeader.innerHTML = isToday ? `<strong>Today<strong>` : isYesterday ? `<strong>Yesterday<strong>` : `<strong>${formattedDate}</strong>`;
                    div.appendChild(dateHeader);
    
                    const table = document.createElement('table');
                    table.classList.add('table', 'table-bordered');
                    const tbody = document.createElement('tbody');
                    
                    recordsOnDate.forEach(record => {
                        const tr = document.createElement('tr');
    
                        // Set the onclick event to redirect when a row is clicked, unless a button is clicked
                        tr.onclick = (event) => {
                            if (!event.target.closest('button')) { 
                                window.location.href = `../../pages/user/abstractView.php?abstractId=${record.record_id}`;
                            }
                        };
    
                        const recordCell = document.createElement('td');
                        recordCell.classList.add('col-md-11', 'text-start');
                        recordCell.textContent = record.record;
                        tr.appendChild(recordCell);
    
                        const buttonCell = document.createElement('td');
                        buttonCell.classList.add('col-md-1', 'text-center');
                        const button = document.createElement('button');
                        button.classList.add('btn', 'btn-danger', 'btn-sm', 'mx-1', 'delete-button');
                        button.innerHTML = '<i class="fas fa-trash-alt"></i>';  // Trash can icon
    
                        button.onclick = () => {
                            window.location.href = `../../backend/delete.php?historyId=${record.history_id}`;
                        };
    
                        buttonCell.appendChild(button);
                        tr.appendChild(buttonCell);
    
                        tbody.appendChild(tr);
                    });
    
                    // Append the table to the div and the div to the container
                    table.appendChild(tbody);
                    div.appendChild(table);
                    container.appendChild(div);
                }
            })
            .catch(error => console.error('Error fetching histories:', error)); // Log any errors
    });
}
