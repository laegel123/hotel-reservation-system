<?php
namespace util;

require_once __DIR__ . '/Database.php';
use util\Database;

function insertAuditRecord($userEmail, $action, $details) {
	$db = Database::get();
	$sql = 'INSERT INTO audit_log (user_email, action, details, timestamp) VALUES (?, ?, ?, NOW())';
	$types = 'sss';
	$params = [$userEmail, $action, $details];
	$mysqli = $db->mysqli();
	$stmt = $mysqli->prepare($sql);
	if (!$stmt) {
		throw new \RuntimeException('MySQL Prepare failed: ' . $mysqli->error);
	}
	$stmt->bind_param($types, ...$params);
	$stmt->execute();
	if ($stmt->error) {
		throw new \RuntimeException('MySQL Execute failed: ' . $stmt->error);
	}
	$stmt->close();
}
