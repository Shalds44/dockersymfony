FROM php:latest
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN apt update && apt install -y zip git libicu-dev locales
RUN locale-gen fr_FR.UTF-8
RUN docker-php-ext-install opcache intl pdo_mysql
WORKDIR /app
COPY ./composer.json .
RUN composer install
COPY . .
RUN symfony server:ca:install
CMD [ "symfony", "serve" ]