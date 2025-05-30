FROM php:8.3-fpm

ENV MY_PROJECT_ROOT=/var/www/html

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    zip \
    bcmath \
    ctype \
    fileinfo \
    dom \
    xml \
    curl \
    session \
    opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR $MY_PROJECT_ROOT

# Copiar archivos del proyecto (puedes ignorar vendor si usas volúmenes)
COPY ./api/ .

# Asignar permisos
RUN chown -R www-data:www-data $MY_PROJECT_ROOT && \
    chmod -R 755 $MY_PROJECT_ROOT

RUN mkdir /var/log/site && \
    chown www-data:www-data /var/log/site

# Instalar dependencias de Laravel
#RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader --working-dir=$MY_PROJECT_ROOT

EXPOSE 9000
CMD ["php-fpm"]
