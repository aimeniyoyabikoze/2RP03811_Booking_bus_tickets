<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Database connection parameters
$host = 'localhost';
$dbname = 'transport';
$username = 'root';
$password = '';

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


// Handle user registration form submission
if (isset($_POST['registerUser'])) {
    $registerName = $_POST['name'];
    $registerPhone = $_POST['phone'];
    $registerPhone = $_POST['phone'];
    $password=$_POST['password'];

    // Call the function to register the user
    registerUser($registerName, $registerPhone,$password);

    // Redirect to the same page after registration (optional)
    header("Location:login.php ");
    exit();
}

// Function to register a new user
function registerUser($name, $phone,$password) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, phone,password) VALUES (?, ?,?)");
        $stmt->execute([$name, $phone,$password]);
        echo "User registered successfully!";
    } catch (PDOException $e) {
        echo "Error registering user: " . $e->getMessage();
    }
}



// Function to retrieve user details
function getUserDetails($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




// Handle adding new bus schedule form submission
if (isset($_POST['addBusSchedule'])) {
    $id= $_POST['id'];
    $busRoute = $_POST['busRoute'];
    $departureTime = $_POST['departureTime'];
    $money = $_POST['money'];

    // Call the function to add the new bus schedule
    addBusSchedule($id,$busRoute, $departureTime,$money);

    // Redirect to the same page after adding the schedule (optional)
    header("Location:index.php ");
    exit();
}

// Function to add a new bus schedule
// Function to add a new bus schedule
function addBusSchedule($id, $route, $departureTime, $money) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO bus_schedules (id, route, departure_time, money) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $route, $departureTime, $money]);
        echo "Bus schedule added successfully!";
    } catch (PDOException $e) {
        echo "Error adding bus schedule: " . $e->getMessage();
    }
}

//Function to retrieve bus schedules
function getBusSchedules() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM bus_schedules");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteBusSchedule($scheduleId) {
    global $pdo;
    try {
        // Prepare and execute the SQL statement
        $stmt = $pdo->prepare("DELETE FROM bus_schedules WHERE id = ?");
        $stmt->execute([$scheduleId]);

        // Check if any row was affected
        if ($stmt->rowCount() > 0) {
            echo "Bus schedule deleted successfully.";
        } else {
            echo "Error: Bus schedule not found.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
//function to update bus schedules
function updateBusSchedule( $route, $departure_time,$money) {
    global $pdo;
if (isset($_POST['update_schedule'])) {
    $id = $_POST['id'];
    $route = $_POST['route'];
    $departure_time = $_POST['departure_time'];
    $money=$_POST['money'];
    $stmt = $pdo->prepare("UPDATE bus_schedules SET route=:route, departure_time=:departure_time, money:money WHERE id=:id");
    $stmt->bindParam(':route', $route);
    $stmt->bindParam(':departure_time', $departure_time);
    $stmt->bindParam(':money', $money);
    $stmt->bindParam(':item_id', $id);
    $stmt->execute();

    echo "<script>alert('Item updated successfully');</script>";
}
   }




// Function to book tickets
function bookTicket($userId, $busRoute, $numTickets) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, bus_id, num_tickets) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $busRoute, $numTickets]);
}

// Function to retrieve booked tickets
function getBookedTickets($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllBookedTickets() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM bookings");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to cancel booked tickets
function cancelTicket($ticketId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$ticketId]);
}


// Function to gather service feedback
function submitFeedback($userId, $feedback) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO feedback (user_id, feedback) VALUES (?, ?)");
    $stmt->execute([$userId, $feedback]);
}




// Process the login form submission
if(isset($_POST['login'])){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $phone = htmlspecialchars($_POST["phone"]);
    $password = htmlspecialchars($_POST["password"]);

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ? AND password = ?");
    $stmt->execute([$phone, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User authentication successful
        session_start();
        $_SESSION['id'] = $user['id']; // Store user ID in session for future use
        header("Location: users_home.php");
        exit();
    } else {
        // User authentication failed
        echo "Invalid phone number or password. Please try again.";
    }
}
}



// Example usage:
// registerUser("John Doe", "123456789");
// $userDetails = getUserDetails(1);
// $busSchedules = getBusSchedules();
// bookTicket(1, "Route A", "2024-02-24", 2);
// $bookedTickets = getBookedTickets(1);
// cancelTicket(1);
// updateUserPreferences(1, "Preferred route: Route B");
// submitFeedback(1, "Great service!");

?>
