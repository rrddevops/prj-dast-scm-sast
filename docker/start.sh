#!/bin/bash

# Criar diretórios de log se não existirem
mkdir -p /var/log/nginx
mkdir -p /var/log/php-fpm

# Iniciar PHP-FPM
echo "Starting PHP-FPM..."
php-fpm -D

# Aguardar PHP-FPM inicializar
sleep 2

# Verificar se PHP-FPM está rodando
if pgrep -f "php-fpm" > /dev/null; then
    echo "✅ PHP-FPM is running"
else
    echo "❌ PHP-FPM failed to start"
    exit 1
fi

# Iniciar Nginx
echo "Starting Nginx..."
nginx -g "daemon off;" 