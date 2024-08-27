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
                                <tr onclick="window.location.href='abstractView.php?abstractId=${escapeHTML(dataRow.id)}';" style="cursor: pointer;">
                                    <td>${escapeHTML(dataRow.title)}</td>
                                    <td>${escapeHTML(dataRow.yearmonth)}</td>
                                    <td>${escapeHTML(dataRow.authors)}</td>
                                    <td>${escapeHTML(dataRow.trackstrand)}</td>
                                    <td>
                                        <a href="abstract.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'students':
                            rowHTML = `
                                <tr>
                                    <td>${escapeHTML(dataRow.fname)}</td>
                                    <td>${escapeHTML(dataRow.mi)}</td>
                                    <td>${escapeHTML(dataRow.lname)}</td>
                                    <td>${escapeHTML(dataRow.lrn)}</td>
                                    <td>${escapeHTML(dataRow.track)}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'guests':
                            rowHTML = `
                                <tr>
                                    <td>${escapeHTML(dataRow.fname)}</td>
                                    <td>${escapeHTML(dataRow.mi)}</td>
                                    <td>${escapeHTML(dataRow.lname)}</td>
                                    <td>${escapeHTML(dataRow.school)}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'LRNs':
                            rowHTML = `
                                <tr>
                                    <td>${escapeHTML(dataRow.fullname)}</td>
                                    <td>${escapeHTML(dataRow.lrn)}</td>
                                    <td>
                                        <a href="lrn.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                    }
                    tableBody.innerHTML += rowHTML;
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
                                        <a href="../../backend/pending_actions.php?accept=${escapeHTML(dataRow.id)}" class="btn btn-primary btn-sm me-2">Accept</a>
                                        <a href="../../backend/pending_actions.php?decline=${escapeHTML(dataRow.id)}" class="btn btn-danger btn-sm">Decline</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    pendingTiles.innerHTML += tileHTML;
                });
            }

            if (document.getElementById('abstractTiles')) {

                const abstractTiles = document.getElementById('abstractTiles');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=abstracts`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                abstractTiles.innerHTML = '';

                data.forEach(dataRow => {
                    let tileHTML = `
                        <div class="col-12 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-2 d-flex align-items-center justify-content-center border-end">
                                            <img src="https://via.placeholder.com/75x100" class="img-fluid rounded-1" alt="${escapeHTML(dataRow.title)}">
                                        </div>
                                        <div class="col-md-8 d-flex align-items-center justify-content-start border-end">${escapeHTML(dataRow.title)}</div>
                                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-primary btn-sm mx-1">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${escapeHTML(dataRow.id)}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <button class="btn btn-outline-success btn-sm mx-1">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    abstractTiles.innerHTML += tileHTML;
                });
            }

            if (document.getElementById('favoriteTiles')) {

                const favoriteTiles = document.getElementById('favoriteTiles');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=favorites`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                data.forEach(dataRow => {
                    let tileHTML = `
                        <div class="col-12 mb-2">
                            <div class="card border-dark rounded-4">
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-11 d-flex align-items-center justify-content-start border-end">${escapeHTML(dataRow.title)}</div>
                                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${escapeHTML(dataRow.record_id)}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    favoriteTiles.innerHTML += tileHTML;
                });
            }
        } catch (error) {
            console.error('Error fetching records:', error);
        }
    };

    fetchRecords().then(() => {
        var url = window.location.href;

        if (url.includes('pages/user')) {
            const updateButtonStatuses = () => {

                let userIdElement = document.getElementById('abstractTiles') || document.getElementById('favoriteTiles');
                const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
                const buttons = document.querySelectorAll('.like-button');
                
                const requests = Array.from(buttons).map(button => {
                    const recordId = button.getAttribute('data-record-id');
                    
                    return fetch(`../../backend/get_like_status.php?recordId=${recordId}&userId=${userId}`)
                        .then(response => response.json())
                        .then(data => {

                            if (data.like_status === 'A') {
                                button.classList.add('btn-danger');
                                button.classList.remove('btn-outline-danger');
                            } else {
                                button.classList.add('btn-outline-danger');
                                button.classList.remove('btn-danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching like status:', error);
                        });
                });
        
                // Ensure all requests are completed
                Promise.all(requests).then(() => {
                    console.log('All like statuses updated');
                });
            };
        
            // Call the function to update button statuses
            updateButtonStatuses();
        }
    });
});
