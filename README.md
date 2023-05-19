## Как развернуть проект

- Клонировать проект
- Создать БД
- Копировать .env.example на .env
- Поменять данные .env
- Установить зависимости composer `composer install`
- Запустить миграцию `php artisan migrate`
- Чтобы создать пользователь, роли и разрешения нужно запускать команду `php artisan migrate --seed`
- Для входа админку нужно ввести адрес `admin/login`
