# API Mercados — Documentación de Endpoints

Base URL: `http://localhost/api`

Autenticación: ******** (Laravel Sanctum)  
Formato de respuesta: **JSON**

---

## Tabla de Contenidos

1. [Autenticación](#autenticación-apiauth)
2. [Usuarios](#usuarios-apiusuarios)
3. [Repartidores](#repartidores-apirepartidores)
4. [Reseñas de Repartidores](#reseñas-de-repartidores-apiresenas-repartidor)
5. [Vendedores](#vendedores-apivendedores)
6. [Mercados](#mercados-apimercados)
7. [Categorías](#categorías-apicategorias)
8. [Estados de Pedido](#estados-de-pedido-apiestado-pedidos)
9. [Productos](#productos-apiproductos)
10. [Pedidos](#pedidos-apipedidos)
11. [Pagos](#pagos-apipagos)
12. [Errores Comunes](#errores-comunes)
13. [Configuración del Entorno](#configuración-del-entorno)

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
    "email": "juan@example.com"
  }
}
```

**Errores posibles**
- `422 Unprocessable Entity` — Credenciales incorrectas o campos faltantes.

---

### `POST /api/auth/logout`

Revoca el token actual (requiere autenticación).

**Headers:** `Authorization: ******

**Respuesta exitosa (200)**
```json
{
  "message": "Sesión cerrada exitosamente."
}
```

---

### `GET /api/auth/me`

Retorna los datos de la entidad autenticada (requiere autenticación).

**Headers:** `Authorization: ******

**Respuesta exitosa (200)**
```json
{
  "data": { ... }
}
```

---

## Usuarios (`/api/usuarios`)

### `GET /api/usuarios`

Lista todos los usuarios (paginado, 15 por página).

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

| Campo                   | Tipo    | Requerido | Descripción                          |
|-------------------------|---------|-----------|--------------------------------------|
| `nombres`               | string  | ✅        | Nombres del usuario                  |
| `apellidos`             | string  | ✅        | Apellidos del usuario                |
| `ciudad`                | string  | ✅        | Ciudad                               |
| `distrito`              | string  | ✅        | Distrito                             |
| `direccion`             | string  | ✅        | Dirección                            |
| `latitud`               | decimal | ❌        | Latitud (entre -90 y 90)             |
| `longitud`              | decimal | ❌        | Longitud (entre -180 y 180)          |
| `celular`               | string  | ✅        | Número de celular                    |
| `email`                 | string  | ✅        | Correo electrónico (único)           |
| `password`              | string  | ✅        | Contraseña (mín. 8 caracteres)       |
| `password_confirmation` | string  | ✅        | Confirmación de contraseña           |

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

Actualiza un usuario. Todos los campos son opcionales.

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

Lista todos los repartidores (paginado, 15 por página).

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
      "promedio_calificacion": 4.75,
      "total_resenas": 8,
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

> `promedio_calificacion` es `null` si el repartidor aún no tiene reseñas.

---

### `POST /api/repartidores`

Crea un nuevo repartidor.

**Request Body**

| Campo                   | Tipo   | Requerido | Descripción                              |
|-------------------------|--------|-----------|------------------------------------------|
| `nombres`               | string | ✅        | Nombres del repartidor                   |
| `apellidos`             | string | ✅        | Apellidos del repartidor                 |
| `ciudad`                | string | ✅        | Ciudad                                   |
| `dni_carnet`            | string | ✅        | DNI o carné de extranjería (único)       |
| `celular`               | string | ✅        | Número de celular                        |
| `email`                 | string | ✅        | Correo electrónico (único)               |
| `placa_vehiculo`        | string | ❌        | Placa del vehículo (si aplica)           |
| `password`              | string | ✅        | Contraseña (mín. 8 caracteres)           |
| `password_confirmation` | string | ✅        | Confirmación de contraseña               |

**Respuesta exitosa (201)**
```json
{
  "message": "Repartidor creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/repartidores/{id}`

Obtiene un repartidor por su ID, incluyendo su promedio de calificación y número de reseñas.

---

### `PUT /api/repartidores/{id}`

Actualiza un repartidor. Todos los campos son opcionales.

---

### `DELETE /api/repartidores/{id}`

Elimina un repartidor (y en cascada sus reseñas asociadas).

---

### `GET /api/repartidores/{id}/resenas`

Lista todas las reseñas de un repartidor específico (paginado, 15 por página, ordenadas de más recientes a más antiguas).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "usuario": { "id": 3, "nombres": "Ana", "apellidos": "López" },
      "calificacion": 5,
      "comentario": "Excelente servicio, muy puntual.",
      "creado_en": "2026-06-01T12:00:00.000000Z",
      "actualizado_en": "2026-06-01T12:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

## Reseñas de Repartidores (`/api/resenas-repartidor`)

Módulo para gestionar el historial de calificaciones (del 1 al 5) que los usuarios asignan a los repartidores. Todas las reseñas quedan persistidas para consulta histórica.

### `GET /api/resenas-repartidor`

Lista todas las reseñas (paginado, 15 por página, ordenadas de más recientes a más antiguas).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "repartidor": {
        "id": 2,
        "nombres": "Carlos",
        "apellidos": "Gómez",
        "promedio_calificacion": 4.75,
        "total_resenas": 8
      },
      "usuario": {
        "id": 3,
        "nombres": "Ana",
        "apellidos": "López"
      },
      "calificacion": 5,
      "comentario": "Entrega rápida y trato amable.",
      "creado_en": "2026-06-01T12:00:00.000000Z",
      "actualizado_en": "2026-06-01T12:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/resenas-repartidor`

Crea una nueva reseña para un repartidor.

**Request Body**

| Campo           | Tipo    | Requerido | Descripción                                        |
|-----------------|---------|-----------|-----------------------------------------------------|
| `repartidor_id` | integer | ✅        | ID del repartidor a calificar                       |
| `usuario_id`    | integer | ✅        | ID del usuario que realiza la calificación          |
| `calificacion`  | integer | ✅        | Puntuación del 1 al 5                               |
| `comentario`    | string  | ❌        | Comentario adicional (máx. 1000 caracteres)         |

**Ejemplo de Request**
```json
{
  "repartidor_id": 2,
  "usuario_id": 3,
  "calificacion": 5,
  "comentario": "Entrega rápida y trato amable."
}
```

**Respuesta exitosa (201)**
```json
{
  "message": "Reseña creada exitosamente.",
  "data": {
    "id": 1,
    "repartidor": { ... },
    "usuario": { ... },
    "calificacion": 5,
    "comentario": "Entrega rápida y trato amable.",
    "creado_en": "2026-06-01T12:00:00.000000Z",
    "actualizado_en": "2026-06-01T12:00:00.000000Z"
  }
}
```

**Errores posibles**
- `422 Unprocessable Entity` — Validación fallida (p.e., calificación fuera del rango 1-5).

---

### `GET /api/resenas-repartidor/{id}`

Obtiene una reseña específica por su ID.

**Respuesta exitosa (200)**
```json
{
  "data": {
    "id": 1,
    "repartidor": { ... },
    "usuario": { ... },
    "calificacion": 4,
    "comentario": "Buen servicio.",
    "creado_en": "2026-06-01T12:00:00.000000Z",
    "actualizado_en": "2026-06-01T12:00:00.000000Z"
  }
}
```

---

### `PUT /api/resenas-repartidor/{id}`

Actualiza una reseña existente. Ambos campos son opcionales.

**Request Body**

| Campo          | Tipo    | Requerido | Descripción                  |
|----------------|---------|-----------|------------------------------|
| `calificacion` | integer | ❌        | Nueva puntuación del 1 al 5  |
| `comentario`   | string  | ❌        | Nuevo comentario (máx. 1000) |

**Respuesta exitosa (200)**
```json
{
  "message": "Reseña actualizada exitosamente.",
  "data": { ... }
}
```

---

### `DELETE /api/resenas-repartidor/{id}`

Elimina una reseña.

**Respuesta exitosa (200)**
```json
{
  "message": "Reseña eliminada exitosamente."
}
```

---

## Vendedores (`/api/vendedores`)

### `GET /api/vendedores`

Lista todos los vendedores con sus mercados asignados (paginado, 15 por página).

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
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/vendedores`

Crea un nuevo vendedor.

**Request Body**

| Campo                   | Tipo   | Requerido | Descripción                        |
|-------------------------|--------|-----------|------------------------------------|
| `nombres`               | string | ✅        | Nombres del vendedor               |
| `apellidos`             | string | ✅        | Apellidos del vendedor             |
| `celular`               | string | ✅        | Número de celular                  |
| `dni_carnet`            | string | ✅        | DNI o carné de extranjería (único) |
| `email`                 | string | ✅        | Correo electrónico (único)         |
| `password`              | string | ✅        | Contraseña (mín. 8 caracteres)     |
| `password_confirmation` | string | ✅        | Confirmación de contraseña         |

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

Asigna un mercado a un vendedor.

**Request Body**

| Campo           | Tipo    | Requerido | Descripción                              |
|-----------------|---------|-----------|------------------------------------------|
| `mercado_id`    | integer | ✅        | ID del mercado a asignar                 |
| `numero_puesto` | string  | ✅        | Número de puesto en el mercado           |
| `dni_vendedor`  | string  | ❌        | DNI del vendedor en ese mercado          |

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

Lista todos los mercados con sus vendedores (paginado, 15 por página).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombre_establecimiento": "Mercado Central de Lima",
      "numero_local": "A-12",
      "img_puesto": "https://example.com/img.jpg",
      "horario_atencion": [
        { "dia": "Lunes",   "apertura": "08:00", "cierre": "18:00" },
        { "dia": "Martes",  "apertura": "08:00", "cierre": "18:00" },
        { "dia": "Sábado",  "apertura": "07:00", "cierre": "14:00" }
      ],
      "nombre_dueno": "Pedro Ramírez",
      "ruc": "20123456789",
      "vendedores": [ ... ],
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/mercados`

Crea un nuevo mercado.

**Request Body**

| Campo                    | Tipo   | Requerido | Descripción                                        |
|--------------------------|--------|-----------|----------------------------------------------------|
| `nombre_establecimiento` | string | ✅        | Nombre del mercado / establecimiento               |
| `numero_local`           | string | ✅        | Número de local                                    |
| `img_puesto`             | string | ❌        | URL de imagen referencial del puesto               |
| `horario_atencion`       | array  | ❌        | Array de horarios con `dia`, `apertura`, `cierre`  |
| `nombre_dueno`           | string | ✅        | Nombre del dueño del establecimiento               |
| `ruc`                    | string | ❌        | RUC del establecimiento (máx. 11 caracteres)       |

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

## Categorías (`/api/categorias`)

### `GET /api/categorias`

Lista todas las categorías (paginado, 15 por página).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombre": "Frutas y Verduras",
      "descripcion": "Productos frescos de temporada.",
      "img": "https://example.com/frutas.jpg",
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/categorias`

Crea una nueva categoría.

**Request Body**

| Campo         | Tipo   | Requerido | Descripción                         |
|---------------|--------|-----------|-------------------------------------|
| `nombre`      | string | ✅        | Nombre de la categoría (máx. 100)   |
| `descripcion` | string | ❌        | Descripción (máx. 300)              |
| `img`         | string | ❌        | URL de imagen (máx. 500)            |

**Respuesta exitosa (201)**
```json
{
  "message": "Categoria creada exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/categorias/{id}`

Obtiene una categoría por su ID.

---

### `PUT /api/categorias/{id}`

Actualiza una categoría. Todos los campos son opcionales.

---

### `DELETE /api/categorias/{id}`

Elimina una categoría.

---

## Estados de Pedido (`/api/estado-pedidos`)

### `GET /api/estado-pedidos`

Lista todos los estados de pedido (paginado, 15 por página).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombre": "Pendiente",
      "descripcion": "Pedido recibido, esperando confirmación.",
      "color": "#FFA500",
      "orden": 1,
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/estado-pedidos`

Crea un nuevo estado de pedido.

**Request Body**

| Campo         | Tipo    | Requerido | Descripción                            |
|---------------|---------|-----------|----------------------------------------|
| `nombre`      | string  | ✅        | Nombre del estado (único, máx. 80)     |
| `descripcion` | string  | ❌        | Descripción (máx. 300)                 |
| `color`       | string  | ❌        | Color en hex u otro formato (máx. 20)  |
| `orden`       | integer | ❌        | Orden de presentación (mín. 0)         |

**Respuesta exitosa (201)**
```json
{
  "message": "Estado de pedido creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/estado-pedidos/{id}`

Obtiene un estado de pedido por su ID.

---

### `PUT /api/estado-pedidos/{id}`

Actualiza un estado de pedido. Todos los campos son opcionales.

---

### `DELETE /api/estado-pedidos/{id}`

Elimina un estado de pedido.

---

## Productos (`/api/productos`)

### `GET /api/productos`

Lista todos los productos con su categoría y mercado (paginado, 15 por página).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "nombre": "Manzana Roja",
      "descripcion": "Manzana fresca de temporada.",
      "precio": 2.50,
      "stock": 100,
      "img_producto": "https://example.com/manzana.jpg",
      "activo": true,
      "categoria": {
        "id": 1,
        "nombre": "Frutas y Verduras"
      },
      "mercado": {
        "id": 1,
        "nombre_establecimiento": "Mercado Central"
      },
      "creado_en": "2026-05-26T00:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/productos`

Crea un nuevo producto.

**Request Body**

| Campo           | Tipo    | Requerido | Descripción                         |
|-----------------|---------|-----------|-------------------------------------|
| `categoria_id`  | integer | ✅        | ID de la categoría                  |
| `mercado_id`    | integer | ✅        | ID del mercado                      |
| `nombre`        | string  | ✅        | Nombre del producto (máx. 200)      |
| `descripcion`   | string  | ❌        | Descripción del producto            |
| `precio`        | decimal | ✅        | Precio unitario (mín. 0)            |
| `stock`         | integer | ❌        | Cantidad en stock (mín. 0)          |
| `img_producto`  | string  | ❌        | URL de imagen (máx. 500)            |
| `activo`        | boolean | ❌        | Si el producto está disponible      |

**Respuesta exitosa (201)**
```json
{
  "message": "Producto creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/productos/{id}`

Obtiene un producto por su ID (con categoría y mercado).

---

### `PUT /api/productos/{id}`

Actualiza un producto. Todos los campos son opcionales.

---

### `DELETE /api/productos/{id}`

Elimina un producto.

---

## Pedidos (`/api/pedidos`)

### `GET /api/pedidos`

Lista todos los pedidos con usuario, mercado, repartidor, estado e ítems (paginado, 15 por página, del más reciente al más antiguo).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "usuario": { "id": 3, "nombres": "Ana", ... },
      "mercado": { "id": 1, "nombre_establecimiento": "Mercado Central", ... },
      "repartidor": { "id": 2, "nombres": "Carlos", ... },
      "estado_pedido": { "id": 1, "nombre": "Pendiente", "color": "#FFA500" },
      "direccion_entrega": "Av. Larco 456",
      "referencia": "Edificio azul, piso 3",
      "latitud": -12.1219,
      "longitud": -77.0284,
      "notas": "Sin cebolla por favor.",
      "subtotal": 15.00,
      "descuento": 0.00,
      "costo_envio": 3.50,
      "total": 18.50,
      "items": [
        {
          "id": 1,
          "producto": { "id": 1, "nombre": "Manzana Roja", "precio": 2.50 },
          "cantidad": 6,
          "precio_unitario": 2.50,
          "subtotal": 15.00
        }
      ],
      "historial_estados": [
        {
          "id": 1,
          "estado": { "id": 1, "nombre": "Pendiente" },
          "notas": "Pedido creado.",
          "registrado_en": "2026-05-26T10:00:00.000000Z"
        }
      ],
      "creado_en": "2026-05-26T10:00:00.000000Z",
      "actualizado_en": "2026-05-26T10:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/pedidos`

Crea un nuevo pedido. Los precios unitarios se calculan automáticamente desde los productos registrados. El historial de estado se genera automáticamente.

**Request Body**

| Campo               | Tipo    | Requerido | Descripción                                     |
|---------------------|---------|-----------|-------------------------------------------------|
| `usuario_id`        | integer | ✅        | ID del usuario que realiza el pedido            |
| `mercado_id`        | integer | ✅        | ID del mercado                                  |
| `repartidor_id`     | integer | ❌        | ID del repartidor asignado                      |
| `estado_pedido_id`  | integer | ✅        | ID del estado inicial del pedido                |
| `direccion_entrega` | string  | ✅        | Dirección de entrega (máx. 400)                 |
| `referencia`        | string  | ❌        | Referencia de la dirección (máx. 300)           |
| `latitud`           | decimal | ❌        | Latitud del punto de entrega                    |
| `longitud`          | decimal | ❌        | Longitud del punto de entrega                   |
| `notas`             | string  | ❌        | Notas adicionales para el pedido                |
| `descuento`         | decimal | ❌        | Descuento aplicado (mín. 0, por defecto 0)      |
| `costo_envio`       | decimal | ❌        | Costo de envío (mín. 0, por defecto 0)          |
| `items`             | array   | ✅        | Lista de ítems del pedido (mín. 1 elemento)     |
| `items.*.producto_id` | integer | ✅      | ID del producto                                 |
| `items.*.cantidad`    | integer | ✅      | Cantidad del producto (mín. 1)                  |

**Ejemplo de Request**
```json
{
  "usuario_id": 3,
  "mercado_id": 1,
  "estado_pedido_id": 1,
  "direccion_entrega": "Av. Larco 456",
  "referencia": "Edificio azul, piso 3",
  "items": [
    { "producto_id": 1, "cantidad": 6 },
    { "producto_id": 4, "cantidad": 2 }
  ]
}
```

**Respuesta exitosa (201)**
```json
{
  "message": "Pedido creado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/pedidos/{id}`

Obtiene un pedido completo (usuario, mercado, repartidor, estado, ítems e historial de estados).

---

### `PUT /api/pedidos/{id}`

Actualiza un pedido (p.e., cambiar repartidor, notas o dirección). El `total` se recalcula automáticamente si se modifican `descuento` o `costo_envio`. No se deben incluir `items` en esta operación.

**Request Body** — Igual que `POST`, todos los campos opcionales.

**Respuesta exitosa (200)**
```json
{
  "message": "Pedido actualizado exitosamente.",
  "data": { ... }
}
```

---

### `DELETE /api/pedidos/{id}`

Elimina un pedido y sus ítems asociados (en cascada).

**Respuesta exitosa (200)**
```json
{
  "message": "Pedido eliminado exitosamente."
}
```

---

### `PATCH /api/pedidos/{id}/estado`

Actualiza el estado de un pedido y registra la transición en el historial de estados.

**Request Body**

| Campo              | Tipo    | Requerido | Descripción                     |
|--------------------|---------|-----------|----------------------------------|
| `estado_pedido_id` | integer | ✅        | ID del nuevo estado del pedido   |
| `notas`            | string  | ❌        | Notas sobre el cambio de estado  |

**Ejemplo de Request**
```json
{
  "estado_pedido_id": 2,
  "notas": "Pedido confirmado y en preparación."
}
```

**Respuesta exitosa (200)**
```json
{
  "message": "Estado del pedido actualizado exitosamente.",
  "data": { ... }
}
```

---

## Pagos (`/api/pagos`)

### `GET /api/pagos`

Lista todos los pagos con historial (paginado, 15 por página, del más reciente al más antiguo).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "pedido": { "id": 3, "total": 18.50, ... },
      "monto": 18.50,
      "metodo_pago": "yape",
      "estado": "completado",
      "referencia_pago": "TXN-0001",
      "notas": null,
      "historial_pagos": [
        {
          "id": 1,
          "estado": "completado",
          "notas": "Pago registrado.",
          "registrado_en": "2026-06-23T10:00:00.000000Z"
        }
      ],
      "creado_en": "2026-06-23T10:00:00.000000Z",
      "actualizado_en": "2026-06-23T10:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### `POST /api/pagos`

Registra un nuevo pago. Si se proporciona `estado_pedido_id`, actualiza también el estado del pedido y genera un registro en su historial de estados.

**Request Body**

| Campo              | Tipo    | Requerido | Descripción                                                                                      |
|--------------------|---------|-----------|--------------------------------------------------------------------------------------------------|
| `pedido_id`        | integer | ✅        | ID del pedido al que pertenece el pago                                                           |
| `monto`            | decimal | ✅        | Monto del pago (mín. 0)                                                                          |
| `metodo_pago`      | string  | ✅        | Método de pago: `efectivo`, `tarjeta_credito`, `tarjeta_debito`, `transferencia`, `yape`, `plin`, `otro` |
| `estado`           | string  | ❌        | Estado del pago: `pendiente`, `completado`, `fallido`, `reembolsado` (por defecto `pendiente`)   |
| `referencia_pago`  | string  | ❌        | Código o referencia de la transacción (máx. 200)                                                 |
| `notas`            | string  | ❌        | Notas adicionales                                                                                |
| `estado_pedido_id` | integer | ❌        | Si se envía, cambia el estado del pedido y registra la transición en su historial                |

**Ejemplo de Request**
```json
{
  "pedido_id": 3,
  "monto": 18.50,
  "metodo_pago": "yape",
  "estado": "completado",
  "referencia_pago": "TXN-0001",
  "estado_pedido_id": 3
}
```

**Respuesta exitosa (201)**
```json
{
  "message": "Pago registrado exitosamente.",
  "data": { ... }
}
```

---

### `GET /api/pagos/{id}`

Obtiene un pago con su historial y el pedido asociado.

---

### `PUT /api/pagos/{id}`

Actualiza un pago. Si cambia el `estado`, se registra automáticamente en el historial. Si se envía `estado_pedido_id`, también actualiza el estado del pedido.

**Request Body** — Igual que `POST`, todos los campos opcionales (excepto `pedido_id` que no se puede cambiar).

**Respuesta exitosa (200)**
```json
{
  "message": "Pago actualizado exitosamente.",
  "data": { ... }
}
```

---

### `DELETE /api/pagos/{id}`

Elimina un pago y su historial (en cascada).

**Respuesta exitosa (200)**
```json
{
  "message": "Pago eliminado exitosamente."
}
```

---

### `GET /api/pedidos/{id}/pagos`

Lista todos los pagos de un pedido específico (paginado, 15 por página).

**Respuesta exitosa (200)**
```json
{
  "data": [
    {
      "id": 1,
      "monto": 18.50,
      "metodo_pago": "yape",
      "estado": "completado",
      "referencia_pago": "TXN-0001",
      "historial_pagos": [ ... ],
      "creado_en": "2026-06-23T10:00:00.000000Z",
      "actualizado_en": "2026-06-23T10:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

## Errores Comunes

| Código | Descripción                                           |
|--------|-------------------------------------------------------|
| `401`  | No autenticado — Token faltante o inválido            |
| `404`  | Recurso no encontrado                                 |
| `422`  | Error de validación — Se retorna `errors` con detalle |
| `500`  | Error interno del servidor                            |

**Estructura de error de validación (422)**
```json
{
  "message": "No se pudo procesar la solicitud por errores de validacion.",
  "errors": {
    "calificacion": ["El campo calificacion debe estar entre 1 y 5."],
    "repartidor_id": ["El repartidor seleccionado no existe."]
  }
}
```

---

## Configuración del Entorno

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
