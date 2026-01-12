<?php
// Simple webhook deploy
$secret = '2ffdc64fa214f779f9ce5dbcc23637ed5fee2dd1438935d4cee3e634010e36d6';

$headers = getallheaders();
$payload = file_get_contents('php://input');

// Verify secret
if (!isset($headers['X-Hub-Signature-256'])) {
    http_response_code(403);
    exit('No signature');
}

$sig = 'sha256=' . hash_hmac('sha256', $payload, $secret);
if (!hash_equals($sig, $headers['X-Hub-Signature-256'])) {
    http_response_code(403);
    exit('Invalid signature');
}

// Run git pull
exec('cd /home/u180542192/domains/michaelmia.me/public_html/wp-content/themes/michael-mia-theme && git reset --hard && git pull 2>&1', $output);

echo implode("\n", $output);
