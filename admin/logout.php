<?php
require_once '../config/config.php';
require_once '../core/Security.php';

Security::logout();
header('Location: login.php?logged_out=1');
exit;
