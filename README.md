Проект демонстрирует возможности пакета grid-laravel

## Зависимости
- php
- composer
- npm
- nodejs-legacy
- bower
- gulp

### php
```sh
sudo apt-get install php5
```

### Composer
```sh
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

### npm
```sh
sudo apt-get install npm
```

### nodejs-legacy
```sh
sudo apt-get install nodejs-legacy
```

### bower
```sh
sudo npm i -g bower
```

### gulp
```sh
sudo npm i -g gulp
```
## Развертывание проекта

```sh
composer install
cp .env.example .env # Настроить соединение с БД в этом файле
php artisan key:generate
php artisan migrate
npm install
bower install
gulp
```