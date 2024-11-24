// document.addEventListener("DOMContentLoaded", () => {
//     // Add Form Validation and Submission
//     document.querySelector("#addForm").addEventListener("submit", function (e) {
//         e.preventDefault();

//         // Clear previous error messages
//         clearErrors(this);

//         const nameField = this.querySelector('input[placeholder="Name"]');
//         const placeField = this.querySelector('input[placeholder="Place"]');

//         const name = nameField.value.trim();
//         const place = placeField.value.trim();

//         let isValid = true;

//         // Validate Name
//         if (!name) {
//             displayError(nameField, "Name cannot be blank.");
//             isValid = false;
//         }

//         // Validate Place
//         if (!place) {
//             displayError(placeField, "Place cannot be blank.");
//             isValid = false;
//         }

//         if (!isValid) return;

//         // Submit data to the server
//         fetch("function.php", {
//             method: "POST",
//             headers: { "Content-Type": "application/json" },
//             body: JSON.stringify({ action: "add", name, place })
//         })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.status === "success") {
//                     alert(data.message);
//                     location.reload();
//                 } else {
//                     alert(data.message);
//                 }
//             })
//             .catch(error => console.error("Error:", error));
//     });

//     // Event delegation for Update buttons
//     document.querySelectorAll('.btn-warning').forEach(button => {
//         button.addEventListener('click', function() {
//             // Get data from the clicked button's parent row
//             const row = this.closest('tr');
//             const id = row.querySelector('td:nth-child(1)').textContent;  // SI No (which is the ID)
//             const name = row.querySelector('td:nth-child(2)').textContent;  // Name
//             const place = row.querySelector('td:nth-child(3)').textContent; // Place

//             // Set the modal fields with the fetched data
//             document.querySelector('#updateId').value = id;
//             document.querySelector('#updateName').value = name;
//             document.querySelector('#updatePlace').value = place;
//         });
//     });

//     // Update Form Validation and Submission
//     document.querySelector("#updateForm").addEventListener("submit", function(e) {
//         e.preventDefault();

//         // Clear previous error messages
//         clearErrors(this);

//         const idField = this.querySelector('input[name="id"]');
//         const nameField = this.querySelector('input[name="name"]');
//         const placeField = this.querySelector('input[name="place"]');

//         const id = idField.value.trim();
//         const name = nameField.value.trim();
//         const place = placeField.value.trim();

//         let isValid = true;

//         // Validate ID
//         if (!id) {
//             alert("Invalid entry. Please refresh and try again.");
//             return;
//         }

//         // Validate Name
//         if (!name) {
//             displayError(nameField, "Name cannot be blank.");
//             isValid = false;
//         }

//         // Validate Place
//         if (!place) {
//             displayError(placeField, "Place cannot be blank.");
//             isValid = false;
//         }

//         if (!isValid) return;

//         // Submit data to the server
//         fetch("function.php", {
//             method: "POST",
//             headers: { "Content-Type": "application/json" },
//             body: JSON.stringify({ action: "update", id, name, place })
//         })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.status === "success") {
//                     alert(data.message);
//                     location.reload();
//                 } else {
//                     alert(data.message);
//                 }
//             })
//             .catch(error => console.error("Error:", error));
//     });

//     // Delete button click handler
//     document.querySelectorAll('.deleteBtn').forEach(button => {
//         button.addEventListener('click', function() {
//             const playerId = this.getAttribute('data-id');

//             // Confirm deletion
//             if (confirm("Are you sure you want to delete this player?")) {
//                 // Send delete request to update status to 0
//                 fetch('function.php', {
//                     method: 'POST',
//                     headers: { 'Content-Type': 'application/json' },
//                     body: JSON.stringify({ delete_id: playerId })
//                 })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.status === "success") {
//                         alert(data.message);
//                         location.reload(); // Reload to reflect changes
//                     } else {
//                         alert(data.message);
//                     }
//                 })
//                 .catch(error => console.error("Error:", error));
//             }
//         });
//     });

//     // Utility function to display error messages
//     function displayError(input, message) {
//         const errorSpan = document.createElement("span");
//         errorSpan.className = "errortext text-danger small";
//         errorSpan.innerText = message;

//         input.classList.add("is-invalid");
//         input.parentNode.insertBefore(errorSpan, input.nextSibling);
//     }

//     // Utility function to clear previous error messages
//     function clearErrors(form) {
//         form.querySelectorAll(".errortext").forEach(error => error.remove());
//         form.querySelectorAll(".is-invalid").forEach(input => input.classList.remove("is-invalid"));
//     }
// });

document.addEventListener("DOMContentLoaded", () => {
    // Add Form Validation and Submission (for Add)
    document.querySelector("#addForm").addEventListener("submit", function (e) {
        e.preventDefault();
        clearErrors(this);

        const nameField = this.querySelector('input[placeholder="Name"]');
        const placeField = this.querySelector('input[placeholder="Place"]');

        const name = nameField.value.trim();
        const place = placeField.value.trim();

        let isValid = true;

        if (!name) {
            displayError(nameField, "Name cannot be blank.");
            isValid = false;
        }

        if (!place) {
            displayError(placeField, "Place cannot be blank.");
            isValid = false;
        }

        if (!isValid) return;

        fetch("function.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "add", name, place })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Error:", error));
    });

    // Event delegation for Update buttons
    document.querySelectorAll('.btn-warning').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.querySelector('td:nth-child(1)').textContent;
            const name = row.querySelector('td:nth-child(2)').textContent;
            const place = row.querySelector('td:nth-child(3)').textContent;

            document.querySelector('#updateId').value = id;
            document.querySelector('#updateName').value = name;
            document.querySelector('#updatePlace').value = place;
        });
    });

    // Update Form Validation and Submission
    document.querySelector("#updateForm").addEventListener("submit", function(e) {
        e.preventDefault();

        clearErrors(this);

        const idField = this.querySelector('input[name="id"]');
        const nameField = this.querySelector('input[name="name"]');
        const placeField = this.querySelector('input[name="place"]');

        const id = idField.value.trim();
        const name = nameField.value.trim();
        const place = placeField.value.trim();

        let isValid = true;

        if (!id) {
            alert("Invalid entry. Please refresh and try again.");
            return;
        }

        if (!name) {
            displayError(nameField, "Name cannot be blank.");
            isValid = false;
        }

        if (!place) {
            displayError(placeField, "Place cannot be blank.");
            isValid = false;
        }

        if (!isValid) return;

        fetch("function.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "update", id, name, place })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Error:", error));
    });

    // Delete button click handler (only for deleting status)
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function() {
            const playerId = this.getAttribute('data-id');

            // Confirm deletion
            if (confirm("Are you sure you want to delete this player?")) {
                // Send request to update status to 0
                fetch('function.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ delete_id: playerId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        location.reload(); // Reload to reflect changes
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });

    // Utility function to display error messages
    function displayError(input, message) {
        const errorSpan = document.createElement("span");
        errorSpan.className = "errortext text-danger small";
        errorSpan.innerText = message;

        input.classList.add("is-invalid");
        input.parentNode.insertBefore(errorSpan, input.nextSibling);
    }

    // Utility function to clear previous error messages
    function clearErrors(form) {
        form.querySelectorAll(".errortext").forEach(error => error.remove());
        form.querySelectorAll(".is-invalid").forEach(input => input.classList.remove("is-invalid"));
    }

});

document.getElementById('activityLogBtn').addEventListener('click', function() {
    // Fetch the activity log data using AJAX
    fetch('get_activity_log.php')  // Replace with the actual PHP file to fetch data
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Populate the table with activity log data
            let logContent = '';
            data.activities.forEach((activity, index) => {
                // Generate SI No based on the index (starting from 1)
                logContent += `
                    <tr>
                        <td>${index + 1}</td> <!-- SI No -->
                        <td>${activity.action}</td>
                        <td>${activity.description}</td>
                        <td>${activity.status}</td>
                        <td>${activity.time}</td>
                        <td>${activity.device}</td>
                    </tr>
                `;
            });
            document.querySelector('#activityLogTable tbody').innerHTML = logContent;

            // Show the modal
            var activityLogModal = new bootstrap.Modal(document.getElementById('activityLogModal'));
            activityLogModal.show();
        } else {
            alert('Failed to fetch activity log.');
        }
    })
    .catch(error => console.error('Error fetching activity log:', error));
});


// Download activity log as CSV
document.getElementById('downloadBtn').addEventListener('click', function() {
    const rows = document.querySelectorAll('#activityLogTable tr');
    let csvContent = "SI No,Action,Description,Status,Time,Device\n";

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = Array.from(cells).map(cell => cell.textContent);
        csvContent += rowData.join(",") + "\n";
    });

    // Create a download link
    const link = document.createElement('a');
    link.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvContent);
    link.download = 'activity_log.csv';
    link.click();
});
