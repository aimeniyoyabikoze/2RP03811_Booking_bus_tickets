<?php
// Include the server.php file
include("server.php");

// Check if a ticket cancellation request is submitted
if (isset($_POST['cancel_ticket'])) {
    $ticketId = $_POST['ticket_id'];

    // Call the cancelTicket function from server.php to cancel the ticket
    cancelTicket($ticketId);
}

// Fetch all booked tickets
$allBookedTickets = getAllBookedTickets();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Panel - Cancel Tickets</title>
</head>
<body>
    <h3>Cancel Booked Tickets</h3>

    <table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Bus Route</th>
                <th>Number of Tickets</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allBookedTickets as $ticket) : ?>
                <tr>
                    <td><?php echo $ticket['id']; ?></td>
                    <td><?php echo $ticket['user_id']; ?></td>
                    <td><?php echo $ticket['bus_route']; ?></td>
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
</body>
</html>
