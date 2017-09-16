#!/usr/bin/env sh

DIR=$(pwd)
SCRIPT=$(readlink -f "$0")
cd "$(dirname ${SCRIPT})/../.."

. docker/scripts/.colors

if [ "$1" = "" ]
then
    echo ""
    color_info "    Usage: build.sh path_to_project"
    color_info ""
    exit 125
fi


CI_PROJECT_DIR=$1

echo ""
color_info "=======>>> Сборка проекта"
color_info "---> • path_to_project: $CI_PROJECT_DIR"
echo ""

# Скачиваем зависимости
docker pull registry.gitlab.com/xxxcoltxxx/grid-laravel-example/build > /dev/null || exit 127
docker pull registry.gitlab.com/xxxcoltxxx/grid-laravel-example/php > /dev/null || exit 127
docker pull registry.gitlab.com/xxxcoltxxx/grid-laravel-example/node > /dev/null || exit 127
docker pull registry.gitlab.com/xxxcoltxxx/grid-laravel-example/web > /dev/null || exit 127

docker run -w /app -u $(id -u):$(id -g) -v ${CI_PROJECT_DIR}:/tmp/app registry.gitlab.com/xxxcoltxxx/grid-laravel-example/build cp -r /app/* /tmp/app/ || exit 127

cp .env.example .env
docker run registry.gitlab.com/xxxcoltxxx/grid-laravel-example/php php artisan key:generate
docker run registry.gitlab.com/xxxcoltxxx/grid-laravel-example/node npm i
docker run registry.gitlab.com/xxxcoltxxx/grid-laravel-example/node bower i
docker run registry.gitlab.com/xxxcoltxxx/grid-laravel-example/node gulp

docker build -f ./docker/build/Dockerfile -t registry.gitlab.com/xxxcoltxxx/grid-laravel-example/build -q . || exit 127
docker build -f ./docker/php/Dockerfile -t registry.gitlab.com/xxxcoltxxx/grid-laravel-example/php -q . || exit 127
docker build -f ./docker/node/Dockerfile -t registry.gitlab.com/xxxcoltxxx/grid-laravel-example/node -q . || exit 127
docker build -f ./docker/web/Dockerfile -t registry.gitlab.com/xxxcoltxxx/grid-laravel-example/web -q . || exit 127

docker push registry.gitlab.com/xxxcoltxxx/grid-laravel-example/build | grep -vE "(Preparing|Waiting|Layer already exists)" || exit 127
docker push registry.gitlab.com/xxxcoltxxx/grid-laravel-example/php | grep -vE "(Preparing|Waiting|Layer already exists)" || exit 127
docker push registry.gitlab.com/xxxcoltxxx/grid-laravel-example/node | grep -vE "(Preparing|Waiting|Layer already exists)" || exit 127
docker push registry.gitlab.com/xxxcoltxxx/grid-laravel-example/web | grep -vE "(Preparing|Waiting|Layer already exists)" || exit 127


color_info "<<<======= Сборка проекта"
echo ""

cd ${DIR}
