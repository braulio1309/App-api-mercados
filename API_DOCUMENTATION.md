# API Mercados — Documentación de Endpoints

Base URL: `http://localhost/api`

Autenticación: **Bearer Token** (Laravel Sanctum)  
Formato de respuesta: **JSON**

---

## Autenticación (`/api/auth`)

### `POST /api/auth/login`

Inicia sesión para un usuario, repartidor o vendedor.

**Request Body**

| Campo      | Tipo   | Requerido | Descripción                                    |
|------------|--------|-----------|------------------------------------------------|
| `email`    | string | ✅        | Correo electrónico registrado                  |
| `password` | string | ✅        | Contraseña                                     |
| `tipo`     | string | ✅        | Tipo de entidad: `usuario`, `repartidor`, `vendedor` |

**Ejemplo de Request**
```json
{
  "email": "juan@example.com",
  "password": "secreto123",
  "tipo": "usuario"
}
```

**Respuesta exitosa (200)**
```json
{
  "message": "Inicio de sesión exitoso.",
  "tipo": "usuario",
  "token": "1|abc123...",
  "data": {
    "id": 1,
    "nombres": "Juan",
    "apellidos": "Pérez",
    "email": "juan@example.com",
    ...
  }
}
```

**Errores posibles**
- `422 Unprocessable Entity` — Credenciales incorrectas o campos faltantes.

---

### `POST /api/auth/logout`

Revoca el token actual (requiere autenticación).

**Headers:** `Authorization: Bearer {token}`

**Respuesta exitosa (200)**
```json
{
  "message": "Sesión cerrada exitosamente."
}
```

---

### `GET /api/auth/me`

Retorna los datos de la entidad autenticada (requiere autenticación).

**Headers:** `Authorization: Bearer {token}`

**Respuesta exitosa (200)**
```json
{
  "data": { ... }
}
```

---

## Usuarios (`/api/usuarios`)

### `GET /api/usuarios`

Lista todos los usuarios (paginado).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombres": "Juan",
      "apellidos": "Pérez",
      "ciudad": "Lima",
      "distrito": "Miraflores",
      "direccion": "Av. Larco 123",
      "latitud": -12.1219,
      "longitud": -77.0284,
      "celular": "987654321",
      "email": "juan@example.com",
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/usuarios`

Crea un nuevo usuario.

**Request Body**

| Campo              | Tipo    | Requerido | Descripción                          |
|--------------------|---------|-----------|--------------------------------------|
| `nombres`          | string  | ✅        | Nombres del usuario                  |
| `apellidos`        | string  | ✅        | Apellidos del usuario                |
| `ciudad`           | string  | ✅        | Ciudad                               |
| `distrito`         | string  | ✅        | Distrito                             |
| `direccion`        | string  | ✅        | Dirección ingresada manualmente      |
| `latitud`          | decimal | ❌        | Latitud confirmada en el mapa        |
| `longitud`         | decimal | ❌        | Longitud confirmada en el mapa       |
| `celular`          | string  | ✅        | Número de celular                    |
| `email`            | string  | ✅        | Correo electrónico (único)           |
| `password`         | string  | ✅        | Contraseña (mín. 8 caracteres)       |
| `password_confirmation` | string | ✅  | Confirmación de contraseña           |

**Respuesta exitosa (201)**
```json
{
  "message": "Usuario creado exitosamente.",
  "data": { ... }
}
```

**Errores posibles**
- `422 Unprocessable Entity` — Validación fallida.

---

### `GET /api/usuarios/{id}`

Obtiene un usuario por su ID.

**Respuesta exitosa (200)**
```json
{
  "data": { ... }
}
```

**Errores posibles**
- `404 Not Found` — Usuario no encontrado.

---

### `PUT /api/usuarios/{id}`

Actualiza un usuario. Todos los campos son opcionales (PATCH-like).

**Request Body** — Igual que `POST`, pero todos los campos son opcionales.

**Respuesta exitosa (200)**
```json
{
  "message": "Usuario actualizado exitosamente.",
  "data": { ... }
}
```

---

### `DELETE /api/usuarios/{id}`

Elimina un usuario.

**Respuesta exitosa (200)**
```json
{
  "message": "Usuario eliminado exitosamente."
}
```

---

## Repartidores (`/api/repartidores`)

### `GET /api/repartidores`

Lista todos los repartidores (paginado).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombres": "Carlos",
      "apellidos": "Gómez",
      "ciudad": "Lima",
      "dni_carnet": "12345678",
      "celular": "999888777",
      "email": "carlos@example.com",
      "placa_vehiculo": "ABC-123",
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  ...
}
```

---

### `POST /api/repartidores`

Crea un nuevo repartidor.

**Request Body**

| Campo              | Tipo   | Requerido | Descripción                              |
|--------------------|--------|-----------|------------------------------------------|
| `nombres`          | string | ✅        | Nombres del repartidor                   |
| `apellidos`        | string | ✅        | Apellidos del repartidor                 |
| `ciudad`           | string | ✅        | Ciudad                                   |
| `dni_carnet`       | string | ✅        | DNI o carné de extranjería (único)       |
| `celular`          | string | ✅        | Número de celular                        |
| `email`            | string | ✅        | Correo electrónico (único)               |
| `placa_vehiculo`   | string | ❌        | Placa del vehículo (si aplica)           |
| `password`         | string | ✅        | Contraseña (mín. 8 caracteres)           |
| `password_confirmation` | string | ✅ | Confirmación de contraseña              |

**Respuesta exitosa (201)**
```json
{
  "message": "Repartidor creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/repartidores/{id}`

Obtiene un repartidor por su ID.

---

### `PUT /api/repartidores/{id}`

Actualiza un repartidor. Todos los campos son opcionales.

---

### `DELETE /api/repartidores/{id}`

Elimina un repartidor.

---

## Vendedores (`/api/vendedores`)

### `GET /api/vendedores`

Lista todos los vendedores con sus mercados asignados (paginado).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombres": "María",
      "apellidos": "Torres",
      "celular": "977666555",
      "dni_carnet": "87654321",
      "email": "maria@example.com",
      "mercados": [
        {
          "id": 1,
          "nombre_establecimiento": "Mercado Central",
          "numero_local": "A-12",
          "numero_puesto": "15",
          "dni_vendedor": "87654321"
        }
      ],
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  ...
}
```

---

### `POST /api/vendedores`

Crea un nuevo vendedor.

**Request Body**

| Campo              | Tipo   | Requerido | Descripción                        |
|--------------------|--------|-----------|------------------------------------|
| `nombres`          | string | ✅        | Nombres del vendedor               |
| `apellidos`        | string | ✅        | Apellidos del vendedor             |
| `celular`          | string | ✅        | Número de celular                  |
| `dni_carnet`       | string | ✅        | DNI o carné de extranjería (único) |
| `email`            | string | ✅        | Correo electrónico (único)         |
| `password`         | string | ✅        | Contraseña (mín. 8 caracteres)     |
| `password_confirmation` | string | ✅ | Confirmación de contraseña        |

**Respuesta exitosa (201)**
```json
{
  "message": "Vendedor creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/vendedores/{id}`

Obtiene un vendedor con sus mercados asignados.

---

### `PUT /api/vendedores/{id}`

Actualiza un vendedor. Todos los campos son opcionales.

---

### `DELETE /api/vendedores/{id}`

Elimina un vendedor.

---

### `POST /api/vendedores/{id}/mercados`

Asigna un mercado a un vendedor (con número de puesto).

**Request Body**

| Campo          | Tipo    | Requerido | Descripción                              |
|----------------|---------|-----------|------------------------------------------|
| `mercado_id`   | integer | ✅        | ID del mercado a asignar                 |
| `numero_puesto`| string  | ✅        | Número de puesto en el mercado           |
| `dni_vendedor` | string  | ❌        | DNI del vendedor en ese mercado          |

**Respuesta exitosa (200)**
```json
{
  "message": "Mercado asignado al vendedor exitosamente.",
  "data": { ... }
}
```

---

### `DELETE /api/vendedores/{id}/mercados/{mercado_id}`

Desasigna un mercado de un vendedor.

**Respuesta exitosa (200)**
```json
{
  "message": "Mercado desasignado del vendedor exitosamente."
}
```

---

## Mercados (`/api/mercados`)

### `GET /api/mercados`

Lista todos los mercados con sus vendedores (paginado).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombre_establecimiento": "Mercado Central de Lima",
      "numero_local": "A-12",
      "img_puesto": "https://...",
      "horario_atencion": [
        { "dia": "Lunes", "apertura": "08:00", "cierre": "18:00" },
        { "dia": "Martes", "apertura": "08:00", "cierre": "18:00" }
      ],
      "nombre_dueno": "Pedro Ramírez",
      "ruc": "20123456789",
      "vendedores": [ ... ],
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  ...
}
```

---

### `POST /api/mercados`

Crea un nuevo mercado.

**Request Body**

| Campo                   | Tipo   | Requerido | Descripción                                          |
|-------------------------|--------|-----------|------------------------------------------------------|
| `nombre_establecimiento`| string | ✅        | Nombre del mercado / establecimiento                 |
| `numero_local`          | string | ✅        | Número de local                                      |
| `img_puesto`            | string | ❌        | URL de imagen referencial del puesto                 |
| `horario_atencion`      | array  | ❌        | Array de horarios con `dia`, `apertura`, `cierre`    |
| `nombre_dueno`          | string | ✅        | Nombre del dueño del establecimiento                 |
| `ruc`                   | string | ❌        | RUC del establecimiento (máx. 11 caracteres)         |

**Ejemplo de `horario_atencion`**
```json
[
  { "dia": "Lunes",   "apertura": "08:00", "cierre": "18:00" },
  { "dia": "Martes",  "apertura": "08:00", "cierre": "18:00" },
  { "dia": "Sábado",  "apertura": "07:00", "cierre": "14:00" }
]
```

**Respuesta exitosa (201)**
```json
{
  "message": "Mercado creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/mercados/{id}`

Obtiene un mercado con sus vendedores.

---

### `PUT /api/mercados/{id}`

Actualiza un mercado. Todos los campos son opcionales.

---

### `DELETE /api/mercados/{id}`

Elimina un mercado.

---

## Errores Comunes

| Código | Descripción                                      |
|--------|--------------------------------------------------|
| `401`  | No autenticado — Token faltante o inválido       |
| `422`  | Error de validación — Se retorna `errors` con detalle |
| `404`  | Recurso no encontrado                            |
| `500`  | Error interno del servidor                       |

**Estructura de error de validación (422)**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

---

## Configuración del entorno

Copia `.env.example` a `.env` y configura:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app_mercados
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### Comandos de instalación

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```
