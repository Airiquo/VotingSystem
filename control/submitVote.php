<?php
header('Content-Type: application/json');
include("../model/dbconn.php");
include("../model/electionModel.php");
session_start();

function validateDatabaseConnection($conn) {
    if ($conn->connect_error) {
        return ['success' => false, 'message' => 'DB Error: ' . $conn->connect_error];
    }
    return ['success' => true];
}

function getVotesFromPost() {
    $votesRaw = isset($_POST['votes']) ? $_POST['votes'] : [];
    
    if (!is_array($votesRaw) || empty($votesRaw)) {
        return ['success' => false, 'message' => 'No votes', 'votes' => null];
    }
    
    $votes = array_map('decodeVoteString', $votesRaw);
    return ['success' => true, 'votes' => $votes];
}

function getStudentVoterId() {
    if (isset($_SESSION['studentvoter_id'])) {
        return ['success' => true, 'voter_id' => intval($_SESSION['studentvoter_id'])];
    }
    
    if (isset($_SESSION['user_id'])) {
        include("../model/readOperations.php");
        $studentvoter_id = getStudentVoterID($_SESSION['user_id']);

        if ($studentvoter_id === null) {
            return ['success' => false, 'message' => 'User is not registered as a student voter'];
        }
        
        return ['success' => true, 'voter_id' => $studentvoter_id];
    }
    
    return ['success' => false, 'message' => 'User not logged in'];
}

function handleSubmitVote($conn) {
    // Validate database connection
    $dbCheck = validateDatabaseConnection($conn);
    if (!$dbCheck['success']) {
        return $dbCheck;
    }

    // Get votes from POST
    $votesResult = getVotesFromPost();
    if (!$votesResult['success']) {
        return $votesResult;
    }
    $votes = $votesResult['votes'];

    // Get student voter ID
    $voterResult = getStudentVoterId();
    if (!$voterResult['success']) {
        return $voterResult;
    }
    $studentvoter_id = $voterResult['voter_id'];

    // Process votes
    $result = processVotes($conn, $studentvoter_id, $votes);
    if (!$result['success']) {
        return $result;
    }
    $voted_positions = $result['voted_positions'];

    // Validate required positions
    if (!validateRequiredPositions($voted_positions)) {
        return ['success' => false, 'message' => 'Please vote or abstain for all required positions'];
    }

    // Auto-abstain unused positions
    autoAbstainUnusedPositions($conn, $studentvoter_id, $voted_positions);

    // Mark voter as voted
    markVoterAsVoted($conn, $studentvoter_id);

    return ['success' => true, 'votes_count' => count($votes)];
}

$response = handleSubmitVote($conn);
echo json_encode($response);


