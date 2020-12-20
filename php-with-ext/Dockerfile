FROM php:7.4.10-fpm 
RUN ln -snf /usr/share/zoneinfo/Asia/Hong_Kong /etc/localtime && \
    apt update && \
    apt install -y libzip-dev unzip && \
    docker-php-ext-configure zip && \
    docker-php-ext-configure mysqli && \
    docker-php-ext-configure pdo_mysql && \
    docker-php-ext-install -j$(nproc) zip &&\
    docker-php-ext-install -j$(nproc) mysqli &&\
    docker-php-ext-install -j$(nproc) pdo_mysql &&\
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer && \
    composer global require laravel/installer
ENV PATH="/root/.composer/vendor/bin/:${PATH}"