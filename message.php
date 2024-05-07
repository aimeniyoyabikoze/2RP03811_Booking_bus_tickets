<?php
include_once 'menu.php';
include_once("server.php");
include_once ('util.php');
// https://a944-197-243-106-90.ngrok-free.app/transport/message.php

// Function to check if a user is not already registered
function isNotRegistered($phoneNumber, $pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE phone = ?");
    $stmt->execute([$phoneNumber]);
    $count = $stmt->fetchColumn();
    return $count == 0; // Return true if the count is 0 (user is not registered), false otherwise
}                   

// Get the phone number and text from the POST request
$phoneNumber = $_POST['from'];
$text = $_POST['text']; 

// Explode the SMS text to get individual components
$textArray = explode(" ", $text);

// Check if both name and password are provided in the SMS
if(isset($textArray[0]) && isset($textArray[1])) {
    $name = $textArray[0];
    $password = $textArray[1];

// Check if the user is not already registered
    if(isNotRegistered($phoneNumber, $pdo)) {

        $stmt = $pdo->prepare("INSERT INTO users (name, phone, password) VALUES (:name, :phone, :password)");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':phone', $phoneNumber);
        $stmt->bindValue(':password', $password);
// If registration is successful, retrieve and display the user's details
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($result as $value) {
                echo "END Thank you $name, you have been successfully registered!";
            }
        } else {
            echo "END Registration failed. Please try again later.";
        }
    } else {
        echo "END User is already registered.";
    }
} else {
    // If name or password is missing in the SMS, prompt the user to provide both
    echo "END Your SMS must contain name and password.";
}
?>
