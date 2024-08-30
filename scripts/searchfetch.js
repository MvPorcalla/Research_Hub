document.addEventListener('DOMContentLoaded', function() {
    const queryInput = document.querySelector('#query');
    
    let recordTableBody, lrnTableBody, studentTableBody, guestTableBody, recordType;
    if (document.getElementById(`records-table`)) {
        recordTableBody = document.querySelector(`#records-table tbody`);
        recordType = 'record';
    } else if (document.getElementById(`users-table`)) {
        studentTableBody = document.querySelector(`#students-table tbody`);
        guestTableBody = document.querySelector(`#guests-table tbody`);
    } else if (document.getElementById(`lrns-table`)) {
        lrnTableBody = document.querySelector(`#lrns-table tbody`);
        recordType = 'lrn';
    } else if (document.getElementById(`abstractTiles`)) {
        recordTableBody = document.getElementById(`abstractTiles`);
        recordType = 'record';
    }

    const tableBodies = {
        record: recordTableBody,
        student: studentTableBody,
        guest: guestTableBody,
        lrn: lrnTableBody
    };

    function fetchRecords(recordType, query = '') {
        
        fetch(`../../backend/searchfetch.php?record_type=${encodeURIComponent(recordType)}&query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                console.log('Data received:', data); // Debugging line                

                let rows = '';

                if (data.length === 0) {
                    rows = '<tr><td colspan="6">No records found.</td></tr>';
                } else {
                    switch (recordType) {
                        case 'record':
                            data.forEach(record => {
                                var url = window.location.href;
                                if (url.includes('admin')) {
                                    const month = Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, record.record_month - 1));
                                    rows += `
                                        <tr onclick="window.location.href='abstractView.php?abstractId=${record.record_id}';" style="cursor: pointer;">
                                            <td>${highlightText(record.record_title, query)}</td>
                                            <td>${highlightText(month + ' ' + record.record_year, query)}</td>
                                            <td>${highlightText(record.record_authors, query)}</td>
                                            <td>${highlightText(record.record_trackstrand, query)}</td>
                                            <td>
                                                <a href="abstract.php?abstractId=${record.record_id}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                                <a href="../../backend/delete.php?abstractId=${record.record_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                } else {
                                    rows += `
                                        <div class="col-12 mb-2">
                                            <div class="card">
                                                <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${record.record_id}'; }" style="cursor: pointer;">
                                                    <div class="row text-center">
                                                        <div class="col-md-2 d-flex align-items-center justify-content-center border-end">
                                                            <img src="https://via.placeholder.com/75x100" class="img-fluid rounded-1" alt="${record.record_title}">
                                                        </div>
                                                        <div class="col-md-8 d-flex align-items-center justify-content-start border-end">${highlightText(record.record_title, query)}</div>
                                                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                            <button class="btn btn-outline-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#commentsModal" data-record-id="${record.record_id}" data-record-title="${record.record_title}">
                                                                <i class="fas fa-comment"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${record.record_id}">
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
                                }
                            });
                            break;
                        case 'student':
                            data.forEach(record => {
                                rows += `
                                    <tr>
                                        <td>${highlightText(record.user_lastname, query)}</td>
                                        <td>${highlightText(record.user_firstname, query)}</td>
                                        <td>${highlightText(record.user_mi, query)}</td>
                                        <td>${highlightText(record.lrn_lrnid, query)}</td>
                                        <td>${highlightText(record.user_trackstrand, query)}</td>
                                        <td>
                                            <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                        </td>
                                    </tr>
                                `;
                            });
                            break;
                        case 'guest':
                            data.forEach(record => {
                                rows += `
                                    <tr>
                                        <td>${highlightText(record.user_lastname, query)}</td>
                                        <td>${highlightText(record.user_firstname, query)}</td>
                                        <td>${highlightText(record.user_mi, query)}</td>
                                        <td>${highlightText(record.user_school, query)}</td>
                                        <td>
                                            <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                        </td>
                                    </tr>
                                `;
                            });
                            break;
                        case 'lrn':
                            data.forEach(record => {
                                rows += `
                                    <tr>
                                        <td>${highlightText(record.lrn_student, query)}</td>
                                        <td>${highlightText(record.lrn_lrnid, query)}</td>
                                        <td>
                                            <a href="lrn.php?lrnId=${record.lrn_id}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                            <a href="../../backend/delete.php?lrnId=${record.lrn_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                        </td>
                                    </tr>
                                `;
                            });
                            break;
                    }
                }

                tableBodies[recordType].innerHTML = rows;
            })
            .catch(error => {
                console.error('Error fetching records:', error);
            });
    }

    function highlightText(text, query) {
        if (!query) return text;
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp('(' + escapedQuery + ')', 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }

    if (document.getElementById(`users-table`)) {
        fetchRecords('student');
        fetchRecords('guest');
    } else {
        fetchRecords(recordType);
    }

    queryInput.addEventListener('input', function() {
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query);
        }
    });

    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query);
        }
    });
});
