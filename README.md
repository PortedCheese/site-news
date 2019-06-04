# Site news

Интерфейс для создания новостей с галлереей. После создания у новости есть вкладки "Просмотр", "Галлерея" и "Метатеги". С помощью команд можно все это переписать.

## Установка

`composer require portedcheese\site-news`

`php artisan migrate` - Таблицы для новостей.

`php artisan make:news` - Создает конфиг и модель.

`php artisan override:news --site --admin` - Создает контроллеры и предлагает добавить роуты. Это если нужно переписать логику.

`php artisan vendor:publish --provider="PortedCheese\SiteNews\SiteNewsServiceProvider" --tag=views-site` - Если нужно поменять стандартный вывод на сайт.

`php artisan vendor:publish --provider="PortedCheese\SiteNews\SiteNewsServiceProvider" --tag=views-admin` - Если нужно поменять стандартный вывод в админку.

`@includeIf("site-news::admin.news.menu")` - меню для админки.
