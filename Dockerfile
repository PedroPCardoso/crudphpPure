# Use a imagem PHP oficial como base
FROM php:8.1-cli

# Instala dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o conteúdo do diretório atual para o diretório de trabalho no container
COPY . .

# Define o comando padrão para iniciar o container
CMD ["php", "-S", "0.0.0.0:8000", "index.php"]
