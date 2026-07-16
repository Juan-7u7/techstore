# TechStore Explorer

Aplicación de catálogo de productos que consume la Fake Store API de Platzi, con autenticación, lista de favoritos y API REST propia.

## Stack tecnológico

- **Backend:** Laravel 13
- **Frontend:** Livewire + Tailwind CSS + React
- **Base de datos:** MySQL (MariaDB)
- **API externa:** [Fake Store API](https://fakeapi.platzi.com/)
- **Autenticación:** Laravel Breeze + Sanctum
- **Correo:** Mailtrap (SMTP de pruebas)

## Requisitos

- PHP 8.3+
- Composer
- Node.js + npm
- MySQL / MariaDB

## Instalación local

```bash
# Clonar el repositorio
git clone git@gitlab.com:Juan-7u7/techstore-explorer.git
cd techstore-explorer

# Instalar dependencias de PHP
composer install

# Instalar dependencias de Node
npm install

# Copiar variables de entorno
cp .env.example .env

# Generar clave de la aplicación
php artisan key:generate

# Configurar base de datos en .env y ejecutar migraciones
php artisan migrate

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

## Variables de entorno

Copia `.env.example` a `.env` y configura:

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

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
MAIL_FROM_ADDRESS=noreply@techstore-explorer.com
MAIL_FROM_NAME="${APP_NAME}"
```



## Endpoints de la API propia

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/favorites` | Lista los favoritos del usuario | Sanctum token |
| POST | `/api/favorites` | Agrega un producto a favoritos | Sanctum token |
| DELETE | `/api/favorites/{id}` | Elimina un favorito por product_id | Sanctum token |

### Ejemplo de uso

```bash
# Obtener token (después de iniciar sesión)
curl -X POST http://localhost:8000/api/favorites \
  -H "Authorization: Bearer TU_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"product_id": 1, "product_data": {"title": "Producto", "price": 100}}'

# Listar favoritos
curl http://localhost:8000/api/favorites \
  -H "Authorization: Bearer TU_TOKEN"

# Eliminar favorito
curl -X DELETE http://localhost:8000/api/favorites/1 \
  -H "Authorization: Bearer TU_TOKEN"
```

### Probar con Postman / Insomnia

1. Importa el archivo `docs/techstore-explorer.postman_collection.json` o `docs/techstore-explorer.insomnia.json`
2. Define `base_url` (default: `http://localhost:8000`)
3. Obtén un token de Sanctum:

   ```bash
   php artisan tinker
   ```

   ```php
   $user = \App\Models\User::first();
   $user->createToken('api-test')->plainTextToken;
   ```

4. Copia el token en la variable `token` del collection

## Credenciales de prueba

Puedes registrar un usuario nuevo desde `/register` o usar:

- **Email:** `admin@test.com`
- **Password:** `password`

*(Ejecuta `php artisan db:seed` para crear este usuario de prueba)*

## Uso de IA

La inteligencia artificial (OpenCode) se utilizó exclusivamente para la redacción de comentarios y documentación del código. Toda la lógica de negocio, arquitectura, implementación y toma de decisiones fue realizada de forma manual.

## Licencia

Este proyecto es de uso educativo como parte de una prueba técnica para Cocktail.
