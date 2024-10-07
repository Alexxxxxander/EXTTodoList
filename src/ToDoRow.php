<?php
require_once 'Entity.php';
class ToDoRow extends Entity
{
    protected $id;
    protected $user_id;
    protected $task;
    protected $is_completed;
    protected $created_at;
    protected $updated_at;

    // Получить все задачи для пользователя
    public static function findByUserId($userId)
    {
        $sql = "SELECT * FROM todos WHERE user_id = :user_id";
        return self::fetchAll($sql, ['user_id' => $userId]);
    }

    // Добавить новую задачу
    public static function addTask($userId, $task)
    {
        $sql = "INSERT INTO todos (user_id, task) VALUES (:user_id, :task)";
        return self::execute($sql, ['user_id' => $userId, 'task' => $task]);
    }

    // Обновить статус задачи
    public static function markAsCompleted($taskId)
    {
        $sql = "UPDATE todos SET is_completed = 1 WHERE id = :id";
        return self::execute($sql, ['id' => $taskId]);
    }
    public static function updateTaskStatus($taskId, $isCompleted)
    {
        $sql = "UPDATE todos SET is_completed = :is_completed WHERE id = :id";
        return self::execute($sql, ['id' => $taskId, 'is_completed' => $isCompleted]);
    }

    public static function updateTask($taskId, $task)
    {
        $sql = "UPDATE todos SET task = :task WHERE id = :id";
        return self::execute($sql, ['id' => $taskId, 'task' => $task]);
    }

    // Удалить задачу
    public static function deleteTask($taskId)
    {
        $sql = "DELETE FROM todos WHERE id = :id";
        return self::execute($sql, ['id' => $taskId]);
    }
}


