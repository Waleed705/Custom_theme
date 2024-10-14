<?php
/**
 * Template Name: to-do
 */
get_header();
wp_head();
?>
<div class="todo-container">
    <h2>To-Do List</h2>
    <form action="" id="todo-form">
    <div class="todo-main">
        <input type="text" id="task-input" placeholder="Add a new task..." required>
        <button id="add-button" type="submit">Add</button>
        <ul id="task-list"></ul>
    </div>
    <button id="logout-button" type="button">Logout</button> <!-- Logout Button -->
</form>

    <style>
        .To-Do-main{
            display:flex;
        }
        .todo-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: fit-content;
            margin: 20px auto;
        }
        .todo-main>input[type="text"] {
            width: calc(70% - 10px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .todo-main>button {
            margin-left:10px;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
       .todo-main>ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        .todo-main>li {
            background: #f8f8f8;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .delete-button {
            background: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 5px 10px;
        }
        .completed {
            text-decoration: line-through;
            color: #999;
        }
    </style>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load existing tasks
    function loadTasks() {
        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            method: "POST",
            data: { action: 'load_tasks' },
            success: function(data) {
                $('#task-list').html(data);
            }
        });
    }
    loadTasks();
    // Add new task
    $('#add-button').click(function(e) {
        e.preventDefault();
        const taskValue = $('#task-input').val().trim();
        if (taskValue) {
            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                method: "POST",
                data: {
                    action: 'add_task',
                    task: taskValue
                },
                success: function(response) {
                    response = JSON.parse(response);
                    debugger;
                    if ( response && response.status == 'success' ) {
                        loadTasks();
                        $('#task-input').val('');
                    } else {
                        alert(response.message ? response.message : 'An error occurred');
                    }
                }
            });
        }
    });
    // Delete task
    $(document).on('click', '.delete-button', function() {
        const taskId = $(this).data('id');

        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            method: "POST",
            data: {
                action: 'delete_task',
                id: taskId
            },
            success: function() {
                loadTasks();
            }
        });
    });
    // Mark task as completed
    $(document).on('click', 'li', function() {
        const taskId = $(this).data('id');
        const completed = $(this).hasClass('completed') ? 0 : 1;
        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            method: "POST",
            data: {
                action: 'toggle_task',
                id: taskId,
                completed: completed
            },
            success: function() {
                loadTasks();
            }
        });
    });
    // Handle logout button click
    $('#logout-button').on('click', function() {
        
        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>", 
            type: 'POST',
            data: {
                action: 'logout_user' 
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                } else {
                    alert('Logout failed. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Logout Error:', xhr.responseText); 
                alert('An error occurred while logging out. Please try again.');
            }
        });
    });
});
</script>
<?php
get_footer();
?>
