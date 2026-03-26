<?php
header('Content-Type: application/json');
include("../model/dbconn.php");
include("../model/electionModel.php");
session_start();

// Check database connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $conn->connect_error]);
    exit;
}

// Get votes from POST data
$votesRaw = isset($_POST['votes']) ? $_POST['votes'] : [];

if (!is_array($votesRaw) || empty($votesRaw)) {
    echo json_encode(['success' => false, 'message' => 'No votes']);
    exit;
}

// Decode each JSON vote string
$votes = array_map('decodeVoteString', $votesRaw);

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

// Process votes
$result = processVotes($conn, $studentvoter_id, $votes);
if (!$result['success']) {
    echo json_encode($result);
    exit;
}

$voted_positions = $result['voted_positions'];

// Validate required positions
if (!validateRequiredPositions($voted_positions)) {
    echo json_encode(['success' => false, 'message' => 'Please vote or abstain for all required positions']);
    exit;
}

// Auto-abstain unused positions
autoAbstainUnusedPositions($conn, $studentvoter_id, $voted_positions);

// Mark voter as voted
markVoterAsVoted($conn, $studentvoter_id);

echo json_encode(['success' => true, 'votes_count' => count($votes)]);

