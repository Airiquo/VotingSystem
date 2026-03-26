<?php
header('Content-Type: application/json');
include("../model/dbconn.php");
session_start();

// Check database connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $conn->connect_error]);
    exit;
}

// Get JSON votes
$votes = json_decode(file_get_contents('php://input'), true);

if (!$votes || !is_array($votes)) {
    echo json_encode(['success' => false, 'message' => 'No votes']);
    exit;
}

// Get studentvoter_id from session, try to fetch from user_id as fallback
if (isset($_SESSION['studentvoter_id'])) {

    $studentvoter_id = intval($_SESSION['studentvoter_id']);

} elseif (isset($_SESSION['user_id'])) {

    // Try to get studentvoter_id from user_id if not directly set
    include("../model/readOperations.php");

    $studentvoter_id = getStudentVoterID($_SESSION['user_id']);

    if ($studentvoter_id === null) {
        echo json_encode(['success' => false, 'message' => 'User is not registered as a student voter']);
        exit;
    }

} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Insert votes
$voted_positions = [];
foreach ($votes as $vote) {
    $cid = intval($vote['candidate_id']);
    $pid = intval($vote['position_id']);

    if ($cid === 0) {
        $sql = "INSERT INTO AbstainVotes (studentvoter_id, position_id, vote_date) VALUES ($studentvoter_id, $pid, NOW())";
    } else {
        $sql = "INSERT INTO Votes (studentvoter_id, candidate_id, position_id, vote_date) VALUES ($studentvoter_id, $cid, $pid, NOW())";
    }
    mysqli_query($conn, $sql);
    $voted_positions[$pid] = true; // Mark position as voted when abstaining
}

// Check required positions have a vote or abstain
$required_positions = [1000, 1001, 1003];
foreach ($required_positions as $pos_id) {
    if (!isset($voted_positions[$pos_id])) {
        echo json_encode(['success' => false, 'message' => 'Please vote or abstain for all required positions']);
        exit;
    }
}

// Auto-abstain unused senator positions
$senator_positions = [1002];
foreach ($senator_positions as $pos_id) {
    if (!isset($voted_positions[$pos_id])) {
        $sql = "INSERT INTO AbstainVotes (studentvoter_id, position_id, vote_date) VALUES ($studentvoter_id, $pos_id, NOW())";
        mysqli_query($conn, $sql);
    }
}

mysqli_query($conn, "UPDATE StudentVoters SET has_voted = 1 WHERE studentvoter_id = $studentvoter_id");

echo json_encode(['success' => true, 'votes_count' => count($votes)]);
