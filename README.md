## Инструкция по запуску
- Установить Docker (если не установлен)
- В директории с проектом:
```
  docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/var/www/html \
  -w /var/www/html \
  laravelsail/php81-composer:latest \
  composer install --ignore-platform-reqs
  ```
- И затем: ```docker-compose up -d && docker exec -it app php artisan migrate```
- Profit!


- Фронт доступен по адресу <a href="http://localhost:8080" target="_blank">http://localhost:8080</a>
- Бэк доступен по адресу <a href="http://localhost:80" target="_blank">http://localhost:80</a>

Postman-коллекция (```StorageAPI.postman_collection.json```) в репозитории

Для проверки пагинации можно запустить команду ```docker exec -it app php artisan db:seed --class=CloneFiles``` – она скопирует первую строку из БД 150 раз (НО НЕ СКОПИРУЕТ ОБЪЕКТЫ В ХРАНАЛИЩЕ)


Используемый стек: ```Laravel 10```, ```Vue 3 (Composition API)```, ```PostgreSQL```, ```Minio (S3)```
