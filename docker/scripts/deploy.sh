#!/usr/bin/env sh

DIR=$(pwd)
SCRIPT=$(readlink -f "$0")
cd "$(dirname ${SCRIPT})/../.."

. docker/scripts/.colors

NETWORK=multihost
# Проверяем наличие сети multihost
MULTI_HOST_NETWORK_EXISTS=$(docker network ls --filter name=${NETWORK} -q | wc -l | sed -e 's/^[ \t]*//')

# Создаём при необходимости
if [ "${MULTI_HOST_NETWORK_EXISTS}" = "0" ]
then
    color_info "---> • Create network ${NETWORK}"
    docker network create ${NETWORK}
fi

# Обновляем версию приложения

color_info "Скачивание изменений (на всякий случай)..."
color_command "cd /var/www/grid-laravel-example"
cd /var/www/grid-laravel-example
color_command "git fetch origin master"
git fetch origin master || exit 127
color_command "git reset --hard origin/master"
git reset --hard origin/master || exit 127

color_info "Миграция БД..."
docker-compose -f docker-compose.yml run php php artisan migrate || exit 127

color_info "Обновление контейнеров..."
color_command "docker-compose -f docker-compose.yml pull"
docker-compose -f docker-compose.yml pull || exit 127
color_command "docker-compose -f docker-compose.yml up -d"
docker-compose -f docker-compose.yml up -d || exit 127

color_command "cd /var/www/sites-enabled"
cd /var/www/sites-enabled
color_command "ln ../grid-laravel-example/docker/web/grid-laravel.colt-web.ru.conf ."
ln -f ../grid-laravel-example/docker/web/grid-laravel.colt-web.ru.conf ./ || exit 127
color_command "cd /var/www"
cd /var/www
color_command "docker-compose up -d"
docker-compose up -d || exit 127
docker-compose restart || exit 127

cd ${DIR}
