# https://levelup.gitconnected.com/containerizing-apache2-php-fpm-on-alpine-linux-953430ea6dbc
#eduardomourag/pandora-php-apache

####################################
# System Linux Alpine and bash
####################################
#FROM alpine:latest
FROM httpd:2.4-alpine

RUN apk update && apk upgrade
RUN apk add bash

####################################
# install apache2
####################################
RUN apk add apache2

####################################
#install php82 dependency
####################################
#basics
RUN apk add php82 php82-fpm php82-opcache
#development and production envirioments
RUN apk add php82-gd php82-mbstring php82-intl php82-xml php82-redis php82-openssl php82-pdo php82-pdo_mysql php82-tokenizer
#just developement
RUN apk add php82-xdebug php82-phpdbg

### About extensions:
# php82-curl
# # caso o app tenha alguma api e precise de uma conexão externa é inseressante usar - no caso da MartaGolpista por ex: - não sei se o laravel precisa disso
# php8.0-igbinary
# Igbinary é um substituto para o serializador PHP padrão. Em vez da representação textual que consome tempo e espaço usada pelo serialize() do PHP , igbinary armazena estruturas de dados PHP em um formato binário compacto. A economia de memória é significativa ao usar memcached, APCu ou armazenamentos similares baseados em memória para dados serializados. A redução típica nos requisitos de armazenamento é de cerca de 50%. A porcentagem exata depende dos dados.

# php8.0-mbstring
# mbstringfornece funções de string específicas de multibyte que ajudam você a lidar com codificações multibyte em PHP. Além disso, mbstringtrata da conversão de codificação de caracteres entre os pares de codificação possíveis. mbstringfoi projetado para lidar com codificações baseadas em Unicode, como UTF-8 e UCS-2, e muitas codificações de byte único por conveniência

# php8.0-mysql # obrigatório para o mariadb e o mysql

# php8.0-phpdbg
# O phpdbg visa ser uma plataforma de depuração leve, poderosa e fácil de usar para PHP.

# php8.0-readline
# # readline php para terminal CLI
# php8.0-redis
# php8.0-xdebug
# php8.0-xml

# php8.0-intl
# A extensão de internacionalização (mais conhecida como Intl) é um wrapper para » biblioteca ICU, permitindo que programadores PHP executem várias operações com reconhecimento de localidade, incluindo, entre outras, formatação, transliteração, conversão de codificação, operações de calendário, » agrupamento em conformidade com UCA , localização de texto limites e trabalhar com identificadores de localidade, fusos horários e grafemas


####################################
# Copy and congig
####################################
#copy config ngix
# => make volumes to files conf
# => install ssl certificades
WORKDIR /usr/local/apache2/htdocs

# COPY etc/apache2 /etc/apache2
#certificates

RUN mkdir /etc/letsencrypts
COPY etc/letsencrypts/live/fraseteca.2023.io/server.crt /etc/letsencrypts/
COPY etc/letsencrypts/live/fraseteca.2023.io/server.key /etc/letsencrypts/
# COPY Docker/etc/letsencrypts/live/cdn.fraseteca.2023.io/server.crt /etc/apache2
# COPY Docker/etc/letsencrypts/live/cdn.fraseteca.2023.io/server.key /etc/apache2

# default setup to php82
COPY etc/php82 /etc/php82

#FIXED files
COPY bootstrap/ /usr/local/apache2/htdocs/bootstrap
COPY config/ /usr/local/apache2/htdocs/config
COPY vendor/ /usr/local/apache2/htdocs/vendor
COPY index.php /usr/local/apache2/htdocs
COPY artisan /usr/local/apache2/htdocs
COPY server.php /usr/local/apache2/htdocs
#
##php folder run
RUN mkdir /var/run/php

EXPOSE 80
EXPOSE 443

# Pendencias: criar localmente já o link correto, e apenas transportar para lá mo mesmo,  já que não pretendo executar localmente o ambiente mesmo
# CMD ["/bin/bash","rm /usr/local/apache2/htdocs/public/storage"]
# CMD ["/bin/bash","ln -s /usr/local/apache2/htdocs/storage/app/public/ /usr/local/apache2/htdocs/public/storage"]

STOPSIGNAL SIGTERM

# CMD ["/bin/bash", "-c", "php-fpm82 && chmod 777 /var/run/php/php82-fpm.sock && chmod 755 /usr/local/apache2/htdocs/* && apache2 -g 'daemon off;'"]
CMD ["tail","-f", "/dev/null"] #tranca o terminal com o container
