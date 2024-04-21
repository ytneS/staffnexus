function clearForm() {
    var taskNameField = document.getElementById('task_name');
    var priorityField = document.getElementById('priority');
    var descriptionField = document.getElementById('description');

    taskNameField.value = '';
    priorityField.value = '';
    descriptionField.value = '';
}

function validateForm() {
    document.getElementById('taskNameError').innerText = '';
    document.getElementById('priorityError').innerText = '';

    var taskName = document.getElementById('task_name').value.trim();
    var priority = document.getElementById('priority').value;

    if (taskName === '') {
        document.getElementById('taskNameError').innerText = '*Please enter a task name.';
    }

    if (priority === '') {
        document.getElementById('priorityError').innerText = '*Please select a priority.';
    }

    if (taskName === '' || priority === '') {
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM content loaded'); 

    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            console.log('Delete button clicked for task ID:', taskId); 
            deleteTask(taskId);
        });
    });

    function deleteTask(taskId) {
        console.log('Attempting to delete task with ID:', taskId);
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_task.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log('AJAX request completed');
                if (xhr.status === 200) {
                    if (xhr.responseText.trim() === 'Task deleted successfully') {
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
    const completeButtons = document.querySelectorAll('.complete-btn');
    completeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            console.log('Complete button clicked for task ID:', taskId);

            completeTask(taskId);
        });
    });

    function completeTask(taskId) {
        console.log('Attempting to complete task with ID:', taskId);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'complete_task.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log('AJAX request completed');
                if (xhr.status === 200) {
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
    var addTaskForm = document.querySelector('form');
    addTaskForm.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault(); 
        }
    });

    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            console.log('Delete button clicked for task ID:', taskId);
            deleteTask(taskId);
        });
    });

    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-taskid');
            openEditModal(taskId);
        });
    });

    const closeBtn = document.querySelector('.close');
    closeBtn.addEventListener('click', function () {
        closeEditModal();
    });

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

    function closeEditModal() {
        console.log('Closing modal');
    
        var modal = document.getElementById('editTaskModal');
    
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

