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
foreach ($votes as $vote) {
    $cid = intval($vote['candidate_id']);
    $pid = intval($vote['position_id']);

    // Handle abstain votes (candidate_id = 0)
    if ($cid === 0) {
        $sql = "INSERT INTO AbstainVotes (studentvoter_id, position_id, vote_date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $studentvoter_id, $pid);
    } else {
        $sql = "INSERT INTO Votes (studentvoter_id, candidate_id, position_id, vote_date) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $studentvoter_id, $cid, $pid);
    }
    $stmt->execute();
    $stmt->close();
}

echo json_encode(['success' => true, 'votes_count' => count($votes)]);
