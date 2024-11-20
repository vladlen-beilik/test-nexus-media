<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Детали

В корне приложения находится `docker-compose.yml`. Можно поднять докер контейнеры и использовать `Makefile` (`make up`, `make down` команды);

В .env добавить:
- SHOPIFY_API_KEY=`{api_key}`
- SHOPIFY_PASSWORD=`{password}`
- SHOPIFY_SHOP=`099252c5f4bc43cd5d673f94338cb992:807c8caaf04ae7a79d863297769747a5@shortcodesdev.myshopify.com`

Порядок запуска:
- composer install
- npm i
- npm run build
- php artisan app:get-shopify-data (для первоначального парсинга данных из Shopify)

Переходим по http://localhost/ (это мой host) и пользуемся
