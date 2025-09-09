# Usamos una imagen oficial de PHP con Apache (más estable que artisan serve en Railway)
FROM php:8.2-apache

# Instalamos dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cambiamos el DocumentRoot de Apache a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiamos todo el proyecto
COPY . /var/www/html/

# Instalamos dependencias de PHP y Node
WORKDIR /var/www/html
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs
RUN npm ci && npm run build

# Generamos la clave de Laravel (si no existe)
RUN php artisan key:generate

# Cacheamos configuraciones
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Permitimos que Apache escriba logs y storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponemos el puerto 80
EXPOSE 80

# Iniciamos Apache en primer plano
CMD ["apache2-foreground"]