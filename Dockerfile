FROM php:8.0-apache

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN a2enmod rewrite

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf


COPY . .

COPY schematool.sh /usr/local/bin/schematool.sh
RUN chmod +x /usr/local/bin/schematool.sh

ENTRYPOINT ["/usr/local/bin/schematool.sh"]

EXPOSE 80

#CMD ["apache2-foreground"]
