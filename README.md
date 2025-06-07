# API de Clima y Usuarios - Proyecto Laravel

API RESTful desarrollada con Laravel para gestionar usuarios, autenticación, consultas de clima, ciudades favoritas e historial de búsquedas.

---

## Características principales

- Registro e inicio de sesión con tokens API (Sanctum).
- Consultas del clima para ciudades con datos: temperatura, estado, viento, humedad y hora local.
- Registro y consulta del historial de búsquedas por usuario.
- Gestión de ciudades favoritas por usuario.
- Seeders para poblar la base de datos con datos de ejemplo.
- Pruebas automatizadas con PHPUnit para servicios y endpoints.

---

## Tecnologías usadas

- Laravel 12.x  
- PHP 8.x  
- PostgreSQL  
- Laravel Sanctum  
- Faker  
- PHPUnit  

---

## Requisitos

- PHP >= 8.x  
- Composer  
- PostgreSQL  
- Extensiones PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON  

---

## Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/tuusuario/tu-repo.git
    cd tu-repo
    ```

2. Instala dependencias:

    ```bash
    composer install
    ```

3. Copia el archivo de entorno y configura la base de datos PostgreSQL:

    ```bash
    cp .env.example .env
    ```

4. Edita el archivo `.env` para configurar los datos de conexión a la base de datos PostgreSQL:

    ```bash
    nano .env
    ```

5. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

6. Ejecuta migraciones y seeders para poblar la base de datos:

    ```bash
    php artisan migrate --seed
    ```

7. Inicia el servidor local:

    ```bash
    php artisan serve
    ```

---

## Autenticación

Para las rutas protegidas, utiliza el token recibido en el login en el header de las peticiones:


---

## Archivos Postman

Dentro de la carpeta `/postman` encontrarás la colección `HTTP Request.postman_collection.json`, que puedes importar en Postman para probar fácilmente todos los endpoints de la API.

### Pasos para usar la colección Postman

1. Abre Postman.  
2. Haz clic en **Import** y selecciona el archivo `HTTP Request.postman_collection.json` dentro de la carpeta `/postman`.  
3. Configura la variable `base_url` con la URL donde esté corriendo tu API, por ejemplo:  
   `http://localhost:8000/api`  
4. Ejecuta las peticiones para probar las funcionalidades de la API.

> Nota: Asegúrate de tener el servidor corriendo y configurado correctamente antes de realizar las pruebas con Postman.

---

## Endpoints principales

- **POST /api/register**  
  Registrar un nuevo usuario.

- **POST /api/login**  
  Iniciar sesión y obtener token.

- **POST /api/logout** *(requiere token)*  
  Cerrar sesión (revocar token actual).

- **GET /api/weather** *(requiere token)*  
  Obtener datos del clima para una ciudad.

- **GET /api/history** *(requiere token)*  
  Obtener historial de búsquedas.

- **POST /api/favorites** *(requiere token)*  
  Agregar ciudad favorita.

- **GET /api/favorites** *(requiere token)*  
  Listar ciudades favoritas.

- **DELETE /api/favorites** *(requiere token)*  
  Eliminar ciudad favorita.

---

## Ejecutar pruebas

Para correr las pruebas automáticas con PHPUnit:

```bash
php artisan test
