<?php

    include("../model/readOperations.php");

    // getting what type of action
    $action = $_POST["action"];

    switch($action){
        case 'registerUser':
            registerUser();
            break;
        case 'loginUser':
            loginUser();
            break;
        default:
            echo "action doesnt exist";
            break;
    }

    function registerUser(){
        $username = $_POST["username"];
        $firstname = $_POST["firstname"];
        $middlename = $_POST["middlename"];
        $lastname = $_POST["lastname"];
        $password = $_POST["password"];
        $studentcourse = $_POST["studentcourse"];
    
        //future logic 
    }

    function loginUser(){
        // data cleaning
        // trim
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // data validation
        // no whitespaces
        if(str_contains($username, ' ') || str_contains($password, ' ')){
            echo json_encode([
                "message" => "username or password cant contain whitespaces" 
            ]);
            return;
        }
        // is it less than minimum char of the usern and passw (6)
        if(strlen($username) <= 4 || strlen($password) <= 4){
            echo json_encode([
                "message" => "username or password must be more than 4 characters" 
            ]);
            return;
        };

        // validating existence in db
        $userExistence = userExists($username);
        if(!$userExistence){
            echo json_encode([
                "message" => "user doesnt exist" 
            ]);
            return;
        }

        // validating username and password match
        $passwordIsCorrect = passwordValidation($username, $password);
        if(!$passwordIsCorrect){
            echo json_encode([
                "message" => "password is wrong" 
            ]);
            return;
        }

        // final output since they passed everything
        session_start();
        $user_id = getUserID($username);
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = getUserRoleID($username);
        
        // Get studentvoter_id if user is a student voter (role_id = 1001)
        $role_id = getUserRoleID($username);
        if($role_id == 1001){
            $_SESSION["studentvoter_id"] = getStudentVoterID($user_id);
        }

        
        echo json_encode([
            "message" => "youve successfully logged in",
            "status" => "success",
            "redirect" => "view/adminUI.php",
            "role" => getUserRoleID($username)
        ]);
    }

?>