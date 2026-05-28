<?php
require_once __DIR__ . '/db.php';

class DbSessionHandler implements SessionHandlerInterface {
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }
    public function open(string $p, string $n): bool { return true; }
    public function close(): bool { return true; }

    public function read(string $id): string|false {
        $st = $this->db->prepare(
            "SELECT datos FROM sesiones WHERE id=? AND expira>NOW()"
        );
        $st->execute([$id]);
        return $st->fetchColumn() ?: '';
    }
    public function write(string $id, string $data): bool {
        $ttl = (int)ini_get('session.gc_maxlifetime') ?: 1440;
        $st = $this->db->prepare(
            "REPLACE INTO sesiones (id, datos, expira)
             VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND))"
        );
        return $st->execute([$id, $data, $ttl]);
    }
    public function destroy(string $id): bool {
        return $this->db->prepare(
            "DELETE FROM sesiones WHERE id=?"
        )->execute([$id]);
    }
    public function gc(int $max): int|false {
        return $this->db->query(
            "DELETE FROM sesiones WHERE expira<NOW()"
        )->rowCount();
    }
}

session_set_save_handler(new DbSessionHandler(getDbConnection()), true);

?>