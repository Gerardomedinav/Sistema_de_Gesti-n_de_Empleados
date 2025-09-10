FROM php:8.2-apache

# Instalar dependencias del sistema
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
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configurar Apache para servir desde /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Habilitar mod_rewrite (imprescindible para Laravel)
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# Entrar al directorio
WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# Instalar y compilar assets
RUN npm ci && npm run build

# Cache (solo en producción) - COMENTAMOS EL ROUTE CACHE POR AHORA
RUN php artisan config:cache
# RUN php artisan route:cache   ← Comentado temporalmente por rutas duplicadas
RUN php artisan view:cache

# Dar permisos de escritura a storage y cache
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Asegurar permisos correctos para public/
RUN find public -type f -exec chmod 644 {} \;
RUN find public -type d -exec chmod 755 {} \;

# Puerto
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]