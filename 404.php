<?php
get_header();
wp_head();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
        }
        h1 {
            font-size: 50px;
            color: #e74c3c;
        }
        p {
            font-size: 20px;
        }
        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! The page you are looking for could not be found.</p>
        <p>It might have been removed, renamed, or did not exist in the first place.</p>
        <a href="/">Return to Home</a>
    </div>
</body>
</html>



<?php
get_footer();
?>