<?php
// Include the session start code
session_start();

// Include the server.php file
include("server.php");

// Check if the user is authenticated
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the booking form submission
    $user_id = $_SESSION['id'];
    $bus_route_id = $_POST['bus_route_id'];
    $num_tickets = $_POST['num_tickets'];

    // Validate and process the booking
    if (!empty($user_id) && !empty($bus_route_id) && !empty($num_tickets)) {
        // Call the bookTicket function from server.php
        bookTicket($user_id, $bus_route_id, $num_tickets);
        // Redirect to a success page or the user panel
        echo "<script>alert('you have booked ticket successfully');</script>";
        header("Refresh:0");
        // exit();
    }
}

// Fetch and display bus schedules
$busSchedules = getBusSchedules(); // Implement a function in your server.php to fetch bus schedules
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bus Schedules</title>
</head>
<body>
    <h3>Existing Bus Schedules</h3>

    <table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Route</th>
                <th>Departure Time</th>
                <th>N.of tickets</th>
                <th>BOOK</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($busSchedules as $schedule) : ?>
                <tr>
                    <td><?php echo $schedule['id']; ?></td>
                    <td><?php echo $schedule['route']; ?></td>
                    <td><?php echo $schedule['departure_time']; ?></td>
                    <td>
                        <form action="users_home.php" method="post">
                            <input type="hidden" name="bus_route_id" value="<?php echo $schedule['id']; ?>">
                            <input type="number" name="num_tickets" min="1" required>
                    </td>
                    <td>
                            <input type="submit" value="Book Now">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
