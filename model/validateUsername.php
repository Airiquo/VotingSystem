<?

    include("dbconn.php");

    $username = $_POST[]; 

   
    
    function getUser(){
        $sql = "SELECT * FROM Voters WHERE username = $username";
        $r_sql = $conn->query($sql);
    }

?>