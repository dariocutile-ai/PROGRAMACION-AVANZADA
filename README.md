<div align="center">

# InventoryPro

**Sistema de Gestión de Inventario**

[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Sanctum](https://img.shields.io/badge/Sanctum-4.3-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/docs/sanctum)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-11.x-3F87A6?logo=phpunit&logoColor=white)](https://phpunit.de)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

Sistema web y API RESTful para gestión de inventario con control de roles, movimientos de stock, reportes automáticos y autenticación por tokens.

</div>

---

## Tabla de Contenidos

- [Descripción](#-descripción)
- [Características](#-características)
- [Tecnologías](#-tecnologías-utilizadas)
- [Requisitos Previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [Configuración](#️-configuración)
- [Variables de Entorno](#-variables-de-entorno)
- [Migraciones y Seeders](#-migraciones-y-seeders)
- [Ejecución del Proyecto](#-ejecución-del-proyecto)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [API Endpoints](#-api-endpoints)
- [Autenticación](#-autenticación)
- [Roles y Permisos](#-roles-y-permisos)
- [Tests](#-tests)
- [Credenciales de Prueba](#-credenciales-de-prueba)
- [Solución de Problemas](#-solución-de-problemas)
- [Licencia](#-licencia)

---

## Descripción

**InventoryPro** es una aplicación full-stack construida con **Laravel 12** que ofrece:

- **API RESTful versionada** (`/api/v1/`) protegida con Laravel Sanctum
- **Interfaz web Blade** con dashboard de métricas en tiempo real
- **Control de acceso basado en roles** (Admin / Manager / Employee)
- **Gestión completa de inventario**: compras, ventas, reposiciones y mermas
- **Reportes automáticos** de stock bajo, más vendidos y movimientos
- **Arquitectura limpia**: Repository Pattern + Service Layer + Interfaces

## Tecnologías Utilizadas

### Backend

| Tecnología      | Versión | Uso                           |
| --------------- | ------- | ----------------------------- |
| PHP             | ^8.2    | Lenguaje base                 |
| Laravel         | ^12.0   | Framework principal           |
| Laravel Sanctum | ^4.3    | Autenticación API por tokens  |
| Laravel Tinker  | ^2.10.1 | REPL interactivo              |
| PHPUnit         | ^11.5   | Framework de testing          |
| Faker           | ^1.23   | Generación de datos de prueba |
| Mockery         | ^1.6    | Mocking en tests              |

### Frontend

| Tecnología      | Versión      | Uso                     |
| --------------- | ------------ | ----------------------- |
| Vite            | ^7.0         | Bundler de assets       |
| Tailwind CSS    | ^4.0         | Estilos utilitarios     |
| Bootstrap       | 5.3.3 (CDN)  | Layout y componentes UI |
| Bootstrap Icons | 1.11.3 (CDN) | Iconografía             |
| Axios           | ^1.11        | Cliente HTTP JS         |

### Base de Datos

| Entorno    | Motor                              |
| ---------- | ---------------------------------- |
| Desarrollo | MySQL 8+ / PostgreSQL 14+ / SQLite |
| Testing    | SQLite en memoria (`:memory:`)     |

---

## Requisitos Previos

Asegúrate de tener instalado lo siguiente antes de comenzar:

- **PHP** >= 8.2 con extensiones: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- **Composer** >= 2.x → [getcomposer.org](https://getcomposer.org)
- **Node.js** >= 18.x y **npm** >= 9.x → [nodejs.org](https://nodejs.org)
- **MySQL** >= 8.0 **o** **PostgreSQL** >= 14 **o** **SQLite** >= 3
- **Git** → [git-scm.com](https://git-scm.com)

### Verificar requisitos

```bash
php -v          # PHP 8.2+
composer -V     # Composer 2.x
node -v         # Node 18+
npm -v          # npm 9+
mysql --version # MySQL 8+ (si usas MySQL)
```

---

## Instalación

### Opción A — Instalación automática (un solo comando)

```bash
composer run setup
```

Este comando ejecuta en secuencia (definido en `composer.json` → `scripts.setup`):

1. `composer install`
2. Copia `.env.example` a `.env` si no existe
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install`
6. `npm run build`

### Opción B — Instalación manual paso a paso

#### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO> inventorypro
cd inventorypro
```

#### 2. Instalar dependencias PHP

```bash
composer install
```

#### 3. Instalar dependencias Node.js

```bash
npm install
```

#### 4. Copiar el archivo de entorno

```bash
cp .env.example .env
```

#### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

---

## ⚙️ Configuración

### Base de datos

#### MySQL (recomendado para producción)

1. Crear la base de datos:

```sql
CREATE DATABASE inventorypro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Editar `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventorypro
DB_USERNAME=root
DB_PASSWORD=tu_password
```

#### SQLite (desarrollo rápido)

```bash
touch database/database.sqlite
```

Editar `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/absoluta/al/proyecto/database/database.sqlite
```

#### PostgreSQL

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventorypro
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

---

## Variables de Entorno

Todas las variables disponibles están documentadas en `.env.example`. Las más importantes:

```env
# ─── Aplicación ───────────────────────────────────────
APP_NAME=InventoryPro
APP_ENV=local           # local | staging | production
APP_KEY=                # Generada con: php artisan key:generate
APP_DEBUG=true          # false en producción
APP_URL=http://localhost:8000
APP_LOCALE=es

# ─── Base de Datos ────────────────────────────────────
DB_CONNECTION=mysql     # mysql | pgsql | sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventorypro
DB_USERNAME=root
DB_PASSWORD=

# ─── Sanctum (API Tokens) ─────────────────────────────
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1,127.0.0.1:8000
SANCTUM_TOKEN_PREFIX=

# ─── CORS ─────────────────────────────────────────────
CORS_ENABLED=true
CORS_ALLOWED_ORIGINS=http://localhost:3000
CORS_ALLOWED_METHODS=GET,POST,PUT,PATCH,DELETE,OPTIONS
CORS_ALLOWED_HEADERS=Content-Type,Authorization,X-Requested-With,Accept,Origin
CORS_SUPPORTS_CREDENTIALS=false

# ─── Cache / Queue / Session ──────────────────────────
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

## Migraciones y Seeders

### Ejecutar migraciones

```bash
php artisan migrate
```

### Ejecutar migraciones con datos de prueba

```bash
php artisan migrate --seed
```

### Ejecutar solo los seeders (sin migrar)

```bash
php artisan db:seed
```

### Restablecer y re-ejecutar todo (⚠️ borra los datos)

```bash
php artisan migrate:fresh --seed
```

### Qué crean los seeders

El `DatabaseSeeder` crea los siguientes registros de prueba:

| Tabla                 | Registros | Detalle                               |
| --------------------- | :-------: | ------------------------------------- |
| `users`               |     3     | Admin, Manager, Employee              |
| `roles`               |     3     | Admin, Manager, Employee              |
| `categories`          |    10     | Categorías únicas aleatorias          |
| `suppliers`           |    10     | Proveedores con datos de contacto     |
| `products`            |    25     | Productos con SKU, precios y stock    |
| `inventory_movements` |    60     | Compras, ventas, reposiciones, mermas |
| `comments`            |    40     | Comentarios polimórficos              |
| `reports`             |    10     | Reportes de inventario                |
| **Total**             | **~161**  |                                       |

---

## Ejecución del Proyecto

### Modo desarrollo completo (recomendado)

Levanta el servidor PHP, el watcher de colas, el logger Pail y Vite en paralelo:

```bash
composer run dev
```

> Este comando usa `concurrently` (definido en `composer.json` → `scripts.dev`) y requiere que `npm install` se haya ejecutado previamente.

### Servidor PHP únicamente

```bash
php artisan serve
```

La aplicación estará disponible en: **http://localhost:8000**

### Compilar assets frontend

```bash
# Modo producción (una sola vez)
npm run build

# Modo desarrollo con hot-reload
npm run dev
```

### Health check

```
GET http://localhost:8000/up
GET http://localhost:8000/api/v1/health
```

---

## Estructura del Proyecto

```
InventoryPro/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/V1/           # Controladores REST versionados
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── ProductsController.php
│   │   │   │   ├── CategoriesController.php
│   │   │   │   ├── SuppliersController.php
│   │   │   │   ├── InventoryMovementsController.php
│   │   │   │   ├── CommentsController.php
│   │   │   │   └── ReportsController.php
│   │   │   └── Web/              # Controladores Blade
│   │   │       ├── DashboardController.php
│   │   │       ├── ProductController.php
│   │   │       ├── CategoryController.php
│   │   │       ├── SupplierController.php
│   │   │       ├── InventoryMovementController.php
│   │   │       ├── ReportController.php
│   │   │       ├── UserController.php
│   │   │       └── RoleController.php
│   │   ├── Middleware/
│   │   │   ├── CheckRoleMiddleware.php  # RBAC personalizado
│   │   │   └── Cors.php
│   │   ├── Requests/             # Form Requests (validaciones)
│   │   │   ├── Auth/
│   │   │   ├── Products/
│   │   │   ├── Categories/
│   │   │   ├── Suppliers/
│   │   │   ├── Inventory/
│   │   │   ├── Comments/
│   │   │   ├── Roles/
│   │   │   └── Users/
│   │   └── Resources/            # API Resources (transformadores JSON)
│   │       ├── Products/
│   │       ├── Categories/
│   │       ├── Suppliers/
│   │       ├── Comments/
│   │       ├── Inventory/
│   │       └── Reports/
│   ├── Interfaces/               # Contratos (DI)
│   ├── Models/                   # Modelos Eloquent
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Supplier.php
│   │   ├── InventoryMovement.php
│   │   ├── Comment.php
│   │   └── Report.php
│   ├── Policies/                 # Autorización por modelo
│   ├── Providers/
│   │   └── AppServiceProvider.php  # DI bindings + Gate policies
│   ├── Repositories/             # Capa de acceso a datos
│   └── Services/                 # Lógica de negocio
│       ├── Auth/
│       ├── Products/
│       ├── Categories/
│       ├── Suppliers/
│       ├── Inventory/
│       ├── Comments/
│       └── Reports/
├── bootstrap/
│   └── app.php                   # Registro de middleware y excepciones
├── config/
│   ├── auth.php
│   ├── cors.php
│   ├── sanctum.php
│   └── ...
├── database/
│   ├── factories/                # Factories para datos de prueba
│   ├── migrations/               # 12 migraciones
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── layouts/app.blade.php
│       ├── auth/
│       ├── dashboard/
│       ├── products/
│       ├── categories/
│       ├── suppliers/
│       ├── inventory/
│       ├── reports/
│       ├── users/
│       └── roles/
├── routes/
│   ├── api.php                   # Rutas /api/v1/*
│   ├── web.php                   # Rutas web Blade
│   └── console.php
├── tests/
│   ├── Feature/
│   │   ├── InventoryProApiAuthTest.php
│   │   └── InventoryProApiRBACAndModulesTest.php
│   └── Unit/
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

---

## API Endpoints

Todas las rutas API tienen el prefijo `/api/v1/`. Los endpoints protegidos requieren el header:

```
Authorization: Bearer {token}
```

### Autenticación

| Método | Endpoint                | Acceso  | Descripción             |
| ------ | ----------------------- | ------- | ----------------------- |
| `POST` | `/api/v1/auth/register` | Público | Registrar nuevo usuario |
| `POST` | `/api/v1/auth/login`    | Público | Obtener token de acceso |
| `POST` | `/api/v1/auth/logout`   | Auth    | Revocar token actual    |
| `GET`  | `/api/v1/health`        | Público | Estado del servidor     |

### Productos

| Método      | Endpoint                | Roles permitidos         |
| ----------- | ----------------------- | ------------------------ |
| `GET`       | `/api/v1/products`      | Employee, Manager, Admin |
| `GET`       | `/api/v1/products/{id}` | Employee, Manager, Admin |
| `POST`      | `/api/v1/products`      | Manager, Admin           |
| `PUT/PATCH` | `/api/v1/products/{id}` | Manager, Admin           |
| `DELETE`    | `/api/v1/products/{id}` | Admin                    |

### Categorías

| Método      | Endpoint                  | Roles permitidos         |
| ----------- | ------------------------- | ------------------------ |
| `GET`       | `/api/v1/categories`      | Employee, Manager, Admin |
| `GET`       | `/api/v1/categories/{id}` | Employee, Manager, Admin |
| `POST`      | `/api/v1/categories`      | Admin                    |
| `PUT/PATCH` | `/api/v1/categories/{id}` | Admin                    |
| `DELETE`    | `/api/v1/categories/{id}` | Admin                    |

### Proveedores

| Método                  | Endpoint                 | Roles permitidos         |
| ----------------------- | ------------------------ | ------------------------ |
| `GET`                   | `/api/v1/suppliers`      | Employee, Manager, Admin |
| `GET`                   | `/api/v1/suppliers/{id}` | Employee, Manager, Admin |
| `POST/PUT/PATCH/DELETE` | `/api/v1/suppliers/...`  | Admin                    |

### Inventario

| Método | Endpoint                      | Roles permitidos | Descripción                                        |
| ------ | ----------------------------- | ---------------- | -------------------------------------------------- |
| `POST` | `/api/v1/inventory/movements` | Manager, Admin   | Registrar movimiento (purchase/restock/sale/waste) |

**Body requerido:**

```json
{
    "product_id": 1,
    "type": "purchase",
    "quantity": 10,
    "unit_cost": 5.5,
    "note": "Compra mensual"
}
```

### Comentarios (polimórficos)

| Método | Endpoint                       | Ejemplo                  |
| ------ | ------------------------------ | ------------------------ |
| `GET`  | `/{commentable}/{id}/comments` | `/products/1/comments`   |
| `POST` | `/{commentable}/{id}/comments` | `/categories/2/comments` |

Valores válidos para `{commentable}`: `products`, `categories`, `suppliers`

### Reportes

| Método | Endpoint                            | Descripción                         |
| ------ | ----------------------------------- | ----------------------------------- |
| `GET`  | `/api/v1/reports/low-stock`         | Productos con stock ≤ reorder_level |
| `GET`  | `/api/v1/reports/most-sold`         | Top 10 productos más vendidos       |
| `GET`  | `/api/v1/reports/recent-movements`  | Últimos 20 movimientos              |
| `GET`  | `/api/v1/reports/inventory-summary` | Resumen general de inventario       |
| `GET`  | `/api/v1/reports/by-category`       | Stock agrupado por categoría        |

---

## Autenticación

InventoryPro usa **Laravel Sanctum** con tokens de tipo Bearer.

### Flujo de autenticación

```bash
# 1. Registrar usuario
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Juan","email":"juan@test.com","password":"password","password_confirmation":"password"}'

# Respuesta:
# { "message": "...", "token": "1|abc123..." }

# 2. Usar el token en solicitudes protegidas
curl http://localhost:8000/api/v1/products \
  -H "Authorization: Bearer 1|abc123..."

# 3. Cerrar sesión (revoca el token)
curl -X POST http://localhost:8000/api/v1/auth/logout \
  -H "Authorization: Bearer 1|abc123..."
```

---

## Roles y Permisos

El sistema implementa RBAC con tres roles predefinidos:

| Rol          | Descripción       | Permisos                                                               |
| ------------ | ----------------- | ---------------------------------------------------------------------- |
| **Admin**    | Acceso total      | CRUD completo en todos los módulos. Gestión de usuarios y roles.       |
| **Manager**  | Gestión operativa | Lectura + escritura en productos. Registrar movimientos de inventario. |
| **Employee** | Solo lectura      | Ver productos, categorías, proveedores y reportes.                     |

El control se aplica en dos capas:

1. **Middleware** `checkRole:Admin,Manager` en las rutas
2. **Policies** de Laravel registradas en `AppServiceProvider`

---

## Tests

El proyecto usa **PHPUnit 11** con dos suites de tests. El entorno de testing usa **SQLite en memoria** (configurado en `phpunit.xml`), sin afectar la base de datos de desarrollo.

### Ejecutar todos los tests

```bash
php artisan test
```

### Ejecutar con el script de Composer (limpia config antes)

```bash
composer run test
```

> Este script ejecuta `php artisan config:clear` antes de los tests, lo que evita conflictos de caché de configuración.

### Ejecutar una suite específica

```bash
# Solo tests unitarios
php artisan test --testsuite=Unit

# Solo tests de integración/feature
php artisan test --testsuite=Feature
```

### Ejecutar un archivo de test específico

```bash
php artisan test tests/Feature/InventoryProApiAuthTest.php
php artisan test tests/Feature/InventoryProApiRBACAndModulesTest.php
```

### Ejecutar con reporte de cobertura (requiere Xdebug o PCOV)

```bash
php artisan test --coverage
```

### Tests disponibles

#### `tests/Feature/InventoryProApiAuthTest.php`

| Test                                    | Descripción                                         |
| --------------------------------------- | --------------------------------------------------- |
| `test_register_returns_201_and_token`   | El registro devuelve status 201 y un token          |
| `test_login_returns_token`              | El login con credenciales válidas devuelve un token |
| `test_logout_requires_auth`             | El logout sin token devuelve 401                    |
| `test_logout_invalidates_session_token` | El logout revoca el token activo                    |

#### `tests/Feature/InventoryProApiRBACAndModulesTest.php`

| Test                                              | Descripción                                          |
| ------------------------------------------------- | ---------------------------------------------------- |
| `test_reports_requires_auth_and_role`             | Los reportes requieren auth; Employee puede acceder  |
| `test_inventory_movements_requires_auth_and_role` | Employee recibe 403; Manager puede crear movimientos |

### Salida esperada

```
PASS  Tests\Feature\InventoryProApiAuthTest
✓ register returns 201 and token
✓ login returns token
✓ logout requires auth
✓ logout invalidates session token

PASS  Tests\Feature\InventoryProApiRBACAndModulesTest
✓ reports requires auth and role
✓ inventory movements requires auth and role

Tests:    6 passed
Duration: x.xxs
```

---

## Credenciales de Prueba

Después de ejecutar `php artisan migrate --seed` o `php artisan db:seed`:

| Email                  | Contraseña | Rol      |
| ---------------------- | ---------- | -------- |
| `test@example.com`     | `password` | Admin    |
| `manager@example.com`  | `password` | Manager  |
| `employee@example.com` | `password` | Employee |

### Login rápido (web)

Navega a `http://localhost:8000/login` e ingresa con cualquiera de las credenciales anteriores.

### Login vía API

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

---

## 🔧 Solución de Problemas

### `php artisan key:generate` — Key ya existe

```bash
php artisan key:generate --force
```

### Error de permisos en `storage/` o `bootstrap/cache/`

```bash
chmod -R 775 storage bootstrap/cache
```

### `Class ... not found` tras instalar un paquete

```bash
composer dump-autoload
```

### Los assets no cargan (CSS/JS en blanco)

```bash
npm run build
# o en desarrollo:
npm run dev
```

### Error de conexión a base de datos

Verifica que el servicio MySQL/PostgreSQL esté activo y que los valores en `.env` sean correctos:

```bash
php artisan db:show   # muestra info de conexión actual
```

Para SQLite, asegúrate de que el archivo existe:

```bash
touch database/database.sqlite
```

### Tests fallan con "no such table"

Los tests usan SQLite en memoria. Si fallan, ejecuta:

```bash
php artisan config:clear
php artisan test
```

### Puerto 8000 ocupado

```bash
php artisan serve --port=8001
```

### Ver todas las rutas registradas

```bash
php artisan route:list
php artisan route:list --path=api   # solo rutas API
```

---

## Comandos de Referencia Rápida

```bash
# ─── Instalación ──────────────────────────────────────
composer run setup              # instalación completa automática

# ─── Desarrollo ───────────────────────────────────────
composer run dev                # servidor + queue + logs + vite (todo junto)
php artisan serve               # solo servidor PHP en :8000
npm run dev                     # solo watcher Vite

# ─── Base de datos ────────────────────────────────────
php artisan migrate             # ejecutar migraciones pendientes
php artisan migrate --seed      # migrar + sembrar datos de prueba
php artisan db:seed             # solo seeders
php artisan migrate:fresh --seed  # reset completo + seeders

# ─── Frontend ─────────────────────────────────────────
npm run build                   # compilar assets para producción
npm run dev                     # compilar assets con hot-reload

# ─── Testing ──────────────────────────────────────────
composer run test               # limpiar config + ejecutar tests
php artisan test                # ejecutar todos los tests
php artisan test --testsuite=Feature  # solo Feature tests
php artisan test --testsuite=Unit     # solo Unit tests
php artisan test --coverage           # con reporte de cobertura

# ─── Utilidades ───────────────────────────────────────
php artisan key:generate        # generar APP_KEY
php artisan route:list          # listar todas las rutas
php artisan config:clear        # limpiar caché de configuración
php artisan cache:clear         # limpiar caché de aplicación
php artisan view:clear          # limpiar vistas compiladas
php artisan tinker              # consola interactiva REPL
```

---

## Licencia

Este proyecto está licenciado bajo la [MIT License](https://opensource.org/licenses/MIT).

---

<div align="center">
 <a href="https://laravel.com">Laravel 12</a>
</div>
