FROM node:8.5-alpine

RUN npm i -g bower
RUN npm i -g gulp

RUN apk update
RUN apk add python
RUN apk add make
RUN apk add g++
RUN apk add git

USER node
WORKDIR /app
