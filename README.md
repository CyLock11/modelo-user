# API de gestión de usuarios

API REST sencilla desarrollada con Laravel para crear, consultar, iniciar sesión, actualizar y eliminar usuarios. Los datos se almacenan en SQLite y las contraseñas se guardan usando hash.

## Requisitos

- PHP 8.3 o superior
- Composer
- Node.js y npm (solo si quieres compilar los recursos de frontend)

## Instalación

Clona el repositorio y entra en el directorio del proyecto:

```bash
git clone <URL_DEL_REPOSITORIO>
cd modelo-user
```

Instala las dependencias y prepara el entorno:

```bash
composer install
```

Crea el archivo de entorno y genera la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

En Windows PowerShell, si aún no tienes `.env`, puedes usar:

```powershell
Copy-Item .env.example .env
```

La configuración de ejemplo usa SQLite. Crea el archivo de base de datos si no existe y ejecuta las migraciones:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
```

Inicia el servidor local:

```bash
php artisan serve
```

La API estará disponible en `http://127.0.0.1:8000/api`.

## Endpoints

Todas las rutas están bajo el prefijo `/api`. Las respuestas y solicitudes usan JSON.

| Método | Ruta | Descripción |
| --- | --- | --- |
| POST | `/api/user/create` | Crea un usuario |
| GET | `/api/user/get` | Lista usuarios, paginados de 10 en 10 |
| GET | `/api/user/login` | Comprueba email y contraseña |
| POST | `/api/user/update_username` | Actualiza el nombre de usuario |
| POST | `/api/user/update_email` | Actualiza el email |
| POST | `/api/user/update_password` | Cambia la contraseña |
| DELETE | `/api/user/delete` | Elimina el usuario |

### Crear usuario

`POST /api/user/create`

```json
{
  "username": "ana",
  "email": "ana@example.com",
  "password": "ClaveSegura123"
}
```

### Iniciar sesión

La ruta está definida actualmente como `GET /api/user/login`. Requiere `email` y `password`. Al ser una petición GET, las credenciales pueden quedar expuestas en la URL o en registros; para un uso real, cambia esta ruta a POST y envía las credenciales en el cuerpo JSON.

### Actualizar username

`POST /api/user/update_username`

```json
{
  "email": "ana@example.com",
  "password": "ClaveSegura123",
  "username": "ana_nueva"
}
```

### Actualizar email

`POST /api/user/update_email`

```json
{
  "email": "ana@example.com",
  "password": "ClaveSegura123",
  "new_email": "ana.nueva@example.com"
}
```

### Actualizar contraseña

`POST /api/user/update_password`

```json
{
  "email": "ana@example.com",
  "password": "ClaveSegura123",
  "new_password": "OtraClaveSegura456"
}
```

### Eliminar usuario

`DELETE /api/user/delete`

```json
{
  "email": "ana@example.com",
  "password": "ClaveSegura123"
}
```

### Listar usuarios

`GET /api/user/get`

La lista devuelve 10 usuarios por página. Laravel incluye enlaces e información de paginación en la respuesta.

## Validación y respuestas

Laravel valida los campos requeridos y sus formatos. Si la validación falla, la API responde con errores de validación. Las operaciones protegidas comprueban el email y la contraseña; si las credenciales no coinciden, responden con estado `401`.

El modelo oculta el hash de la contraseña en la serialización JSON. Aun así, evita devolver modelos completos en respuestas y limita los datos expuestos a los campos necesarios.

## Tecnologías

- Laravel 13
- PHP 8.3+
- SQLite
- Laravel Sanctum (instalado en el proyecto)
