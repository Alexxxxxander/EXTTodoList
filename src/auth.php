<?php
require_once __DIR__ . '/AuthClass.php';

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

switch ($action) {
    case 'register':
        if (AuthClass::register($username, $password)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Username already exists']);
        }
        break;

    case 'login':
        if (AuthClass::login($username, $password)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Invalid credentials']);
        }
        break;

    case 'logout':
        AuthClass::logout();
        echo json_encode(['success' => true]);
        break;
}
