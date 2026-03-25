<?php

    include(__DIR__ . "/dbconn.php");

    function userExists($username){
        global $conn;
        
        $sql = "SELECT * FROM Users WHERE username = '$username'";
        $r_sql = $conn->query($sql);

        if($r_sql->num_rows > 0){
            return true;
        } else{
            return false;
        }
    }

    function passwordValidation($username, $password){
        global $conn;
        
        $sql = "SELECT * FROM Users WHERE username = '$username'";
        $r_sql = $conn->query($sql);

        if($r_sql->num_rows > 0){
            $row = $r_sql->fetch_assoc();
            $passwordFromDB = $row["password"];

            // check if incorrect
            if($password != $passwordFromDB){
                return false;
            }
        } 
        
        return true;
    }

    function getUserID($username){
        global $conn;
        
        $sql = "SELECT * FROM Users WHERE username = '$username'";
        $r_sql = $conn->query($sql);

        $row = $r_sql->fetch_assoc();
        $user_id = $row["user_id"];
        return $user_id;
    }

    function getUserRoleID($username){
        global $conn;
        
        $sql = "SELECT * FROM Users WHERE username = '$username'";
        $r_sql = $conn->query($sql);

        $row = $r_sql->fetch_assoc();
        $role_id = $row["role_id"];
        return $role_id;
    }

    function getStudentVoterID($user_id){
        global $conn;
        
        $sql = "SELECT studentvoter_id FROM StudentVoters WHERE user_id = '$user_id'";
        $r_sql = $conn->query($sql);

        if($r_sql->num_rows > 0){
            $row = $r_sql->fetch_assoc();
            return $row["studentvoter_id"];
        } else {
            return null;
        }
    }

?>