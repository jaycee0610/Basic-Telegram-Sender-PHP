<?php

namespace Rootscratch\Telegram;

class Send
{

    private static $token;
    private static $chat_id;

    public static function telegram_token($token)
    {
        self::$token = $token;
    }

    public static function telegram_chat_id($chat_id)
    {
        self::$chat_id = $chat_id;
    }

    public static function SendGroup($message)
    {
        if (empty(self::$token) || empty(self::$chat_id)) {
            throw new \Exception('Token and User ID must be set before sending a message.');
        }

        $request_params = [
            'chat_id' => self::$chat_id,
            'text' => $message
        ];

        $request_url = 'https://api.telegram.org/bot' . self::$token . '/sendMessage?' . http_build_query($request_params);
        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $data = file_get_contents($request_url, false, $context);

        $responseHeaders = $http_response_header;
        $responseCode = null;
        if (isset($responseHeaders[0])) {
            preg_match('{HTTP\/\S*\s(\d{3})}', $responseHeaders[0], $match);
            $responseCode = $match[1];
        }

        if ($responseCode == 404) {
            throw new \Exception('HTTP request failed! HTTP/1.1 404 Not Found');
        }

        if ($data === false) {
            throw new \Exception('Failed to get contents from URL');
        }

        $decodedData = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decode error: ' . json_last_error_msg());
        }
        return $decodedData;
    }
}
