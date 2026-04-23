# Sistema de Gestión de Citas y Servicios (Prototipo Semana 10)

Este es un prototipo funcional desarrollado para la asignatura de Desarrollo Web, enfocado en demostrar el dominio de la arquitectura MVC, gestión de bases de datos relacionales, seguridad por roles y validación de formularios.

## 🚀 Tecnologías Utilizadas
*   **Framework:** Laravel 11 / 13
*   **Lenguaje:** PHP 8.3
*   **Base de Datos:** MySQL / MariaDB
*   **Estilos:** Tailwind CSS (Laravel Breeze)
*   **Frontend:** Blade Templating Engine

## 🛠️ Funcionalidades Implementadas
1.  **Capa de Datos:**
    *   Estructura relacional completa (`usuarios`, `servicios`, `citas`, `citasServicios`).
    *   Integridad referencial mediante claves foráneas.
2.  **Autenticación y Seguridad:**
    *   Sistema de Login/Logout funcional.
    *   Registro de usuarios con campos personalizados (Nombre, Apellido, Teléfono).
    *   Hash de contraseñas mediante Bcrypt.
    *   Protección de rutas mediante Middleware de Roles (`admin`, `editor`, `usuario`).
3.  **Gestión de Servicios:**
    *   Visualización pública de servicios para usuarios autenticados.
    *   **CRUD administrativo:** Solo administradores pueden crear, editar o eliminar servicios.
    *   Validación de datos tanto en cliente como en servidor.
4.  **Interfaz de Usuario:**
    *   Diseño responsive y moderno.
    *   Mensajes de estado (éxito/error) mediante notificaciones flash.

## 📋 Instrucciones de Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/innmajo/Sistema_Citas.git
    cd Sistema_Citas
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Configurar el entorno:**
    *   Copia el archivo `.env.example` a `.env`.
    *   Configura tus credenciales de base de datos en el archivo `.env`.

4.  **Generar clave y ejecutar migraciones:**
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

5.  **Iniciar servidor:**
    ```bash
    php artisan serve
    ```

## 🔐 Credenciales de Usuarios de Prueba

| Rol | Correo | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | `admin@gmail.com` | `admin123` |
| **Usuario Estándar** | `cliente@gmail.com` | `cliente123` |

---
*Proyecto desarrollado como parte de la evaluación de la Semana 10.*
