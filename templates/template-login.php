<?php
/**
 * Template Name: login
 */
get_header();
wp_head();
?>
    <div class="body">
    <div class="main">
        <form action="" method="POST" class="login-form">
            <h1>Login Form</h1>
        <div class="input">
        <input type="text" placeholder="Your name" name="name" id="name">
        <span id="name-error" class="error-message"></span>

                <input type="Password" placeholder="Enter Password" name="password" id="current-password">
                <span id="password-error" class="error-message"></span>

            </div>
            <div class="btn2">
                <input type="submit" Value="login" class="submit" name="submit" id="login">
                <input type="submit" Value="Sigh up" class="submit" name="submit" id="signup2">
                <p id="response"></p>
            </div>
        </form>
    </div>
    </div>
<?php
wp_footer();
get_footer();
?>