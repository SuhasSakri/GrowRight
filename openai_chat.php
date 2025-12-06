<?php
session_start();
require_once 'openai_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['success' => false, 'error' => 'Message required']);
    exit;
}

$data = [
    'model' => GROQ_MODEL,
    'messages' => [
        ['role' => 'system', 'content' => 'You are a health and wellness assistant for GrowRight app. Keep responses brief.'],
        ['role' => 'user', 'content' => $userMessage]
    ],
    'max_tokens' => 300
];

$ch = curl_init(GROQ_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . GROQ_API_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $result = json_decode($response, true);
    echo json_encode([
        'success' => true,
        'message' => $result['choices'][0]['message']['content'] ?? 'No response'
    ]);
} else {
    $errorData = json_decode($response, true);
    echo json_encode([
        'success' => false, 
        'error' => $errorData['error']['message'] ?? 'API error: ' . $httpCode,
        'details' => $response
    ]);
}
?>
