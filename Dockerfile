# Dockerfile
FROM php:8.3-fpm

# Устанавливаем необходимые зависимости для MySQL
RUN docker-php-ext-install pdo pdo_mysql
