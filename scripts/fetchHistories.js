var url = window.location.href;

if (url.includes('history')) {
    document.addEventListener('DOMContentLoaded', () => {
        const userId = 27; // Replace with the user ID you want to filter by
    
        fetch(`../../backend/fetch_histories.php?userId=${userId}`)
            .then(response => response.json())
            .then(dataByDate => {
                const container = document.getElementById('historyContainer');
                
                for (const [date, recordsOnDate] of Object.entries(dataByDate)) {
                    const div = document.createElement('div');
                    div.classList.add('mb-4');
    
                    const storedDate = new Date(date);
    
                    const today = new Date();
                    
                    const yesterday = new Date();
                    yesterday.setDate(yesterday.getDate() - 1);
    
                    const dateOptions = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    };
                    const formattedDate = storedDate.toLocaleDateString('en-US', dateOptions);
    
                    const isToday = today.toDateString() === storedDate.toDateString();
                    const isYesterday = yesterday.toDateString() === storedDate.toDateString();
                    
                    // Date header
                    const dateHeader = document.createElement('div');
                    dateHeader.classList.add('text-start', 'text-muted', 'mb-2');
                    dateHeader.innerHTML = isToday ? `<strong>Today<strong>` : isYesterday ? `<strong>Yesterday<strong>` : `<strong>${formattedDate}</strong>`;
                    div.appendChild(dateHeader);
    
                    // Table element
                    const table = document.createElement('table');
                    table.classList.add('table', 'table-bordered');
                    const tbody = document.createElement('tbody');
                    
                    // Records rows
                    recordsOnDate.forEach(record => {
                        const tr = document.createElement('tr');
    
                        // Set the onclick event
                        tr.onclick = (event) => {
                            if (!event.target.closest('button')) { 
                                window.location.href = `../../pages/user/abstractView.php?abstractId=${record.record_id}`;
                            }
                        };
    
                        // Record cell
                        const recordCell = document.createElement('td');
                        recordCell.classList.add('col-md-11', 'text-start');
                        recordCell.textContent = record.record;
                        tr.appendChild(recordCell);
    
                        // Delete button cell
                        const buttonCell = document.createElement('td');
                        buttonCell.classList.add('col-md-1', 'text-center');
                        const button = document.createElement('button');
                        button.classList.add('btn', 'btn-danger', 'btn-sm', 'mx-1', 'delete-button');
                        button.innerHTML = '<i class="fas fa-trash-alt"></i>';  // Trash can icon
    
                        // Set the onclick event
                        button.onclick = () => {
                            window.location.href = `../../backend/delete.php?historyId=${record.history_id}`;
                        };
    
                        buttonCell.appendChild(button);
                        tr.appendChild(buttonCell);
    
                        tbody.appendChild(tr);
                    });
    
                    table.appendChild(tbody);
                    div.appendChild(table);
                    container.appendChild(div);
                }
            })
            .catch(error => console.error('Error fetching histories:', error));
    });
}