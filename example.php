<?php

require_once 'vendor/autoload.php';

use Rootscratch\Telegram\Send;

Send::telegram_token('token');
Send::telegram_chat_id('chat_id');
$message = 'message';


try {
    $send = Send::SendGroup($message);
    echo json_encode($send);
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
