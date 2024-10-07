<?php
session_start();

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        // Устанавливаем код ответа перед выводом
        http_response_code(401); // Код 401 (Unauthorized)

        // Возвращаем JSON-ответ
        echo json_encode([
            'error' => 'Unauthorized',
            'redirect' => '/login.html'
        ]);

        exit();
    }
}
