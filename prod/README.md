# Archivos de Producción para Hostinger

Esta carpeta contiene todos los archivos necesarios para deployar el proyecto en Hostinger (hosting compartido).

## Contenido

- **index.php** - Archivo principal modificado para apuntar al proyecto Laravel fuera de public_html
- **.htaccess** - Configuración de Apache para manejar las rutas de Laravel
- **INSTRUCCIONES_INSTALACION.md** - Guía completa paso a paso para instalar
- **.env.production.example** - Plantilla del archivo .env para producción
- **deploy.sh** - Script automatizado para actualizar el proyecto

## Estructura en el servidor

```
/home/tu-usuario/
├── public_html/              ← Archivos accesibles públicamente
│   ├── index.php            ← De prod/index.php
│   ├── .htaccess            ← De prod/.htaccess
│   ├── build/               ← Copiado desde public/build/
│   └── storage/             ← Enlace simbólico
│
└── estacionamiento-moreno/   ← TODO el proyecto Laravel
    ├── app/
    ├── config/
    ├── database/
    ├── resources/
    ├── storage/
    └── ...
```

## Inicio rápido

1. Lee **INSTRUCCIONES_INSTALACION.md** completo
2. Sube el proyecto al servidor
3. Configura el archivo .env
4. Ejecuta las migraciones
5. Copia index.php y .htaccess a public_html

## Notas importantes

⚠️ **NUNCA** subas el archivo `.env` con credenciales al repositorio
⚠️ Mantén `APP_DEBUG=false` en producción
⚠️ Haz backups regulares de la base de datos

## Soporte

Para problemas específicos de Hostinger, consulta:
https://www.hostinger.com/tutorials/

Para Laravel:
https://laravel.com/docs
