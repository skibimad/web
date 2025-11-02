<?php

/**
 * Admin Front Controller
 * Single entry point for admin area (redirects to main index.php)
 */

// All admin requests go through main public/index.php
// This file exists only for directory access
header('Location: /admin');
exit;
