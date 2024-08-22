// fetchRecords.js
// use for fetching records in the admin index.php

// Function to escape HTML entities
function escapeHTML(str) {
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

document.addEventListener('DOMContentLoaded', () => {
    const fetchRecords = async () => {
        try {
            // Fetch the records from fetchRecords.php
            const response = await fetch('../../backend/fetchRecords.php');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json(); // Parse JSON response

            // Reference to the table body
            const tableBody = document.querySelector('tbody');

            // Clear any existing content
            tableBody.innerHTML = '';

            // Populate the table with data
            data.forEach(record => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${escapeHTML(record.title)}</td>
                    <td>${escapeHTML(record.year)}</td>
                    <td>${escapeHTML(record.month)}</td>
                    <td>
                        <a href="./editRecord.php?id=${encodeURIComponent(record.record_id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                        <a href="./delete.php?id=${encodeURIComponent(record.record_id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } catch (error) {
            console.error('Error fetching records:', error);
        }
    };

    // Fetch records when the page loads
    fetchRecords();
});
