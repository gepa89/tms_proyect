# Usa la imagen base de PHP 8.1 con Apache
FROM php:8.1-apache

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    curl \
    libzip-dev \
    unzip \
    gnupg \
    && docker-php-ext-install pdo_mysql \
    && apt-get install -y vim \
    && apt-get install -y net-tools \
    && apt-get install -y apache2

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar la configuración de tu Virtual Host al contenedor
COPY ./config/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Instalar Node.js y Composer
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el código fuente de la aplicación
COPY src/ /var/www/html

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de Composer
RUN composer install

# Asegurarse de que Apache utilice el puerto 80
EXPOSE 80

# Comando por defecto para ejecutar Apache en primer plano
CMD ["apache2-foreground"]

