FROM ubuntu:latest

RUN apt-get update && apt-get install -y vim curl net-tools php7.4-common php7.4-cli php7.4-mysql php7.4-xml php7.4-mbstring php7.4-mongodb php7.4-curl
WORKDIR /app

COPY ./vendor /app/vendor
COPY ./index.php /app/index.php
COPY ./src      /app/src
COPY ./config   /app/config
COPY ./bin      /app/bin


COPY ./composer.json /app/composer.json
COPY configuration-template.txt /app

COPY ./tcs-render/tcs-render /bin/tcs-render
COPY ./tcs-render/tcs-render.sh /bin/tcs-render.sh
# COPY ./start.sh /app/start.sh

RUN php -v
RUN /bin/tcs-render.sh -l /etc/configuration-template.txt -v /tce/conf/cm/local.json

# CMD ["tcs-render.sh", "-l", "/etc/configuration-template.txt", "-v", "/tce/conf/cm/local.json"]
# CMD ["./start.sh"]
CMD [ "php", "-S", "0.0.0.0:7770" ]
