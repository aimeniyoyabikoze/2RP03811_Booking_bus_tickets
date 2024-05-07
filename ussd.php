<?php
    //remote URL CALLBACK: https://6391-41-186-78-233.ngrok-free.app/ussdsms/index.php

    //local: http://localhost:80/ussdsms/index.php
    include_once 'menu.php';

    // Retrieve data from the USSD request
    $sessionId = $_POST['sessionId'];
    $phoneNumber = $_POST['phoneNumber'];
    $serviceCode = $_POST['serviceCode'];
    $text = $_POST['text'];

    // Instantiate a Menu object
    $menu = new Menu($text, $sessionId);   

    // Check if the user is registered
    $isRegistered = $menu->isNotRegistered($phoneNumber);

    // Middleware processing of text
    $text = $menu->middleware($text);

    // Handle different scenarios based on user registration status and input text
    if($text == "" && !$isRegistered){
        // Display main menu for unregistered users
        $menu->mainMenuUnregistered();
    }
    else if($text == "" && $isRegistered){
        // Display main menu for registered users
        $menu->registered();
    }
    else if(!$isRegistered){
        // Handle registration process for unregistered users
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1:
                // Register user
                $menu->menuRegister($textArray);
                break;
            default:
                // Invalid option
                echo "END Invalid option, retry";
        }
    }
    else{
        // Handle menu options for registered users
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1:
                // Register user
                $menu->menuRegister($textArray);
                break;
            case 2:
                // Account management
                $menu->accountManagement($textArray,$phoneNumber);
                break;
            case 3:
                // Select route
                $menu->selectRoute($textArray,$phoneNumber);
                break;
            default:
                // Invalid choice
                echo "END Invalid choice\n";
        }
    }
?>
