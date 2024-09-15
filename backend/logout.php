<?php
    session_start();
    
    // Destroy the session
    session_unset();
    session_destroy();

    // Prepare response data
    $response = [
        'status' => 'success',
        'message' => 'Session destroyed successfully.'
    ];

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
