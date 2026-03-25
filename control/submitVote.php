<?php
header('Content-Type: application/json');
include("../model/dbconn.php");

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

// Dummy voter ID
$studentvoter_id = 1000;

// Insert votes
foreach ($votes as $vote) {
    $cid = intval($vote['candidate_id']);
    $pid = intval($vote['position_id']);
    
    $sql = "INSERT INTO Votes (studentvoter_id, candidate_id, position_id, vote_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $studentvoter_id, $cid, $pid);
    $stmt->execute();
    $stmt->close();
}

echo json_encode(['success' => true, 'votes_count' => count($votes)]);
?>
