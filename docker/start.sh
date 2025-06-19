#!/bin/bash

# Criar diretórios de log se não existirem
mkdir -p /var/log/nginx
mkdir -p /var/log/php-fpm

# Iniciar PHP-FPM
echo "Starting PHP-FPM..."
php-fpm -D

# Aguardar PHP-FPM inicializar
sleep 3

# Verificar se PHP-FPM está rodando (usando ps em vez de pgrep)
if ps aux | grep -v grep | grep "php-fpm" > /dev/null; then
    echo "✅ PHP-FPM is running"
else
    echo "❌ PHP-FPM failed to start"
    # Não sair, apenas logar o erro
fi

# Iniciar Nginx
echo "Starting Nginx..."
nginx -g "daemon off;" 