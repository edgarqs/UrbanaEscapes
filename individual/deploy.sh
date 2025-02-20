#!/bin/bash

echo "🚀 Iniciando despliegue en VPS..."

# Ir a la carpeta del proyecto
cd /var/www/html/grup-6-edgar-quirante/individual || exit

# Hacer pull de la última versión desde GitLab
echo "📥 Descargando últimos cambios..."
git pull origin main

# Instalar dependencias por si hay cambios
echo "📦 Instalando paquetes..."
npm install

# Construir la aplicación con Vite
echo "🔨 Construyendo la aplicación..."
npm run build

# Ajustar permisos a la carpeta /dist
echo "🔑 Ajustando permisos..."
sudo chown -R www-data:www-data /var/www/html/grup-6-edgar-quirante/individual/dist
sudo chmod -R 755 /var/www/html/grup-6-edgar-quirante/individual/dist

# Reiniciar Nginx (opcional si hay cambios en configuración)
echo "🔄 Reiniciando Nginx..."
sudo systemctl restart nginx

echo "✅ ¡Despliegue completado!"
