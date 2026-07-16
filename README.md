# TechStore Explorer

Aplicación de catálogo de productos que consume la Fake Store API de Platzi, con autenticación, lista de favoritos, dashboard con KPIs y API REST propia.

## Stack tecnológico

- **Backend:** Laravel 13
- **Frontend:** Livewire + Tailwind CSS + React
- **Base de datos:** MySQL / MariaDB (o SQLite para pruebas rápidas)
- **API externa:** [Fake Store API](https://fakeapi.platzi.com/)
- **Autenticación:** Laravel Breeze + Sanctum
- **Correo:** Mailtrap (SMTP de pruebas)
- **Hosting:** Railway (gratuito)

## Requisitos

| Herramienta | Versión mínima | Cómo verificar |
|-------------|---------------|----------------|
| PHP | 8.3+ | `php -v` |
| Composer | 2.x | `composer -v` |
| Node.js | 20+ | `node -v` |
| npm | 9+ | `npm -v` |
| MySQL | 8.0+ / MariaDB 10.3+ | — |

> Para pruebas rápidas puedes usar SQLite en lugar de MySQL (ver paso 4).

## Instalación local

### 1. Clonar el repositorio

```bash
# Con HTTPS
git clone https://gitlab.com/Juan-7u7/techstore-explorer.git

# O con SSH
git clone git@gitlab.com:Juan-7u7/techstore-explorer.git

cd techstore-explorer
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

> Si aparece un error de extensiones faltantes (ej: `ext-gd`, `ext-pdo_mysql`),
> instálalas según tu sistema operativo y vuelve a ejecutar `composer install`.

### 3. Instalar dependencias de Node

```bash
npm install
```

> **Windows:** El proyecto incluye un archivo `.npmrc` con `force=true`
> para evitar errores con el binding nativo de rolldown.
> En Linux/macOS no necesitas hacer nada adicional.

### 4. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` y configura la base de datos:

**Opción A — SQLite (rápido, sin servidor MySQL):**

```env
DB_CONNECTION=sqlite
```

Luego crea el archivo de base de datos:

```bash
# En Linux/macOS:
touch database/database.sqlite

# En Windows (PowerShell):
New-Item -ItemType File -Path database/database.sqlite -Force
```

**Opción B — MySQL (producción):**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techstore_explorer
DB_USERNAME=root
DB_PASSWORD=
```

Crea la base de datos en MySQL antes de continuar:

```bash
mysql -u root -p -e "CREATE DATABASE techstore_explorer"
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto crea todas las tablas y un usuario de prueba:

- **Email:** `admin@test.com`
- **Password:** `password`

### 6. Compilar assets

```bash
npm run build
```

### 7. Iniciar servidor

```bash
php artisan serve
```

Abre [http://localhost:8000](http://localhost:8000) en tu navegador.

> **Para desarrollo con recarga automática (hot-reload):**
> Abre dos terminales:
> ```bash
> # Terminal 1 — Compilación de assets en vivo
> npm run dev
>
> # Terminal 2 — Servidor PHP
> php artisan serve
> ```

## Variables de entorno

El archivo `.env` debe tener al menos esta configuración mínima:

```env
APP_NAME="TechStore Explorer"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techstore_explorer
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
```

### Mailtrap (notificaciones por correo)

Para probar el envío de correos al agregar favoritos, regístrate en
[Mailtrap](https://mailtrap.io) y configura:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
MAIL_FROM_ADDRESS=noreply@techstore-explorer.com
MAIL_FROM_NAME="${APP_NAME}"
```

> Con `MAIL_MAILER=log` los correos se guardan en `storage/logs/laravel.log`
> sin necesidad de Mailtrap.

## Endpoints de la API propia

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/favorites` | Lista los favoritos del usuario | Sanctum token |
| POST | `/api/favorites` | Agrega un producto a favoritos | Sanctum token |
| DELETE | `/api/favorites/{id}` | Elimina un favorito por product_id | Sanctum token |

### Ejemplo de uso con cURL

```bash
# 1. Obtener un token de Sanctum
php artisan tinker
$user = \App\Models\User::first();
$user->createToken('api-test')->plainTextToken;

# 2. Agregar un favorito
curl -X POST http://localhost:8000/api/favorites \
  -H "Authorization: Bearer TU_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"product_id": 1, "product_data": {"title": "Producto", "price": 100}}'

# 3. Listar favoritos
curl http://localhost:8000/api/favorites \
  -H "Authorization: Bearer TU_TOKEN"

# 4. Eliminar favorito
curl -X DELETE http://localhost:8000/api/favorites/1 \
  -H "Authorization: Bearer TU_TOKEN"
```

### Probar con Postman / Insomnia

1. Importa el archivo `docs/techstore-explorer.postman_collection.json`
   o `docs/techstore-explorer.insomnia.json`
2. Define `base_url` como `http://localhost:8000`
3. Obtén un token de Sanctum (ver ejemplo arriba)
4. Copia el token en la variable `token` del collection

## Solución de problemas

| Error | Causa | Solución |
|-------|-------|----------|
| `port 8000 already in use` | Otro proceso usa el puerto | `php artisan serve --port=8080` |
| `The only supported ciphers are...` | OpenSSL desactualizado | Usar `APP_ENV=local` o actualizar PHP |
| `Class "App\Models\..." not found` | Composer autoload desactualizado | `composer dump-autoload` |
| `Target class [xxx] does not exist` | Error de caché de Laravel | `php artisan optimize:clear` |
| `npm ERR! code EBADPLATFORM` | Binding nativo incorrecto | Ya resuelto con `.npmrc` (ver paso 3) |
| `SQLSTATE[HY000] General error: 1 no such function: JSON_UNQUOTE` | Dashboard usa funciones MySQL | Cambiar a `DB_CONNECTION=mysql` en `.env` |
| Página en blanco sin estilos | Assets sin compilar | `npm run build` |

## Notas sobre la API

Esta prueba utiliza la **Fake Store API de Platzi** (`https://fakeapi.platzi.com/`)
tal como se solicitó en los requisitos. Durante el desarrollo se observó que algunos
productos pueden devolver imágenes rotas o nulas, por lo que se implementó un
fallback con una imagen placeholder local (`public/images/placeholder.svg`).

## Uso de IA

La inteligencia artificial (OpenCode) se utilizó exclusivamente para la redacción de comentarios y documentación del código. Toda la lógica de negocio, arquitectura, implementación y toma de decisiones fue realizada de forma manual.

## Licencia

Este proyecto es de uso educativo como parte de una prueba técnica para Cocktail.
