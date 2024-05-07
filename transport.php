<?php include("server.php")?>
<section id="users">
    <h2>User Information</h2>

    <!-- User Registration Form -->
    <h3>Register New User</h3>
    <form action="server.php" method="post">
        <label for="registerName">Name:</label>
        <input type="text" name="name" required>

        <label for="registerPhone">Phone:</label>
        <input type="text" name="phone" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="registerUser">Register User</button>
    </form>

    <!-- Display existing users -->
   
</section>
