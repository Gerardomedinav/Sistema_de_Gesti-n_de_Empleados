# Usa una imagen oficial de PHP con Apache
FROM php:8.3-apache

# Directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite para URLs amigables
RUN a2enmod rewrite headers expires deflate mime autoindex dir mime

# Cambiar DocumentRoot a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!DocumentRoot /var/www/html!DocumentRoot ${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Instalar extensiones PHP comunes requeridas por Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd opcache

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Node.js y npm (opcional)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x  | bash - && apt-get install -y nodejs

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias JS (opcional)
RUN npm install --production

# Limpiar caché existente
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan cache:clear

# Cachear configuración para producción
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache