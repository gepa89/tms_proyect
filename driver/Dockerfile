# Usa la imagen base de PHP 8.1 con Apache
FROM php:8.1-apache

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    curl \
    libzip-dev \
    unzip \
    gnupg \
    vim \
    net-tools \
    apache2 \
    && docker-php-ext-install pdo_mysql \
    && apt-get clean

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar la configuración de tu Virtual Host al contenedor
COPY ./config/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Descargar e instalar Composer y permitir su ejecución como superusuario
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && composer --version

# Copiar el código fuente de la aplicación
COPY src/ /var/www/html

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de Composer (solo si composer.json existe)
RUN if [ -f composer.json ]; then composer install; fi

# Exponer el puerto 80 para Apache
EXPOSE 80

# Comando por defecto para ejecutar Apache en primer plano
CMD ["apache2-foreground"]

