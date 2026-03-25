<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include("../../model/dbconn.php");
session_start();

if (isset($_SESSION['studentvoter_id'])) {
    $voter_id = intval($_SESSION['studentvoter_id']);
    $result = mysqli_query($conn, "SELECT has_voted FROM StudentVoters WHERE studentvoter_id = $voter_id");
    $row = mysqli_fetch_assoc($result);
    
    if ($row['has_voted'] == 1) {
        header('Location: alreadyVoted.html');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="electionForm.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <form id="voteForm">

        <h1>Election Form</h1>

        <div class="container">

            <!-- ======================== PARTIDO UNO (partylist_id = 1000) ======================== -->
            <div class="left">
                <h1>Partido Uno</h1>

                <!-- President | position_id = 1000 -->
                <div>
                    <h2>President (1)</h2>
                    <input type="checkbox"
                        name="president"
                        data-position-id="1000"
                        data-candidate-id="1000"
                        onclick="disableButton('president', this)">
                    <label>Juan Dela Cruz</label><br>

                    <input type="checkbox"
                        value="abstain"
                        data-position-id="1000"
                        data-candidate-id="0"
                        name="president"
                        onclick="disableButton('president', this)">
                    <label>Abstain</label>
                </div>

                <!-- Vice-President | position_id = 1001 -->
                <div>
                    <h2>Vice-President (1)</h2>
                    <input type="checkbox"
                        name="vice_president"
                        data-position-id="1001"
                        data-candidate-id="1001"
                        onclick="disableButton('vice_president', this)">
                    <label>Maria Garcia</label><br>

                    <input type="checkbox"
                        value="abstain"
                        data-position-id="1001"
                        data-candidate-id="0"
                        name="vice_president"
                        onclick="disableButton('vice_president', this)">
                    <label>Abstain</label>
                </div>

                <!-- Senators | position_ids = 1002, 1003, 1004 -->
                <div>
                    <h2>Senators (4)</h2>
                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1002"
                        onclick="disableButton('senator', this)">
                    <label>Carlos Lopez</label><br>

                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1003"
                        onclick="disableButton('senator', this)">
                    <label>Ana Martinez</label><br>

                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1004"
                        onclick="disableButton('senator', this)">
                    <label>Jose Rodriguez</label><br>

                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1005"
                        onclick="disableButton('senator', this)">
                    <label>Miguel Gonzales</label><br>
                </div>

                <!-- Vice-Governor | position_id = 1005 -->
                <div>
                    <h2>Vice-Governor (1)</h2>
                    <input type="checkbox"
                        name="vice_governor"
                        data-position-id="1003"
                        data-candidate-id="1006"
                        onclick="disableButton('vice_governor', this)">
                    <label>Luisa Hernandez</label><br>

                    <input type="checkbox"
                        value="abstain"
                        data-position-id="1003"
                        data-candidate-id="0"
                        name="vice_governor"
                        onclick="disableButton('vice_governor', this)">
                    <label>Abstain</label>
                </div>

            </div>

            <!-- ======================== PARTIDO DOS (partylist_id = 1001) ======================== -->
            <div class="right">
                <h1>Partido Dos</h1>

                <!-- President | position_id = 1000 -->
                <div>
                    <h2>President (1)</h2>
                    <input type="checkbox"
                        name="president"
                        data-position-id="1000"
                        data-candidate-id="1008"
                        onclick="disableButton('president', this)">
                    <label>Ramon Castillo</label><br><br>
                </div>

                <!-- Vice-President | position_id = 1001 -->
                <div>
                    <h2>Vice-President (1)</h2>
                    <input type="checkbox"
                        name="vice_president"
                        data-position-id="1001"
                        data-candidate-id="1009"
                        onclick="disableButton('vice_president', this)">
                    <label>Elena Morales</label><br><br>
                </div>

                <!-- Senators | position_ids = 1002, 1003, 1004 -->
                <div>
                    <h2>Senators (4)</h2>
                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1010"
                        onclick="disableButton('senator', this)">
                    <label>Diego Navarro</label><br>

                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1011"
                        onclick="disableButton('senator', this)">
                    <label>Isabella Reyes</label><br>

                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1012"
                        onclick="disableButton('senator', this)">
                    <label>Marco Santiago</label><br>

                    <input type="checkbox"
                        name="senator"
                        data-position-id="1002"
                        data-candidate-id="1015"
                        onclick="disableButton('senator', this)">
                    <label>Camille Fuentes</label><br><br>
                </div>

                <!-- Vice-Governor | position_id = 1005 -->
                <div>
                    <h2>Vice-Governor (1)</h2>
                    <input type="checkbox"
                        name="vice_governor"
                        data-position-id="1003"
                        data-candidate-id="1013"
                        onclick="disableButton('vice_governor', this)">
                    <label>Gabrielle Valdez</label><br>
                </div>

            </div>
        </div>

        <br><button type="submit" id="submitBtn">Submit Vote</button>

    </form>

    <script src="electionForm.js"></script>
</body>

</html>