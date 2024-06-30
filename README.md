# EXCHANGE RATE SERVICE

## Поднятие проекта
### Склонировать репозиторий и перейти в директорию
```shell script
git clone git@github.com:mbelostropov96/exchange-rate-service.git
cd exchange-rate-service
```

### Собрать и поднять контейнеры
```shell script
docker-compose build
docker-compose up -d
```

## При первом запуске:
### выполнить миграцию
```shell script
php artisan migrate --seed
```
Будет создан пользователь с входными данными
- email: admin@admin.com
- password: 111

### Скопировать конфигурационный файл
```shell script
cp .env.example .env
```
В файле указать данные для подключения к бд

### Зайти в контейнер
```shell script
docker exec -it exchange-rate-service_php_1 /bin/bash
```

### Установить пакеты
```
composer install
```

### Сгенерированить ключ приложения
```
php artisan key:generate
```

### Сгенерированить secret JWT
```
php artisan jwt:secret
```

## Работа с проектом

### Эндпоинты:
```
- создание нового пользователя
POST: http://localhost:8080/api/v1/register
{
    "name": <имя>,
    "email": <почта>,
    "password": <пароль>
}

- получение доступа
POST: http://localhost:8080/api/v1/login
{
    "email": <почта>,
    "password": <пароль>
}

- отозвать доступ
GET: http://localhost:8080/api/v1/logout

- Получить список валют
GET: http://localhost:8080/api/v1?method=list&currency=<currency> (or /api/v1/currency/list?currency=<currency>)

- Конвентировать валюты
POST: http://localhost:8080/api/v1?method=convert (or /api/v1/currency/convert)
{
    "currency_from": <currency_from>,
    "currency_to": <currency_to>,
    "value": <value_from>
}
```
