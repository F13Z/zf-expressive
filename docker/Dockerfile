FROM ubuntu:latest
ARG DEBIAN_FRONTEND=noninteractive

# Mise à jour du détôt
RUN apt-get update -qq && apt-get dist-upgrade -qq && apt-get install -qq \
    software-properties-common \
    language-pack-en-base \
    apt-transport-https \
    build-essential \
    sudo \
    wget \
    tzdata \
    vim

# Locales
RUN locale-gen en_US.UTF-8 && \
    update-locale LANG=en_US.UTF-8 && \
    ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    dpkg-reconfigure --frontend noninteractive tzdata
ENV LC_ALL=C.UTF-8

RUN apt-add-repository ppa:ondrej/php

# PHP 7.1 ainsi que quelques dépendances
RUN apt-get update -qq && apt-get install -y -qq \
    php7.1 \
    php7.1-curl \
    php7.1-mysql \
    php7.1-dev \
    php7.1-json \
    php-xdebug \
    mysql-client \
    mysql-server \
    apache2 \
    libapache2-mod-php7.0 \
    composer

# Apache
RUN a2enmod rewrite

COPY ./apache/sites/* /etc/apache2/sites-available/
RUN a2ensite 001-zf-expressive.conf
RUN mkdir /opt/run
COPY ./mysql/my.cnf /etc/mysql/
COPY ./php/xdebug.ini /etc/php/mods-available/

ADD bootstrap.sh /opt/run/
RUN chmod +x /opt/run/bootstrap.sh

WORKDIR /var/www/zf-expressive
CMD ["/opt/run/bootstrap.sh"]