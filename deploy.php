<?php
/**
 * GitHub Webhook Deploy Script for WordPress Theme
 * Path: /wp-content/themes/michael-mia-theme
 * Logs: deploy.log
 */

// -------------------------
// CONFIGURATION
// -------------------------
$secret = '491d62b656e516852ac647faa775dcc505479778046d6f2cae439ff758bc5c1d'; // Replace with your GitHub webhook secret
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

// GitHub may send lowercase headers
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
    exit('No signature received.');
}

$payload = file_get_contents('php://input');
$sig_check = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($sig_check, $signature)) {
    http_response_code(403);
    log_message('Invalid signature.');
    exit('Invalid signature.');
}

// -------------------------
// DEPLOY
// -------------------------
log_message('Webhook verified. Deploying...');

// Optional: build step (uncomment if needed)
// exec("cd ".escapeshellarg($theme_path)." && npm install && npm run build 2>&1", $build_output, $build_return);
// log_message("Build output:\n" . implode("\n", $build_output));

// Git pull
$cmd = "cd " . escapeshellarg($theme_path) . " && git reset --hard && git pull 2>&1";
exec($cmd, $output, $return_var);

log_message("Command: $cmd");
log_message("Return code: $return_var");
log_message("Output:\n" . implode("\n", $output));

if ($return_var === 0) {
    log_message("Deployment successful.");
    echo "Deployment successful.\n";
    echo implode("\n", $output);
} else {
    log_message("Deployment failed.");
    http_response_code(500);
    echo "Deployment failed. Check deploy.log.\n";
    echo implode("\n", $output);
}
