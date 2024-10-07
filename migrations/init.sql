CREATE TABLE `users` (
                         `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `username` VARCHAR(50) NOT NULL UNIQUE,
                         `password` VARCHAR(255) NOT NULL,
                         `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `todos` (
                         `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `user_id` INT(11) NOT NULL,
                         `task` VARCHAR(255) NOT NULL,
                         `is_completed` TINYINT(1) DEFAULT 0,
                         `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                         FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
