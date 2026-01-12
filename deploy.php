<?php
$secret = '2ffdc64fa214f779f9ce5dbcc23637ed5fee2dd1438935d4cee3e634010e36d6';

// Read headers
$headers = function_exists('getallheaders') ? getallheaders() : [];
$signature = '';

if (isset($headers['X-Hub-Signature-256'])) {
    $signature = $headers['X-Hub-Signature-256'];
} elseif (isset($headers['x-hub-signature-256'])) { // lowercase fallback
    $signature = $headers['x-hub-signature-256'];
}

// If no signature, stop
if (!$signature) {
    http_response_code(403);
    exit('No signature');
}

// Read payload
$payload = file_get_contents('php://input');

// Verify signature
$sig_check = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($sig_check, $signature)) {
    http_response_code(403);
    exit('Invalid signature');
}

// Everything good — run deploy
echo "Webhook verified OK";
