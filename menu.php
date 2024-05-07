<?php
    //include neccessary files
    include_once 'util.php';
    include("server.php");
    class Menu{
        protected $text;//text input from user
        protected $sessionId;//session id of the user
        private $db;//database connection
        function __construct($text, $sessionId){
            $this->text = $text;
            $this->sessionId;
            $host = 'localhost';
            $dbname = 'transport';
            $username = 'root';
            $password = '';


                    
        
                    try {
                        // Create a PDO instance
                        $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
                        // Set PDO error mode to exception
                        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                        // Set character set to utf8mb4
                        $this->db->exec("set names utf8mb4");
                    } catch(PDOException $e) {
                        // Display error message if connection fails
                        echo "Connection failed: " . $e->getMessage();
                    }
                }


            //method to display main menu for registered user
        public function registered(){
            $response =  "Welcome to Bus Ticket Booking System.\n";
           // $response .= "1. register\n";
            $response .= "2. accountMangement\n";
            $response .= "3. selectRoute\n";
            echo "CON ". $response;
        }

        //method to display main menu for unregistered users
        public function mainMenuUnregistered(){
            $response = "Welcome to Bus Ticket Booking System. To register, please enter your full name:  \n";
            $response .= "1. Register\n";
            echo $response;
        }

        //method to check if user is not registered 
        public function isNotRegistered($phoneNumber){
            $sel=$this->db->prepare("SELECT * from users WHERE phone='$phoneNumber'");
            $sel->execute();
            $result=$sel->fetch(PDO::FETCH_ASSOC);
            if($sel->rowCount()>0){
                return true;
            }else{
                return false;
            }
        }

        //method to handle user registration process
        public function menuRegister($textArray){
            //Do something
            $level = count($textArray);
            if($level == 1){
                echo "CON Enter your fullname\n";               
            }
            else if($level == 2){
                echo "CON Enter your phonenumber\n";
                
            }
            else if($level == 3){
                echo "CON enter your password\n";
                
            }
            else if($level == 4){
                $name = $textArray[1];
                $phone = $textArray[2];
                $password = $textArray[3];

                    try {
                        // Prepare SQL statement to insert user data
                        $stmt = $this->db->prepare("INSERT INTO users (name, phone, password) VALUES (:fullname, :phonenumber, :password)");
    
                        // Bind parameters
                        $stmt->bindParam(':fullname', $name);
                        $stmt->bindParam(':phonenumber', $phone);
                        $stmt->bindParam(':password', $password);
    
                        // Execute the query
                        $stmt->execute();
    
                        // Return success message
                        echo "END $name, You have successfully registered";
                    } catch(PDOException $e) {
                        // Display error message
                        echo "Error: " . $e->getMessage();
                    }
                }
            }

            //method to handle account managemnt option
            public function accountManagement($textArray,$phoneNumber){

                $level = count($textArray);
                $response = "";
            
                if ($level == 1) {
                    $response .= "1. View account details\n";
                    $response .= "2. Update account\n";
                    $response .= "3. View booked tickets\n";
                    $response .= Util::$GO_BACK . " Back\n";
                    $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
                    echo $response;
                } 
                else  if ($level == 2){
                    switch ($textArray[1]) {
                        //session_start()
                        case '1':
                            echo "View account details"; // Placeholder for actual functionality
                            try {

                                $stmt = $this->db->prepare("SELECT name, phone FROM users WHERE phone ='$phoneNumber'");
                                $stmt->execute();
                                $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                                // Display the user's account details
                                //echo "\n CON Account Details:\n";
                                echo "\n Name: " . $userDetails['name'] . "\n";
                                echo "Phone: " . $userDetails['phone'] . "\n";
                                
                            } catch (PDOException $e) {
                                echo "END Error: " . $e->getMessage();
                            }
                            break;
                        
                        case '2':
                            echo "Update your account\n";
                            echo "1. Change Password\n";
                          //  echo "2. Change Phone Number\n";
                            break;
                        
                        
                        case '3':
                            // handle user booked tikets
                            echo "View your tickets:\n";
                            try {
                                
                                $stmt = $this->db->prepare("SELECT b.bus_id, b.num_tickets, b.created_at 
                                                            FROM bookings b
                                                            JOIN users u ON b.user_id = u.id
                                                            WHERE u.phone = :phoneNumber");
                                $stmt->bindParam(':phoneNumber', $phoneNumber);
                                $stmt->execute();
                        
                                
                                $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                                if ($bookings) {
                                    foreach ($bookings as $booking) {
                                        echo "Bus ID: " . $booking['bus_id'] . "\n";
                                        echo "Number of Tickets: " . $booking['num_tickets'] . "\n";
                                        echo "Created At: " . $booking['created_at'] . "\n";
                                        echo "------------------------\n";
                                    }
                                } else {
                                    echo "No booked tickets found for this user.\n";
                                }
                            } catch (PDOException $e) {
                                echo "END Error: " . $e->getMessage();
                            }
                            break;
                    }
                }   elseif ($level == 3) {
                    // User selected a specific action in account update
                    switch ($textArray[1]) {
                        case '2':
                            // User chose to change password
                            echo "CON Enter your current password:\n";
                            break;      
                    }
                }
                elseif ($level == 4) {
                    // User entered the current password
                    $currentPassword = $textArray[3];
                    
                    // Check if the current password matches
                    try {
                        $stmt = $this->db->prepare("SELECT id FROM users WHERE phone = :phoneNumber AND password = :password");
                        $stmt->bindParam(':phoneNumber', $phoneNumber);
                        $stmt->bindParam(':password', $currentPassword);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if (!$user) {
                            // Incorrect current password
                            echo "END Incorrect current password.\n";
                            return;
                        } else {
                            // Correct current password, prompt for new password
                            echo "CON Enter your new password:\n";
                        }
                    } catch (PDOException $e) {
                        echo "END Error: " . $e->getMessage();
                    }
                }
                elseif ($level == 5) {
                    // User entered the new password
                    $newPassword = $textArray[4];
                    
                    // Update the password
                    try {
                        $stmt = $this->db->prepare("UPDATE users SET password = :newPassword WHERE phone = :phoneNumber");
                        $stmt->bindParam(':newPassword', $newPassword);
                        $stmt->bindParam(':phoneNumber', $phoneNumber);
                        $stmt->execute();
                        echo "END Password updated successfully.\n";
                    } catch (PDOException $e) {
                        echo "END Error: " . $e->getMessage();
                    }
                }
            }
            //method to handle selecting a bus route
            public function selectRoute($textArray,$phoneNumber) {
                // Fetch and display bus routes
                $busSchedules = getBusSchedules(); // Fetch bus schedules from the database
                if ($busSchedules) {
                    echo "Available Bus Routes:\n";
                    foreach ($busSchedules as $schedule) {
                        echo $schedule['id'] . ". " . $schedule['route'] . ". " . $schedule['money'] . "\n";
                    }
                    echo "\n";
                } else {
                    echo "No bus routes available.\n";
                    return;
                }
            
                // Handle user input for selecting a route
                $level = count($textArray);
                if ($level == 1) {
                    echo "CON Enter the route number: \n";
                } 
                elseif ($level == 2) {
                    $selectedRoute = $textArray[1];
                    echo "Selected Route: $selectedRoute\n"; 
                    // Check if the selected route exists
                    $selectedSchedule = null;
                    foreach ($busSchedules as $schedule) {
                        if ($schedule['id'] == $selectedRoute) {
                            $selectedSchedule = $schedule;
                            break;
                        }
                    }
                    if ($selectedSchedule) {
                        echo "CON Enter the number of tickets for {$selectedSchedule['route']}: \n";
                    }
                     else {
                        echo "END Invalid route selection.\n";
                        return;
                    }
                } 
                elseif ($level == 3) {

            
                    $numTickets = $textArray[2];

                    if (!is_numeric($numTickets) || $numTickets <= 0) {
                        echo "END Invalid number of tickets.\n";
                        return;
                    }
            
                    $totalCost = $schedule['money'] * $numTickets;

                    echo "CON Total cost for $numTickets tickets on }: $totalCost. Proceed with payment?\n";

                } 
                elseif ($level == 4) {
                    echo "CON Enter your PIN (password): \n";
                } 
                elseif ($level == 5) {
                    $response="";
                    $response .= Util::$GO_BACK . " Back\n";
                    $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
                    echo $response;
                    $pin = $textArray[4]; 

                    try {
                        $stmt = $this->db->prepare("SELECT id, password FROM users WHERE phone = '$phoneNumber'");
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (!$user) {
                            echo "END User not found.\n";
                            return;
                        }
                        elseif ($pin==$user['password']) {

                            echo "CON Password correct. Proceed with booking confirmation.\n";
                        } else {
                            // Incorrect PIN
                            echo "END Incorrect PIN.\n";
                        }   
                    } catch (PDOException $e) {

                        echo "END Error: " . $e->getMessage();
                    }
                }
                //handle user back once and back to main menu
                elseif ($level == 6) {
                    $response="";
                    $response .= Util::$GO_BACK . " Back\n";
                    $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
                    echo $response;

                    $confirmation = $textArray[5];
                    if ($confirmation == 1) {
                        // Proceed with payment
                       // echo "END Payment successful. Thank you!\n";
                    $bus_id = $textArray[1];
                    $phoneNumber = $phoneNumber;
                    $num_tickets = $textArray[2];
                
                    try {
                        // Fetch user_id based on the provided phoneNumber
                        $stmt = $this->db->prepare("SELECT id FROM users WHERE phone = :phoneNumber");
                        $stmt->bindParam(':phoneNumber', $phoneNumber);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                        if (!$user) {
                            echo "END User not found.\n";
                            return;
                        }
                
                        // Insert booking with retrieved user_id
                        $stmt = $this->db->prepare("INSERT INTO bookings (user_id, bus_id, num_tickets) VALUES (:user_id, :bus_id, :num_tickets)");
                        $stmt->bindParam(':user_id', $user['id']);
                        $stmt->bindParam(':bus_id', $bus_id);
                        $stmt->bindParam(':num_tickets', $num_tickets);
                
                        // Execute the query
                        $stmt->execute();
                
                        // Return success message
                        echo "END Your booking has been successfully made.\n";
                    } catch(PDOException $e) {
                        // Display error message
                        echo "END Error: " . $e->getMessage();
                    }
                }
                    
             }  
                
            }

            //middleware method to process user input
            public function middleware($text){
                //remove entries for going back and going to the main menu
                return $this->goBack($this->goToMainMenu($text));
            }
    
            //method to remove go back entries from user input
            public function goBack($text){
                //1*4*5*1*98*2*1234
                $explodedText = explode("*",$text);
                while(array_search(Util::$GO_BACK, $explodedText) != false){
                    $firstIndex = array_search(Util::$GO_BACK, $explodedText);
                    array_splice($explodedText, $firstIndex-1, 2);
                }
                return join("*", $explodedText);
            }
    
            //method to remove go to main menu entries from user input
            public function goToMainMenu($text){
                //1*4*5*1*99*2*1234*99
                $explodedText = explode("*",$text);
                while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
                    $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
                    $explodedText = array_slice($explodedText, $firstIndex + 1);
                }
                return join("*",$explodedText);
            }
    

            
    }
?>