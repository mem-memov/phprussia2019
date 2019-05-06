FROM ubuntu:18.04

RUN apt-get update && \
    apt-get -y dist-upgrade && \
    apt-get -y upgrade

# NGINX
RUN apt-get -y install nginx

# PHP deps
RUN apt-get -y install \
        zip \
        unzip \
        wget

# PHP
RUN mkdir /run/php && \
    chown www-data:www-data /run/php && \
    apt-get -y install software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    export DEBCONF_NONINTERACTIVE_SEEN=true DEBIAN_FRONTEND=noninteractive && \
    echo "Europe/Moscow" > /etc/timezone && \
    apt-get -y install \
        php7.2 \
        php7.2-dev \
        php7.2-fpm \
        php7.2-cli \
        php7.2-mysql \
        php7.2-dom \
        php7.2-mbstring \
        php7.2-bcmath \
        php7.2-curl

# COMPOSER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# XDEBUG
RUN wget "http://xdebug.org/files/xdebug-2.6.1.tgz" && \
    tar -xvzf xdebug-2.6.1.tgz && \
    cd xdebug-2.6.1 && \
    phpize && \
    ./configure && \
    make && \
    cp modules/xdebug.so /usr/lib/php/20170718 && \
    echo "[Xdebug]" >> /etc/php/7.2/fpm/php.ini && \
    echo "zend_extension = /usr/lib/php/20170718/xdebug.so" >> /etc/php/7.2/cli/php.ini && \
    echo "[Xdebug]" >> /etc/php/7.2/fpm/php.ini && \
    echo "zend_extension = /usr/lib/php/20170718/xdebug.so" >> /etc/php/7.2/fpm/php.ini && \
    echo "xdebug.remote_autostart=1" >> /etc/php/7.2/fpm/php.ini && \
    echo "xdebug.remote_enable=1" >> /etc/php/7.2/fpm/php.ini && \
    echo "xdebug.remote_connect_back=1" >> /etc/php/7.2/fpm/php.ini && \
    echo "xdebug.remote_port=9005" >> /etc/php/7.2/fpm/php.ini && \
    echo "xdebug.idekey=phprussia2019" >> /etc/php/7.2/fpm/php.ini

# configuration files
COPY ./site.conf /etc/nginx/sites-enabled/default
COPY ./fpm.conf /etc/php/7.2/fpm/pool.d/www.conf

# dev | prod
ENV SITE_MODE=dev
   
#      HTTP PHP-FPM
EXPOSE 80   9000

WORKDIR /var/www/html

CMD nginx & \
    /usr/sbin/php-fpm7.2 -F