<?php

function decodeVoteString($voteStr) {
    return json_decode($voteStr, true);
}

function insertVote($conn, $studentvoter_id, $candidate_id, $position_id) {
    $cid = intval($candidate_id);
    $pid = intval($position_id);
    $svid = intval($studentvoter_id);
    
    if ($cid === 0) {
        $sql = "INSERT INTO AbstainVotes (studentvoter_id, position_id, vote_date) VALUES ($svid, $pid, NOW())";
    } else {
        $sql = "INSERT INTO Votes (studentvoter_id, candidate_id, position_id, vote_date) VALUES ($svid, $cid, $pid, NOW())";
    }
    
    return mysqli_query($conn, $sql);
}

function processVotes($conn, $studentvoter_id, $votes) {
    $voted_positions = [];
    
    foreach ($votes as $vote) {
        $cid = $vote['candidate_id'];
        $pid = $vote['position_id'];
        
        if (!insertVote($conn, $studentvoter_id, $cid, $pid)) {
            return ['success' => false, 'message' => 'Error inserting vote'];
        }
        
        $voted_positions[$pid] = true;
    }
    
    return ['success' => true, 'voted_positions' => $voted_positions];
}

function validateRequiredPositions($voted_positions) {
    $required_positions = [1000, 1001, 1003];
    
    foreach ($required_positions as $pos_id) {
        if (!isset($voted_positions[$pos_id])) {
            return false;
        }
    }
    
    return true;
}

function autoAbstainUnusedPositions($conn, $studentvoter_id, $voted_positions) {
    $senator_positions = [1002];
    
    foreach ($senator_positions as $pos_id) {
        if (!isset($voted_positions[$pos_id])) {
            $svid = intval($studentvoter_id);
            $sql = "INSERT INTO AbstainVotes (studentvoter_id, position_id, vote_date) VALUES ($svid, $pos_id, NOW())";
            mysqli_query($conn, $sql);
        }
    }
}

function markVoterAsVoted($conn, $studentvoter_id) {
    $svid = intval($studentvoter_id);
    $sql = "UPDATE StudentVoters SET has_voted = 1 WHERE studentvoter_id = $svid";
    return mysqli_query($conn, $sql);
}
