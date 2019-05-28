<?php

namespace Action\Core\Logger;

class Logger
{
    public static function emergency(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::EMERGENCY);
    }

    public static function alert(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::ALERT);
    }

    public static function critical(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::CRITICAL);
    }

    public static function error(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::ERROR);
    }

    public static function warning(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::WARNING);
    }

    public static function notice(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::NOTICE);
    }

    public static function info(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::INFO);
    }

    public static function debug(string $message, ...$params): void
    {
        self::log(self::interpolate($message, $params), LogLevel::DEBUG);
    }

    private static function log(string $message, string $type): void
    {
        $config   = require configPath('logging.php');
        $channel = $config['channels'];

        $date = new \DateTime('NOW');
        $date->format(\DateTime::ISO8601);
        $message = $date->format(\DateTime::ISO8601) . ' | ' . strtoupper($type) . ' | ' . $message;

        foreach ($config['active'] as $active) {
            if (in_array($type, $config['level'][$config['channels'][$active]['level']], true)) {
                if ($active === 'file') {
                    file_put_contents($channel['file']['path'], $message . PHP_EOL, FILE_APPEND);
                }
                if ($active === 'slack') {
                    $data = 'payload=' . json_encode([
                            "channel" => $channel['slack']['channel'],
                            "username" => $channel['slack']['username'],
                            "text" => $message,
                            "icon_emoji" => $channel['slack']['icon_emoji'],
                        ]);
                    $ch = curl_init($channel['slack']['url']);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_exec($ch);
                    curl_close($ch);
                }
            }
        }
    }

    private static function interpolate(string $message, array $params = []): ?string
    {
        foreach ($params as $value) {
            $pos = strpos($message, '{}');
            if ($pos == false)
                return null;
            $message = substr($message, 0, $pos) . $value . substr($message, $pos + 2);
        }
        return $message;
    }
}