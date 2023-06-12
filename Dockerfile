# Define la imagen base de PHP que se usará para el contenedor
FROM php:8.1-apache

# Habilita los módulos de Apache necesarios para Laravel
RUN a2enmod rewrite headers

# Instala las dependencias necesarias para Laravel y para trabajar con MySQL
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        git \
        curl \
        libzip-dev \
        libicu-dev \
        libpq-dev \
        libssl-dev \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install zip \
        && docker-php-ext-install intl \
        && docker-php-ext-install bcmath \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install exif \
        && docker-php-ext-install opcache \
        && docker-php-ext-install gd \
        && docker-php-ext-install pdo_pgsql

# Descarga y configura Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Define el directorio de trabajo del contenedor
WORKDIR /var/www/html

#RUN composer clear-cache

# Instala las dependencias del proyecto con Composer
#RUN  /bin/sh -c composer install --no-interaction --prefer-dist

# Copia el archivo de configuración de Apache
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura las variables de entorno del contenedor
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Establece los permisos adecuados para los archivos de Laravel
RUN chown -R www-data:www-data /var/www/html/storage && \
    chmod -R 775 /var/www/html/storage && \
    chown -R www-data:www-data /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/bootstrap/cache

# Expone el puerto 80 del contenedor
EXPOSE 80

# Ejecuta el servidor Apache en primer plano al iniciar el contenedor
CMD ["apache2-foreground"]
