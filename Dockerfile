# Use a imagem PHP oficial como base
FROM php:8.1-cli

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libsqlite3-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libpq-dev git unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql

# Instalar extensões do PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql

# Copiar configuração do php.ini para o container
COPY php.ini /usr/local/etc/php/

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o arquivo composer.json para o container
COPY ./backend/composer.json /var/www/html/

# Instalar dependências do Composer no container
RUN composer install --no-interaction --no-scripts --no-plugins

# Copiar o restante do código-fonte para o container
COPY . .

# Gera o autoload do Composer
RUN composer dump-autoload --optimize

# Define o comando padrão para iniciar o container
CMD ["php", "-S", "0.0.0.0:8000", "index.php"]
