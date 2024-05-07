<?php 
include("server.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Transportation Service Admin Panel</title>
</head>
<body>
    <header>
        <h1>Transportation Service Admin Panel</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#users">Users</a></li>
            <li><a href="#bus-schedules">Bus Schedules</a></li>
            <li><a href="#bookings">Bookings</a></li>
            <li><a href="#feedback">Feedback</a></li>
        </ul>
    </nav>
    <section id="users">
    <h3>Existing Users</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display user information
            $users = getUsers(); // Implement a function in your server.php to fetch users
            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . $user['id'] . '</td>';
                echo '<td>' . $user['name'] . '</td>';
                echo '<td>' . $user['phone'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    </section>

    <section id="bus-schedules">
        <!-- Display bus schedules here -->
    <h2>Bus Schedules </h2>
  
    <!-- Bus Schedule Form -->
    <h3>Add New Bus Schedule</h3>
    <form action="server.php" method="post">
        <label for="Bus ID ">Bus Plaque:</label>
        <input type="text" name="id" required><br>
        <label for="busRoute">Bus Route:</label>
        <input type="text" name="busRoute" required><br>

        <label for="departureTime">Departure Time:</label>
        <input type="text" name="departureTime" placeholder="HH:MM AM/PM" required><br>
        <label for="money">Money Route:</label>
        <input type="number" name="money" required><br>

        <button type="submit" name="addBusSchedule">Add Schedule</button>
    </form>

    <!-- Display existing bus schedules -->
    <h3>Existing Bus Schedules</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Route</th>
                <th>Departure Time</th>
                <th>Money</th>
                <th>DELETE</th>
                <Th>UPDATE</Th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['delete_schedule'])) {
                $scheduleId = $_POST['id'];
            
                // Call the deleteBusSchedule function from server.php to delete the bus schedule
                deleteBusSchedule($scheduleId);
            }
            
            // Fetch all bus schedules
            $allBusSchedules = getBusSchedules();
            

            // Fetch and display bus schedules
            $busSchedules = getBusSchedules(); // Implement a function in your process.php to fetch bus schedules
            foreach ($busSchedules as $schedule) {
                echo '<tr>';
                echo '<td>' . $schedule['id'] . '</td>';
                echo '<td>' . $schedule['route'] . '</td>';
                echo '<td>' . $schedule['departure_time'] . '</td>';
                echo '<td>' . $schedule['money'] . '</td>';
                ?>
                <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">
                            <td><button type="submit" name="delete_schedule">Delete</button></td>
                        </form>
                <?php
                echo '<td><a href="admin_update_schedule.php?id=' . $schedule['id'] . '">Update</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</section>


    </section>
    <section id="bookings">
    <h2>Bookings</h2>
    <h3>All Booked Tickets</h3>
<form action="" method="post"></form>
<table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Bus ID</th>
                <th>Number of Tickets</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (isset($_POST['cancel_ticket'])) {
                $ticketId = $_POST['ticket_id'];
            
                // Call the cancelTicket function from server.php to cancel the ticket
                cancelTicket($ticketId);
            }
            
            // Fetch all booked tickets
            $allBookedTickets = getAllBookedTickets();
            
            ?>
            <?php foreach ($allBookedTickets as $ticket) : ?>
                <tr>
                    <td><?php echo $ticket['id']; ?></td>
                    <td><?php echo $ticket['user_id']; ?></td>
                    <td><?php echo $ticket['bus_id']; ?></td>
                    <td><?php echo $ticket['num_tickets']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                            <button type="submit" name="cancel_ticket">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
</body>




    </section>
    <section id="feedback">
        <!-- Display user feedback here -->
    </section>
    <!-- <footer>
        <p>&copy; 2024 Transportation Service</p>
    </footer> -->
</body>
</html>
