function clearForm() {
    // Get references to form fields
    var taskNameField = document.getElementById('task_name');
    var priorityField = document.getElementById('priority');
    var descriptionField = document.getElementById('description');

    // Reset form field values
    taskNameField.value = '';
    priorityField.value = '';
    descriptionField.value = '';
}

function validateForm() {
    document.getElementById('taskNameError').innerText = '';
    document.getElementById('priorityError').innerText = '';

    var taskName = document.getElementById('task_name').value.trim();
    var priority = document.getElementById('priority').value;

    // Reset error messages before each form submission attempt
    if (taskName === '') {
        document.getElementById('taskNameError').innerText = '*Please enter a task name.';
    }

    if (priority === '') {
        document.getElementById('priorityError').innerText = '*Please select a priority.';
    }

    // If there is any error, do not submit the form
    if (taskName === '' || priority === '') {
        return false;
    }

    // Additional custom checks can be added as needed

    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM content loaded'); // Check if this log appears in the console

    // Add an event listener to all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            console.log('Delete button clicked for task ID:', taskId); // Check if this log appears in the console
            deleteTask(taskId);
        });
    });

    // Function to handle asynchronous deletion
    function deleteTask(taskId) {
        console.log('Attempting to delete task with ID:', taskId);
    
        // Make an AJAX request to the server to delete the task
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_task.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log('AJAX request completed');
                if (xhr.status === 200) {
                    // Check if the response indicates successful deletion
                    if (xhr.responseText.trim() === 'Task deleted successfully') {
                        // Refresh the task list after deletion
                        location.reload();
                    } else {
                        console.error("Error deleting task:", xhr.responseText);
                    }
                } else {
                    console.error("Error deleting task:", xhr.statusText);
                }
            }
        };
        xhr.send(`task_id=${taskId}`);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // ... (Vaše stávající kód)

    // Event listener pro tlačítko "Complete"
    const completeButtons = document.querySelectorAll('.complete-btn');
    completeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            console.log('Complete button clicked for task ID:', taskId);

            completeTask(taskId);
        });
    });

    // Funkce pro asynchronní dokončení úkolu
    function completeTask(taskId) {
        console.log('Attempting to complete task with ID:', taskId);

        // Vytvoření AJAX požadavku k serveru pro dokončení úkolu
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'complete_task.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log('AJAX request completed');
                if (xhr.status === 200) {
                    // Znovunačtení seznamu úkolů po dokončení
                    location.reload();
                } else {
                    console.error("Error completing task:", xhr.statusText);
                }
            }
        };
        xhr.send(`task_id=${taskId}`);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Add an event listener to the form for submission validation
    var addTaskForm = document.querySelector('form');
    addTaskForm.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent the form from submitting if validation fails
        }
    });

    // Add an event listener to all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            console.log('Delete button clicked for task ID:', taskId);
            deleteTask(taskId);
        });
    });

    // Add an event listener to edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            openEditModal(taskId);
        });
    });

    // Add an event listener to close button in the edit modal
    const closeBtn = document.querySelector('.close');
    closeBtn.addEventListener('click', function () {
        closeEditModal();
    });

    // Function to open the edit modal
    function openEditModal(taskId) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var taskDetails = JSON.parse(this.responseText);

                document.getElementById("editTaskId").value = taskDetails.task_id;
                document.getElementById("editTaskName").value = taskDetails.task;
                document.getElementById("editPriority").value = taskDetails.priority;
                document.getElementById("editDescription").value = taskDetails.description;

                document.getElementById("editTaskModal").style.display = "block";
            }
        };
        xhr.open("GET", "get_task_details.php?task_id=" + taskId, true);
        xhr.send();
    }

    // Function to close the edit modal
    function closeEditModal() {
        console.log('Closing modal');
    
        var modal = document.getElementById('editTaskModal');
    
        // Close the modal
        if (modal) {
            modal.style.display = 'none';
        }
    }

    window.addEventListener('click', function (event) {
        var editModal = document.getElementById('editTaskModal');
        if (event.target == editModal) {
            closeEditModal();
        }
    });
    
    // Add an event listener to the save changes button in the edit modal
    const saveEditBtn = document.getElementById('saveEditBtn');
    saveEditBtn.addEventListener('click', function () {
        var editedTaskId = document.getElementById("editTaskId").value;
        var editedTaskName = document.getElementById("editTaskName").value;
        var editedPriority = document.getElementById("editPriority").value;
        var editedDescription = document.getElementById("editDescription").value;

        console.log("Task ID:", editedTaskId);
        console.log("Task Name:", editedTaskName);
        console.log("Priority:", editedPriority);
        console.log("Description:", editedDescription);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_task.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                console.log('AJAX request completed');
                if (xhr.status == 200) {
                    if (xhr.responseText.trim() === 'Task updated successfully') {
                        location.reload();
                    } else {
                        console.error("Error updating task:", xhr.responseText);
                    }
                } else {
                    console.error("Error updating task:", xhr.statusText);
                }
            }
        };
        xhr.send("task_id=" + editedTaskId +
            "&task_name=" + editedTaskName +
            "&priority=" + editedPriority +
            "&description=" + editedDescription);

        closeEditModal();
    });
});

