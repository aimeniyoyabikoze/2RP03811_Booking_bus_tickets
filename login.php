
<?php include("server.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <!-- handle user login html form -->
    <h1>Login</h1>
    <form action="" method="post">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login" name="login">
    </form>
</body>
</html>
