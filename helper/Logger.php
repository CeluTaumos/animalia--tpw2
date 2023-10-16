<?php

class Logger {

    public static function info($log) {
        self::log('INFO', $log);
    }

    public static function warning($log) {
        self::log('WARN', $log);
    }

    public static function error($log) {
        self::log("ERROR", $log);
    }

    private static function log($level, $log) {
        $message = self::createMessage($level, $log);
        self::writeLogFile($message);
    }

    private static function createMessage($level, $log): string {
        return "[" . self::getDate() . "][". $level ."]" . $log . "\n";
    }

    private static function writeLogFile(string $message): void {
        $logDirectory = "log";
        if (!is_dir($logDirectory)) {
            // Si el directorio no existe, lo creamos con permisos 0755 (puedes ajustarlos según tus necesidades).
            mkdir($logDirectory, 0755, true);
        }
    
        $filename = $logDirectory . "/log-" . self::getDate() . ".txt";
        file_put_contents($filename, $message, FILE_APPEND);
    }
    

    private static function getDate() {
        return date("Y-m-d");
    }
}