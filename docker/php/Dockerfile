# This file has been created with the help of the source mentioned below.
# https://github.com/hanieas/Docker-Laravel/blob/master/php/Dockerfile
FROM php:8.3-fpm

#Install Composer
RUN echo "Install COMPOSER"
RUN cd /tmp \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

#Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Update package manager and install useful tools
RUN apt-get update

#Install important libraries
RUN echo "Install important libraries"
RUN apt-get -y install --fix-missing \
    apt-utils \
    build-essential \
    git \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    libbz2-dev \
    locales \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev

# Install Postgres PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www

# Expose the port
EXPOSE 9000

# Define the entry point
CMD ["php-fpm"]