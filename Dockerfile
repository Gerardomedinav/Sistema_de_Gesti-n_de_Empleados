# Dockerfile
FROM php:8.3-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Habilitar mod_rewrite para URLs amigables
RUN a2enmod rewrite headers expires deflate mime autoindex dir mime

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias PHP
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html