<p>
Нужна стандартная площадка на php7.4 + mysql
</p>
<p>
Установка стандартная для laravel (для докера добавлен docker-compose.yml на php7.4/mysql 8/ngnx)<br>После разворачивания репо необходимо выполнить следующие команды:
<br>
composer install<br>
php artisan key:generate<br>
php artisan migrate
</p>
<p>
Доступы к базе указываются в .env файле.
Там же должен быть USER_SIG_SECRET_KEY - соль для проверки входящего sig ключа.
</p>
<p>
Документация доступна по пути /api/documentation
</p>
<p>
Также реализовал функциональные тесты на добавление и обновление пользователя (tests/Feature/UserAuthTest.php)
</p>
<p>
По поводу задания, я бы не сказал, что оно на авторизацию, скорее на актуализацию данных пользователя.
Хотя, возможно я его неправильно понимаю.
</p>
<p>
По времени ушло часа 4
</p>
<p>
Ссылка на тестовое задание: https://docs.google.com/document/d/1l8RZGSZJo-3p5o8E8v8CcuLIeuUUf9hH/edit
</p>
