FROM nginx:alpine

ADD ./docker/web/web.conf /etc/nginx/conf.d/default.conf
ADD . /app

RUN chmod -R 777 /app/storage
RUN chmod -R 777 /app/bootstrap

WORKDIR /app
