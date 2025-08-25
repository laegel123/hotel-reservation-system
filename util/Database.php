<?php
namespace util;

class Database
{
    private static ?self $instance = null;
    private \mysqli $mysqli;

    private function __construct(array $config)
    {
        $db = $config['db'];
        $this->mysqli = new \mysqli($db['host'], $db['user'], $db['password'], $db['dbname']);
        if ($this->mysqli->connect_errno) {
            throw new \RuntimeException('MySQL Connection failed: ' . $this->mysqli->connect_error);
        }
    }

    public static function init(array $config): void
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
    }

    public static function get(): self
    {
        if (self::$instance === null) {
            throw new \RuntimeException('Database is not initialized. Call Database::init($config) first.');
        }
        return self::$instance;
    }

    public function mysqli(): \mysqli
    {
        return $this->mysqli;
    }

    /** one column */
    public function fetchColumn(string $sql, array $params = [], int $column = 0)
    {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            throw new \RuntimeException('MySQL Prepare failed: ' . $this->mysqli->error);
        }
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new \RuntimeException('MySQL get_result failed: ' . $stmt->error);
        }
        $row = $result->fetch_row();
        $stmt->close();
        return $row !== null && isset($row[$column]) ? $row[$column] : false;
    }

    /** one row */
    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            throw new \RuntimeException('MySQL Prepare failed: ' . $this->mysqli->error);
        }
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new \RuntimeException('MySQL get_result failed: ' . $stmt->error);
        }
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row === null ? null : $row;
    }

    /** multiple rows */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            throw new \RuntimeException('MySQL Prepare failed: ' . $this->mysqli->error);
        }
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new \RuntimeException('MySQL get_result failed: ' . $stmt->error);
        }
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    /** INSERT/UPDATE/DELETE */
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            throw new \RuntimeException('MySQL Prepare failed: ' . $this->mysqli->error);
        }
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected;
    }
}