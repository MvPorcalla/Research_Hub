<?php
include_once "../includes/db.php";

// Get the JSON payload
$data = json_decode(file_get_contents('php://input'), true);
$recordId = $data['recordId'] ?? null;
$entryId = $data['entryId'] ?? null;
$commentId = $data['commentId'] ?? null;
$userId = $data['userId'] ?? null;

function updateLikes($conn, $record_type, $recordId) {
    $sql = "SELECT COUNT(*) AS likes FROM `likes` WHERE `{$record_type}_id` = ? AND like_status = 'A'";
    $result = query($conn, $sql, [$recordId]);
    $row = $result[0];

    switch ($record_type) {
        case 'entry':
            $table = 'forum_entry';
            $fields = ['entry_likes' => $row['likes']];
            $filter = ['entry_id' => $recordId];
            break;
        case 'comment':
            $table = 'comments';
            $fields = ['comment_likes' => $row['likes']];
            $filter = ['comment_id' => $recordId];
            break;
    }

    update($conn, $table, $fields, $filter);
}

$liked = false;

if ($recordId !== null) {
    $sql = "SELECT * FROM `likes` WHERE `user_id` = ? AND `record_id` = ?";
    $result = query($conn, $sql, [$userId, $recordId]);

    $fields = ['like_timestamp' => date('Y-m-d H:i:s')];
    if (!empty($result)) {
        $like = $result[0];
        $fields['like_status'] = $like['like_status'] === 'A' ? 'I' : 'A';
        update($conn, 'likes', $fields, ['like_id' => $like['like_id']]);
        $liked = $fields['like_status'] === 'A';
    } else {
        $fields = array_merge($fields, [
            'user_id' => $userId,
            'record_id' => $recordId,
            'like_status' => 'A'
        ]);
        insert($conn, 'likes', $fields);
        $liked = true;
    }
} elseif ($commentId !== null) {
    $sql = "SELECT * FROM `likes` WHERE `user_id` = ? AND `comment_id` = ?";
    $result = query($conn, $sql, [$userId, $commentId]);

    $fields = ['like_timestamp' => date('Y-m-d H:i:s')];
    if (!empty($result)) {
        $like = $result[0];
        $fields['like_status'] = $like['like_status'] === 'A' ? 'I' : 'A';
        if (update($conn, 'likes', $fields, ['like_id' => $like['like_id']])) {
            updateLikes($conn, 'comment', $commentId);
        }
        $liked = $fields['like_status'] === 'A';
    } else {
        $fields = array_merge($fields, [
            'user_id' => $userId,
            'comment_id' => $commentId,
            'like_status' => 'A'
        ]);
        if (insert($conn, 'likes', $fields)) {
            updateLikes($conn, 'comment', $commentId);
        }
        $liked = true;
    }
} elseif ($entryId !== null) {
    $sql = "SELECT * FROM `likes` WHERE `user_id` = ? AND `entry_id` = ?";
    $result = query($conn, $sql, [$userId, $entryId]);

    $fields = ['like_timestamp' => date('Y-m-d H:i:s')];
    if (!empty($result)) {
        $like = $result[0];
        $fields['like_status'] = $like['like_status'] === 'A' ? 'I' : 'A';
        if (update($conn, 'likes', $fields, ['like_id' => $like['like_id']])) {
            updateLikes($conn, 'entry', $entryId);
        }
        $liked = $fields['like_status'] === 'A';
    } else {
        $fields = array_merge($fields, [
            'user_id' => $userId,
            'entry_id' => $entryId,
            'like_status' => 'A'
        ]);
        if (insert($conn, 'likes', $fields)) {
            updateLikes($conn, 'entry', $entryId);
        }
        $liked = true;
    }
}

// Return JSON response
echo json_encode(['liked' => $liked]);
