<?php
require 'ToDoRow.php';
class ToDo
{
    // Получить задачи для текущего пользователя
    public static function getTasks($userId)
    {
        return ToDoRow::findByUserId($userId);
    }

    // Добавить новую задачу
    public static function createTask($userId, $task)
    {
        if (empty($task)) {
            throw new Exception("Задача не может быть пустой.");
        }
        return ToDoRow::addTask($userId, $task);
    }

    public static function updateTaskStatus($taskId, $isCompleted)
    {
        return ToDoRow::updateTaskStatus($taskId, $isCompleted);
    }

    public static function updateTask($taskId, $task)
    {
        return ToDoRow::updateTask($taskId, $task);
    }


    // Завершить задачу
    public static function completeTask($taskId)
    {
        return ToDoRow::markAsCompleted($taskId);
    }

    // Удалить задачу
    public static function removeTask($taskId)
    {
        return ToDoRow::deleteTask($taskId);
    }
}
