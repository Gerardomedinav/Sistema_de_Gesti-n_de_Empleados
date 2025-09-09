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

# Configurar Apache para servir desde /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitar mod_rewrite (¡importante para Laravel!)
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# Entrar al directorio
WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# Instalar y compilar assets (si existen)
RUN npm ci && npm run build --if-present

# Generar APP_KEY si no está definida (fallback, pero mejor definirla en Railway)
RUN if [ -z "$APP_KEY" ]; then php artisan key:generate; fi

# Cache (solo en producción)
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Dar permisos de escritura a storage y cache (sin chown, con chmod es suficiente en Railway)
RUN chmod -R 775 storage bootstrap/cache
RUN chmod -R 775 public # por si usas file uploads o assets generados

# Puerto
EXPOSE 80

# Iniciar Apache en primer plano
CMD ["apache2-foreground"]