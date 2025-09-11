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
ENV APACHE_SERVER_NAME=localhost

# Habilitar mod_rewrite (imprescindible para Laravel)
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# Verificar estructura
RUN echo "=== Estructura de /var/www/html/public ===" && ls -la /var/www/html/public/

# Configurar Apache explícitamente
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/sites-available/000-default.conf && \
    echo "<Directory /var/www/html/public>" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    Options Indexes FollowSymLinks" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf && \
    echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Entrar al directorio
WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# Instalar dependencias Node.js
RUN npm ci

# Compilar assets
RUN npm run build

# Verificar que los archivos se generaron correctamente
RUN echo "=== Archivos generados en build ===" && ls -la public/build/assets/ 2>/dev/null || echo "No se encontraron archivos en build/assets"

RUN ls -la public/build
RUN ls -la public/build/assets

# Si no se generaron archivos en build, crear archivo CSS estático como fallback
RUN if [ ! -f public/build/assets/app-*.css ] && [ ! -f public/css/app.css ]; then \
        echo "Creando CSS estático como fallback..." && \
        mkdir -p public/css && \
        echo "/* Estilos básicos para Laravel */ body { font-family: 'Nunito', sans-serif; margin: 0; padding: 20px; background-color: #f5f5f5; } .navbar { background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; } .navbar-brand { font-weight: bold; color: #3097D1 !important; } .nav-link { color: #333; } .nav-link:hover { color: #3097D1; } .container { max-width: 1200px; margin: 0 auto; } .card { background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; } .btn { padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer; } .btn-primary { background-color: #3097D1; color: white; } .btn-primary:hover { background-color: #2579a9; } .form-control { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 10px; } .form-group { margin-bottom: 15px; } h1 { color: #333; text-align: center; }" > public/css/app.css; \
    fi

# Configurar Laravel para mostrar errores
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Cache (solo en producción)
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Dar permisos correctos
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Asegurar permisos correctos para public/
RUN find public -type f -exec chmod 644 {} \;
RUN find public -type d -exec chmod 755 {} \;

# Puerto
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]