<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database/Auth.php';

Auth::logout();
header('Location: /admin/login.php');
exit();
