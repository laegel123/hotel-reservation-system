<?php
require_once 'config/config.php';
require_once 'util/Database.php';
util\Database::init(require 'config/config.php');
require_once 'util/audit.php';
util\insertAuditRecord('test@example.com', 'test_action', 'test_details');
echo 'done';
