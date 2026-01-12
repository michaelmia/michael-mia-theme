<?php
/**
 * GitHub Webhook Deploy Script
 * For WordPress theme: michael-mia-theme
 */

// -------------------------
// CONFIGURATION
// -------------------------
$secret = '2ffdc64fa214f779f9ce5dbcc23637ed5fee2dd1438935d4cee3e634010e36d6'; // Replace with your GitHub webhook secret
$theme_path = '/home/u180542192/domains/michaelmia.me/public_html/wp-content/themes/michael-mia-theme';
$log_file = $theme_path . '/deploy.log';

// -------------------------
// HELPER: log messages
// -------------------------
function log_message($message) {
    global $log_file;
    $time = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$time] $message\n", FILE_APPEND);
}

// -------------------------
// READ HEADERS
// -------------------------
$headers = function_exists('getallheaders') ? getallheaders() : [];
$signature = '';
if (isset($headers['X-Hub-Signature-256'])) {
    $signature = $headers['X-Hub-Signature-256'];
} elseif (isset($headers['x-hub-signature-256'])) {
    $signature = $headers['x-hub-signature-256'];
}

// -------------------------
// VERIFY SIGNATURE
// -------------------------
if (!$signature) {
    http_response_code(403);
    log_message('No signature received.');
    exit('No signature');
}

$payload = file_get_contents('php://input');
$sig_check = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($sig_check, $signature)) {
    http_response_code(403);
    log_message('Invalid signature.');
    exit('Invalid signature');
}

// -------------------------
// DEPLOY: git pull
// -------------------------
log_message('Webhook verified. Deploying...');

$cmd = "cd " . escapeshellarg($theme_path) . " && git reset --hard && git pull 2>&1";
exec($cmd, $output, $return_var);

if ($return_var === 0) {
    log_message("Git pull successful:\n" . implode("\n", $output));
    echo "Deployment successful.";
} else {
    log_message("Git pull failed:\n" . implode("\n", $output));
    http_response_code(500);
    echo "Deployment failed. Check deploy.log.";
}
