<?php
use Office\UserService\UserService;

require_once(__DIR__.'/UserService.php');

session_start();
session_regenerate_id();

if (empty($_SESSION['login'])) {
    UserService::redirect('index.php');
    exit;
}
?>