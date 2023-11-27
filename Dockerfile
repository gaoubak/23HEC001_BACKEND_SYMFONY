# Use the php:8.2-fpm image as the base image
FROM php:8.2-fpm-alpine

# Install necessary dependencies
RUN apk update \
    && apk add --no-cache \
        git icu-dev libzip-dev libxml2-dev libpng-dev libxslt-dev unzip postgresql-dev nodejs npm wget \
        musl-locales oniguruma-dev autoconf g++ make nginx

# Set the locale to Paris, France
ENV LANG fr_FR.UTF-8
ENV LANGUAGE fr_FR:fr
ENV LC_ALL fr_FR.UTF-8

# Ensure the necessary directories exist and set correct permissions
RUN mkdir -p /var/lib/nginx/tmp/client_body /var/lib/nginx/logs \
    && chown -R www-data:www-data /var/lib/nginx

# Create a new error log file and set correct permissions
RUN touch /var/lib/nginx/logs/error.log \
    && chown www-data:www-data /var/lib/nginx/logs/error.log

# Ensure www-data has write permissions for client_body
RUN chmod 755 /var/lib/nginx/tmp/client_body

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer

# Configure and install PHP extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql opcache intl zip calendar dom mbstring gd xsl

# Install APCu extension
RUN pecl install apcu && docker-php-ext-enable apcu

# Start Nginx and PHP-FPM
CMD nginx && php-fpm

EXPOSE 9000

# Set the working directory
WORKDIR /var/www/html/
