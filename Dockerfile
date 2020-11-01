FROM ubuntu:latest

RUN apt-get update && apt-get install -y vim curl net-tools php7.4-common php7.4-cli php7.4-mysql php7.4-xml php7.4-mbstring php7.4-mongodb php7.4-curl
WORKDIR /app

COPY ./vendor /app/vendor
COPY ./index.php /app/index.php
COPY ./src      /app/src
COPY ./config   /app/config
COPY ./bin      /app/bin

# COPY ./start.sh /app/start.sh
COPY ./composer.json /app/composer.json
COPY ./configuration_template.txt /app

RUN php -v

CMD ["php", "-S", "0.0.0.0:7770"]
# CMD ["./start.sh"]
