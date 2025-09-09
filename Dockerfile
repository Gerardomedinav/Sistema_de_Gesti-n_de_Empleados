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

# ✅ Configurar Apache para servir desde /public (¡la forma correcta para Railway!)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# ✅ Habilitar mod_rewrite (¡imprescindible para Laravel!)
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# Entrar al directorio
WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# Instalar y compilar assets
RUN npm ci && npm run build --if-present

# Cache (solo en producción)
RUN php artisan config:cache
# RUN php artisan route:cache   ← ¡COMENTADO por el conflicto de 'home'!
RUN php artisan view:cache

# ✅ Dar permisos (777 para logs, 755 para public)
RUN chmod -R 777 storage bootstrap/cache
RUN chmod -R 755 public

# Puerto
EXPOSE 80

# ✅ Iniciar Apache (Railway se encarga del puerto $PORT automáticamente)
CMD ["apache2-foreground"]