# Instrucciones de Instalación en Hostinger (Hosting Compartido)

## Estructura de archivos en el servidor

```
/home/tu-usuario/
├── public_html/              <- Carpeta pública (accesible desde web)
│   ├── index.php            <- Copiar desde prod/index.php
│   ├── .htaccess            <- Copiar desde prod/.htaccess
│   ├── css/                 <- Copiar desde public/build/assets/*.css
│   ├── js/                  <- Copiar desde public/build/assets/*.js
│   └── storage/             <- Enlace simbólico a ../estacionamiento-moreno/storage/app/public
│
└── estacionamiento-moreno/   <- Todo el proyecto Laravel (fuera de public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/              <- NO usar esta carpeta, usar public_html
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env                 <- IMPORTANTE: Configurar
    ├── artisan
    └── composer.json
```

## Pasos de instalación

### 1. Subir archivos al servidor

**Opción A: Via FTP/SFTP (FileZilla, WinSCP)**
- Sube todo el proyecto a `/home/tu-usuario/estacionamiento-moreno/`
- Sube `prod/index.php` a `/home/tu-usuario/public_html/index.php`
- Sube `prod/.htaccess` a `/home/tu-usuario/public_html/.htaccess`

**Opción B: Via SSH (más rápido)**
```bash
# Comprimir el proyecto localmente
tar -czf proyecto.tar.gz --exclude=node_modules --exclude=.git .

# Subir al servidor (ajusta la IP/dominio)
scp proyecto.tar.gz usuario@tu-dominio.com:/home/tu-usuario/

# En el servidor, descomprimir
ssh usuario@tu-dominio.com
cd /home/tu-usuario
tar -xzf proyecto.tar.gz -C estacionamiento-moreno
rm proyecto.tar.gz
```

### 2. Copiar archivos públicos a public_html

```bash
# Conectarse via SSH a Hostinger
ssh usuario@tu-dominio.com

cd /home/tu-usuario

# Copiar index.php y .htaccess
cp estacionamiento-moreno/prod/index.php public_html/
cp estacionamiento-moreno/prod/.htaccess public_html/

# Copiar assets de Vite/Laravel Mix
cp -r estacionamiento-moreno/public/build public_html/
cp -r estacionamiento-moreno/public/css public_html/ 2>/dev/null || true
cp -r estacionamiento-moreno/public/js public_html/ 2>/dev/null || true

# Crear enlace simbólico para storage
ln -s /home/tu-usuario/estacionamiento-moreno/storage/app/public /home/tu-usuario/public_html/storage
```

### 3. Configurar permisos

```bash
cd /home/tu-usuario/estacionamiento-moreno

# Permisos para storage y bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Si el servidor tiene usuario específico (ej: www-data)
# chown -R www-data:www-data storage bootstrap/cache
```

### 4. Configurar el archivo .env

```bash
cd /home/tu-usuario/estacionamiento-moreno

# Copiar el archivo de ejemplo si no existe
cp .env.example .env

# Editar con nano o vim
nano .env
```

**Configuración importante:**

```env
APP_NAME="Estacionamiento Moreno"
APP_ENV=production
APP_KEY=base64:TU_KEY_AQUI  # Generar con: php artisan key:generate
APP_DEBUG=false  # IMPORTANTE: false en producción
APP_URL=https://tu-dominio.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Base de datos (obtener de Hostinger panel)
DB_CONNECTION=mysql
DB_HOST=localhost  # o el host que te dé Hostinger
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario_db
DB_PASSWORD=contraseña_db

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configurar email (opcional, para recuperación de contraseñas)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@tu-dominio.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Instalar dependencias (si no vienen en el proyecto)

```bash
cd /home/tu-usuario/estacionamiento-moreno

# Si Composer no está instalado globalmente en Hostinger
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Instalar dependencias de producción
php composer.phar install --optimize-autoloader --no-dev

# O si composer está instalado globalmente
composer install --optimize-autoloader --no-dev
```

### 6. Ejecutar migraciones y comandos Laravel

```bash
cd /home/tu-usuario/estacionamiento-moreno

# Generar application key (si aún no se hizo)
php artisan key:generate

# Ejecutar migraciones
php artisan migrate --force

# Limpiar y optimizar cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Crear enlace simbólico para storage (si no se hizo antes)
php artisan storage:link
```

### 7. Verificar que funciona

Visita tu dominio: `https://tu-dominio.com`

Si ves errores:
- Verifica que `APP_DEBUG=true` temporalmente para ver errores
- Revisa logs en `storage/logs/laravel.log`
- Verifica permisos de carpetas

### 8. Configuración adicional de Hostinger

**En el panel de Hostinger:**

1. **Configurar dominio**: Asegúrate de que el dominio apunta a `public_html`
2. **SSL/HTTPS**: Activa el certificado SSL gratuito
3. **PHP Version**: Usa PHP 8.1 o superior (desde el panel)
4. **Base de datos**: Crea la base de datos MySQL desde el panel

### 9. Comandos útiles para mantenimiento

```bash
# Limpiar toda la caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Volver a optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 10. Actualizar el proyecto en el futuro

```bash
# 1. Subir nuevos archivos (via FTP o git pull)
cd /home/tu-usuario/estacionamiento-moreno
git pull origin main  # Si usas Git

# 2. Instalar nuevas dependencias
composer install --optimize-autoloader --no-dev

# 3. Ejecutar migraciones nuevas
php artisan migrate --force

# 4. Limpiar caché
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Copiar nuevos assets si hay
cp -r public/build/* /home/tu-usuario/public_html/build/
```

## Solución de problemas comunes

### Error 500
- Verifica permisos de `storage/` y `bootstrap/cache/`
- Revisa el archivo `.env`
- Mira los logs en `storage/logs/laravel.log`

### Imágenes no cargan
- Verifica que el enlace simbólico de storage existe
- Verifica permisos de `storage/app/public/`

### CSS/JS no cargan
- Verifica que copiaste la carpeta `build/` correctamente
- Revisa rutas en el HTML generado

### Base de datos no conecta
- Verifica credenciales en `.env`
- Asegúrate de que la base de datos existe en el panel de Hostinger
- Verifica que el usuario tiene permisos

## Seguridad

✅ **IMPORTANTE**:
- Mantén `APP_DEBUG=false` en producción
- No expongas el archivo `.env`
- Mantén Laravel actualizado: `composer update`
- Haz backups regulares de la base de datos
- Usa contraseñas fuertes para la base de datos

## Contacto

Si tienes problemas, revisa:
- Documentación de Laravel: https://laravel.com/docs
- Documentación de Hostinger: https://www.hostinger.com/tutorials/
