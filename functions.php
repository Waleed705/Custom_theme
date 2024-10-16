<?php
    register_nav_menus(
        array('primary-menu'=>'Top Menu')
    );
    add_theme_Support('post-thumbnails');
    add_theme_Support('custom-header');
    register_sidebar(
        array(
            'name'=>'Sidebar Location',
            'id'=>'sidebar'
        )
    );
    add_theme_support('custom-background');

    function my_custom_styles() {
        wp_enqueue_style('theme-css', get_template_directory_uri() . '/style.css', [], false, 'all');
        wp_enqueue_style('custom-css', get_template_directory_uri() . '/asstets/css/custom-style.css', ['theme-css'], false, 'all');

    }
    add_action('wp_enqueue_scripts', 'my_custom_styles');
    
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-auth', get_template_directory_uri() . '/js/custom-auth.js', array('jquery'), null, true);
    wp_localize_script('custom-auth', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


add_action('wp_ajax_register_user', 'register_user_callback');
add_action('wp_ajax_nopriv_register_user', 'register_user_callback');

function register_user_callback() {
    global $wpdb; 
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    if (empty($name) || empty($email) || empty($password)) {
        wp_send_json_error('All fields are required.');
        wp_die();
    }


$existing_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_custom_users WHERE email = %s", $email));
if ($existing_user) {
    wp_send_json_error(array('messages' => 'Email already exists. Please use a different email.'));
    wp_die();
}
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $table_name = $wpdb->prefix . 'custom_users';
    $result = $wpdb->insert($table_name, array(
        'name' => $name,
        'email' => $email,
        'password' => $hashed_password,
    ));

    if ($result) {
        wp_send_json_success(array('status' => 'success', 'url' => home_url('/login-page')));
    } else {
        wp_send_json_error('An error occurred. Please try again.');
    }

    wp_die();
}

function handle_login_user() {
    global $wpdb;
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        wp_send_json_error('Email and Password are required.');
        wp_die();
    }
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_custom_users WHERE email = %s", $email));

    if ($user && password_verify($password, $user->password)) {
        set_transient('current_user',$user, 3600000000);
        wp_send_json_success(array('url' => home_url('/to_do-list'))); 
    } else {
        wp_send_json_error('Email or Password is incorrect.');
    }

    wp_die();
}

add_action('wp_ajax_login_user', 'handle_login_user');
add_action('wp_ajax_nopriv_login_user', 'handle_login_user'); 

add_action('wp_ajax_logout_user', 'handle_logout_user');

function handle_logout_user() {
    delete_transient('current_user');
    wp_send_json_success(array('redirect' => home_url('/login-page'))); 
}





// Load tasks
add_action('wp_ajax_load_tasks', 'load_tasks');
function load_tasks() {
    global $wpdb;
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;
    if(!empty($custom_user_id)){
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM todos WHERE user_id = %d", $custom_user_id));
        foreach ($results as $todo) {
            $completedClass = $todo->completed ? 'completed' : '';
            echo "<li class='$completedClass' data-id='{$todo->id}'><p class='task-text' >{$todo->task}</p> <button class='delete-button' data-id='{$todo->id}'>Delete</button><button class='update-button' data-id='{$todo->id}'>Update</button></li>";
        }
    }
    else{
        $error= $custom_user_id;
        echo $error;
    }
    wp_die();
}

add_action('wp_ajax_update_task', 'update_task');
function update_task() {
    global $wpdb;
    $task_id = intval($_POST['task_id']);
    $updated_task = sanitize_text_field($_POST['task']);
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;
    $existing_task = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM todos WHERE task = %s AND user_id = %d AND id != %d", 
        $updated_task, 
        $custom_user_id,
        $task_id
    ));

    if ($existing_task) {
        echo json_encode([ 'status' => 'error', 'message' => 'Task name already exists']);
        wp_die();
    } else {
        // Update the task in the database
        $wpdb->update(
            'todos',
            array('task' => $updated_task),
            array('id' => $task_id, 'user_id' => $custom_user_id),
            array('%s'),
            array('%d', '%d')
        );
        echo json_encode([ 'status' => 'success', 'message' => 'Task updated']);
        wp_die();
    }
}


// Add a new task
add_action('wp_ajax_add_task', 'add_task');
function add_task() {
    global $wpdb;
    $task = sanitize_text_field($_POST['task']);
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;
    $existing_task = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM todos WHERE task = %s AND user_id = %d", 
        $task, 
        $custom_user_id

    ));
    if ($existing_task) {
        echo json_encode([ 'status' => 'error', 'message' => 'Task already taken']);
        wp_die();
    }
    else{
        $wpdb->insert('todos', array('task' => $task, 'user_id' => $custom_user_id));
        echo json_encode([ 'status' => 'success']);
        wp_die();
    }
}



// Delete a task
add_action('wp_ajax_delete_task', 'delete_task');
function delete_task() {
    global $wpdb;
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;
    $id = intval($_POST['id']);
    $wpdb->delete('todos', array('id' => $id, 'user_id' => $custom_user_id));
    wp_die();
}
// Toggle task completion
add_action('wp_ajax_toggle_task', 'toggle_task');
function toggle_task() {
    global $wpdb;
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;
    $id = intval($_POST['id']);
    $completed = intval($_POST['completed']);
    $wpdb->update('todos', array('completed' => $completed), array('id' => $id, 'user_id' => $custom_user_id ));
    wp_die();
}
// Register REST API endpoint
add_action('rest_api_init', function () {
    register_rest_route('todo/v1', '/tasks', array(
        'methods' => 'POST',
        'callback' => 'get_user_tasks',
        'permission_callback' => '__return_true',
    ));
    register_rest_route('todo/v1', '/add_tasks', array(
        'methods' => 'POST',
        'callback' => 'add_user_task',
        'permission_callback' => '__return_true',
    ));
    register_rest_route('todo/v1', '/tasks/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'delete_user_task',
        'permission_callback' => '__return_true',
    ));
    register_rest_route('todo/v1', '/tasks/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'toggle_user_task',
        'permission_callback' => '__return_true',
    ));
});
// Get tasks for a specific user
function get_user_tasks($request) {
    $user_id = $request->get_param('user_id');
    global $wpdb;
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;

    $user_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM wp_custom_users WHERE  id = %d", $custom_user_id));
    if (!$user_exists) {
        return new WP_REST_Response('Invalid user_id', 404);
    }
    
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM todos WHERE user_id = %d", $custom_user_id));
    if (empty($results)) {
        return new WP_REST_Response('This user has no todo list', 200);
    }
    return new WP_REST_Response($results, 200);
}
// Add a new task for a user
function add_user_task($request) {
    $custom_user = get_transient('current_user');
    $custom_user_id = $custom_user->id;
    $task = sanitize_text_field($request['task']);
    $status = sanitize_text_field($request['completed']);
    $custom_user_id = sanitize_text_field($request['user_id']);
    global $wpdb;
    $existing_task = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM todos WHERE task = %s AND user_id = %d", 
        $task, 
        $custom_user_id
    ));
    if ($existing_task) {
        return new WP_REST_Response('Task already taken', 409);
    }
    $wpdb->insert('todos', array(
        'task' => $task,
        'user_id' => $custom_user_id,
        'completed' => $status
    ));
    $task_id = $wpdb->insert_id;

    return new WP_REST_Response(array('message' => 'Task added successfully', 'task_id' => $task_id), 201);
}
// Delete a user's task
function delete_user_task($request) {
    $id = intval($request['id']);
    global $wpdb;
    $wpdb->delete('todos', array('id' => $id));
    return new WP_REST_Response('Task deleted successfully', 200);
}
// Toggle task completion status
function toggle_user_task($request) {
    $id = intval($request['id']);
    $completed = intval($request['completed']);
    global $wpdb;
    $wpdb->update('todos', array('completed' => $completed), array('id' => $id));
    return new WP_REST_Response('Task updated successfully', 200);
}

add_action('template_redirect', 'check_user_redirect');
function check_user_redirect() {
    $userID = get_transient('current_user');
    if (is_page_template('templates/template-to_do.php')) {
        if (empty($userID)) {
            wp_safe_redirect(home_url('/login-page'));
            exit;
        }
    } 
    if (is_page_template('templates/template-registration.php') || is_page_template('templates/template-login.php')) {
        if (!empty($userID)) {
            wp_safe_redirect(home_url('/to_do-list'));
            exit;
        }
    }
}




?>
