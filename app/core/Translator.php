<?php

class Translator
{
    private static array $messages = [];
    
    public static function load(): void
    {
        $locale = APP_LOCALE;
        $file = __DIR__ . "/../translate/translate.{$locale}.php";
        
        if (file_exists($file)) {
            self::$messages = require $file;
        }
    }
    
    public static function get(string $key, array $params = []): string
    {
        $message = self::$messages[$key] ?? $key;
        
        foreach ($params as $param => $value) {
            $message = str_replace(":{$param}", $value, $message);
        }
        
        return $message;
    }
}
