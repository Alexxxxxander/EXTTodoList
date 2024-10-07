<?php
require_once 'auth_middleware.php';
require_once 'ToDo.php';
require_once 'AuthClass.php';

// Проверка авторизации
checkAuth();  // Используем middleware для проверки

$userId = $_SESSION['user_id'];
$action = isset($_POST['action']) ? $_POST['action'] : '';

try {
    switch ($action) {
        case 'getTasks':
            $tasks = ToDo::getTasks($userId);
            echo json_encode($tasks);
            break;

        case 'addTask':
            $task = isset($_POST['task']) ? $_POST['task'] : '';
            ToDo::createTask($userId, $task);
            echo json_encode(['success' => true]);
            break;

        case 'updateTask':
            $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : 0;
            $task = isset($_POST['task']) ? $_POST['task'] : '';
            ToDo::updateTask($taskId, $task);
            echo json_encode(['success' => true]);
            break;


        case 'updateTaskStatus':
            $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : 0;
            $isCompleted = isset($_POST['is_completed']) ? (int)$_POST['is_completed'] : 0;
            ToDo::updateTaskStatus($taskId, $isCompleted);
            echo json_encode(['success' => true]);
            break;


        case 'deleteTasks':
            $taskIds = isset($_POST['taskIds']) ? explode(',', $_POST['taskIds']) : [];
            foreach ($taskIds as $taskId) {
                ToDo::removeTask($taskId);
            }
            echo json_encode(['success' => true]);
            break;


        default:
            throw new Exception("Invalid action");
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
