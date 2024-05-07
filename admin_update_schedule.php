<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">
    <label for="route">New Route:</label>
    <input type="text" name="route" required>
    <label for="departure_time">New Departure Time:</label>
    <input type="text" name="departure_time" required>
    <label for="money">money:</label>
    <input type="number" name="money" required>
    <button type="submit" name="update_schedule">Update</button>
</form>
</body>
</html>
<?php 
// admin_update_schedule.php
include("server.php");


if (isset($_POST['update_schedule'])) {
    $id = $_POST['id'];
    $route = $_POST['route'];
    $departure_time = $_POST['departure_time'];
    $money=$_POST['money'];

    // Call the updateBusSchedule function to update the bus schedule
    updateBusSchedule($route, $departure_time,$money);
}

// Fetch all bus schedules
$allBusSchedules = getBusSchedules();



?>