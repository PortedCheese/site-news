# Site news

Интерфейс для создания новостей с галлереей. После создания у новости есть вкладки "Просмотр", "Галлерея" и "Метатеги".

## Установка

`composer require portedcheese\site-news`

`php artisan migrate` - Таблицы для новостей.

`php artisan make:news` - Создаст контроллер и предложит дополнить файл с роутами.

`php artisan vendor:publish --provider="PortedCheese\SiteNews\SiteNewsServiceProvider" --tag=views` - Если нужно поменять стандартный вывод на сайт.

`@includeIf("site-news::admin.news.menu")` - меню для админки.
