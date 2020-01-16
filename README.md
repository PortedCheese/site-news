# Site news

Интерфейс для создания новостей с галлереей. После создания у новости есть вкладки "Просмотр", "Галлерея" и "Метатеги". С помощью команд можно все это переписать.

## Установка

    php artisan migrate

    php artisan make:news {--all : Run all}
                          {--menu : Config menu}
                          {--models : Export models}
                          {--controllers : Export controllers}
                          {--config : Make config}
                          {--policies : Export and create rules}

### Versions

    v1.2.4:
        - Добавлены права доступа
        - Добавлен статус публикации
    Обновление:
        - php artisan make:news --policies