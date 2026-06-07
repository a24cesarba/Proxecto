<?php
function getDbConnection(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $host = 'lb';
    $port = '3306';
    $name = 'app';
    $user = 'app';
    $pass = trim(@file_get_contents('/run/secrets/db_app_password') ?: '');

    $maxAttempts = 3;
    $delay = 300000; // 300ms en microsegundos

    for ($i = 1; $i <= $maxAttempts; $i++) {
        try {
            $pdo = new PDO(
                "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4",
                $user, $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $pdo;
        } catch (PDOException $e) {
            if ($i === $maxAttempts) throw $e;
            usleep($delay * $i); // backoff: 300ms, 600ms
        }
    }
}

?>