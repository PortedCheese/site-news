# Site news

Интерфейс для создания новостей с галлереей. После создания у новости есть вкладки "Просмотр", "Галлерея" и "Метатеги". С помощью команд можно все это переписать.

## Установка

    php artisan migrate

    php artisan make:news {--all : Run all}
                          {--menu : Config menu}
                          {--models : Export models}
                          {--controllers : Export controllers}
                          {--config : Make config}
                          {--only-default : Create default rules}
                          {--policies : Export and create rules}

### Versions
    
    v1.3.2:
        - В конфиг добален параметр файл доп. адресов, что бы вставить адреса перед основными
    
    v1.3.0:
        - Обновлены traits в модели на новые
        
    v1.2.8:
        - Добавлен параметр --only-default в команду
        - В просмотре новости в админке изменен вывод изображения
    
    v1.2.6:
        - Добавлены права доступа
        - Добавлен статус публикации
    Обновление:
        - php artisan make:news --policies