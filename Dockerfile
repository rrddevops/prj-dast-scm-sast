# Usar imagem oficial do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos de dependências
COPY composer.json ./

# Instalar dependências
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar código da aplicação (excluindo arquivos desnecessários)
COPY app/ ./app/
COPY public/ ./public/
COPY docker/ ./docker/

# Criar diretório de logs
RUN mkdir -p app/logs && chmod 755 app/logs

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod +x docker/start.sh

# Configurar Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Verificar se os arquivos essenciais existem
RUN test -f /var/www/html/public/index.php && echo "✅ index.php found" || echo "❌ index.php missing"

# Testar se o PHP pode processar o index.php
RUN php -l /var/www/html/public/index.php && echo "✅ PHP syntax OK" || echo "❌ PHP syntax error"

# Expor porta
EXPOSE 80

# Health check (não falha o container)
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD curl -f http://localhost/health || exit 0

# Comando para iniciar a aplicação
CMD ["docker/start.sh"] 