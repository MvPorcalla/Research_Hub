// fetchRecords.js - Fetch records for admin index.php

document.addEventListener('DOMContentLoaded', () => {
    const classes = ['abstracts', 'students', 'guests', 'LRNs'];

    const escapeHTML = str => str.replace(/&/g, "&amp;")
                                 .replace(/</g, "&lt;")
                                 .replace(/>/g, "&gt;")
                                 .replace(/"/g, "&quot;")
                                 .replace(/'/g, "&#039;");
    
    const fetchRecords = async () => {
        try {
            for (let table of document.querySelectorAll('table')) {
                let foundClass = classes.find(cls => table.classList.contains(cls));
                if (!foundClass) continue;

                const response = await fetch(`../../backend/fetchRecords.php?fetch=${foundClass}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                const tableBody = table.querySelector('tbody');
                tableBody.innerHTML = '';

                data.forEach(dataRow => {
                    let rowHTML = '';
                    switch (foundClass) {
                        case 'abstracts':
                            rowHTML = `
                                <td>${escapeHTML(dataRow.title)}</td>
                                <td>${escapeHTML(dataRow.yearmonth)}</td>
                                <td>${escapeHTML(dataRow.authors)}</td>
                                <td>
                                    <a href="record.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                    <a href="../../backend/delete.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                </td>`;
                            break;
                        case 'students':
                            rowHTML = `
                                <td>${escapeHTML(dataRow.fname)}</td>
                                <td>${escapeHTML(dataRow.mi)}</td>
                                <td>${escapeHTML(dataRow.lname)}</td>
                                <td>${escapeHTML(dataRow.lrn)}</td>
                                <td>${escapeHTML(dataRow.track)}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                    <a href="../delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                </td>`;
                            break;
                        case 'guests':
                            rowHTML = `
                                <td>${escapeHTML(dataRow.fname)}</td>
                                <td>${escapeHTML(dataRow.mi)}</td>
                                <td>${escapeHTML(dataRow.lname)}</td>
                                <td>${escapeHTML(dataRow.school)}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                    <a href="../delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                </td>`;
                            break;
                        case 'LRNs':
                            rowHTML = `
                                <td>${escapeHTML(dataRow.fullname)}</td>
                                <td>${escapeHTML(dataRow.lrn)}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                    <a href="../delete.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                </td>`;
                            break;
                    }
                    tableBody.innerHTML += `<tr>${rowHTML}</tr>`;
                });

                setupConfirmationDialog('.delete-button', {
                    multiTd: false,
                    actionText: "You are about to delete",
                    confirmButtonText: "Delete"
                });
            }
        } catch (error) {
            console.error('Error fetching records:', error);
        }
    };

    fetchRecords();
});
