#!/bin/bash

###############################################################################
# Script de deployment automático para Hostinger
# Uso: bash deploy.sh
###############################################################################

echo "🚀 Iniciando deployment en Hostinger..."

# Variables (AJUSTAR SEGÚN TU CONFIGURACIÓN)
PROYECTO_DIR="/home/tu-usuario/estacionamiento-moreno"
PUBLIC_DIR="/home/tu-usuario/public_html"

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Función para imprimir mensajes
print_msg() {
    echo -e "${GREEN}✓${NC} $1"
}

print_warn() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

# 1. Verificar que estamos en el directorio correcto
if [ ! -f "$PROYECTO_DIR/artisan" ]; then
    print_error "No se encontró el archivo artisan. ¿Estás en el directorio correcto?"
    exit 1
fi

print_msg "Directorio del proyecto verificado"

# 2. Poner la aplicación en modo mantenimiento
print_msg "Poniendo la aplicación en modo mantenimiento..."
cd "$PROYECTO_DIR"
php artisan down

# 3. Actualizar código (git pull si usas git)
# Descomentar si usas Git
# print_msg "Actualizando código desde repositorio..."
# git pull origin main

# 4. Instalar/actualizar dependencias de Composer
print_msg "Instalando dependencias de Composer..."
composer install --optimize-autoloader --no-dev

# 5. Limpiar caché
print_msg "Limpiando caché..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 6. Ejecutar migraciones (con precaución)
print_warn "¿Deseas ejecutar migraciones? (s/N)"
read -r response
if [[ "$response" =~ ^([sS][iI]|[sS])$ ]]; then
    print_msg "Ejecutando migraciones..."
    php artisan migrate --force
fi

# 7. Optimizar para producción
print_msg "Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 8. Copiar archivos públicos
print_msg "Copiando archivos públicos a public_html..."
cp -f "$PROYECTO_DIR/prod/index.php" "$PUBLIC_DIR/index.php"
cp -f "$PROYECTO_DIR/prod/.htaccess" "$PUBLIC_DIR/.htaccess"

# Copiar assets si existen
if [ -d "$PROYECTO_DIR/public/build" ]; then
    print_msg "Copiando assets de build..."
    cp -rf "$PROYECTO_DIR/public/build" "$PUBLIC_DIR/"
fi

# 9. Verificar/crear enlace simbólico de storage
if [ ! -L "$PUBLIC_DIR/storage" ]; then
    print_msg "Creando enlace simbólico para storage..."
    ln -s "$PROYECTO_DIR/storage/app/public" "$PUBLIC_DIR/storage"
else
    print_msg "Enlace simbólico de storage ya existe"
fi

# 10. Verificar permisos
print_msg "Verificando permisos..."
chmod -R 775 "$PROYECTO_DIR/storage"
chmod -R 775 "$PROYECTO_DIR/bootstrap/cache"

# 11. Sacar la aplicación del modo mantenimiento
print_msg "Quitando modo mantenimiento..."
php artisan up

print_msg "${GREEN}¡Deployment completado exitosamente!${NC}"
echo ""
echo "📋 Verificaciones finales:"
echo "   - Visita tu sitio web para confirmar que funciona"
echo "   - Revisa los logs en storage/logs/laravel.log si hay errores"
echo "   - Verifica que las imágenes carguen correctamente"
echo ""
