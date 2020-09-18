FROM php:7.4.10-fpm 
RUN apt update && \
    apt install -y libzip-dev unzip && \
    docker-php-ext-configure zip && \
    docker-php-ext-configure mysqli && \
    docker-php-ext-install -j$(nproc) zip &&\
    docker-php-ext-install -j$(nproc) mysqli &&\
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '795f976fe0ebd8b75f26a6dd68f78fd3453ce79f32ecb33e7fd087d39bfeb978342fb73ac986cd4f54edd0dc902601dc') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer && \
    composer global require laravel/installer
ENV PATH="/root/.composer/vendor/bin/:${PATH}"