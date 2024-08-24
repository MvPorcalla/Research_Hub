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
                                    <a href="abstract.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
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
                                    <a href="lrn.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                    <a href="../delete.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                </td>`;
                            break;
                    }
                    tableBody.innerHTML += `<tr>${rowHTML}</tr>`;
                });

                let options = '';
                switch (foundClass) {
                    case 'abstracts':
                        options = {
                            multiTd: false,
                            actionText: "You are about to delete",
                            confirmButtonText: "Delete"
                        };
                        break;
                    case 'LRNs':
                        options = {
                            multiTd: false,
                            actionText: "You are about to delete the LRN of:",
                            confirmButtonText: "Delete"
                        };
                        break;
                    default:
                        options = {
                            multiTd: true,
                            tdCount: 3, // Number of <td> elements to extract text from
                            actionText: "You are about to deactivate the account of",
                            confirmButtonText: "Deactivate"
                        };
                        break;

                }
                setupConfirmationDialog('.delete-button', options);
            }

            if (document.getElementById('pendingTiles')) {

                const pendingTiles = document.getElementById('pendingTiles');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=pending`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                pendingTiles.innerHTML = '';

                data.forEach(dataRow => {
                    let tileHTML = `
                        <div class="col-md-6 mb-4">
                            <div class="card border-dark rounded-4 h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center flex-grow-1">${escapeHTML(dataRow.fname)} ${escapeHTML(dataRow.mi)}. ${escapeHTML(dataRow.lname)}</h5>
                                    <p class="card-text text-center">${escapeHTML(dataRow.email)}</p>
                                    <p class="card-text text-center">${escapeHTML(dataRow.school)}</p>
                                    
                                    <div class="border border-secondary rounded p-2 mb-3">
                                        <p class="card-text text-center fw-bold mb-1">Reason</p>
                                        <p class="card-text text-center">${escapeHTML(dataRow.reason)}</p>
                                    </div>
                                    <div class="d-flex justify-content-center mt-auto">
                                        <a href="#" class="btn btn-primary btn-sm me-2">Accept</a>
                                        <a href="#" class="btn btn-danger btn-sm">Decline</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    pendingTiles.innerHTML += `<tr>${tileHTML}</tr>`;
                });

            }
        } catch (error) {
            console.error('Error fetching records:', error);
        }
    };

    fetchRecords();
});
