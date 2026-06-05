# CoffeeTime

CoffeeTime es una aplicación web de gestión educativa online construida con Laravel y desplegada con Docker. El proyecto incluye registro y gestión de usuarios, profesores, alumnos, eventos y recursos, junto con roles de administrador, profesor y alumno.

Tecnologías

- PHP 8.2 y Laravel 11
- Docker / docker-compose
- Apache + MySQL (contenedor `db`)
- JavaScript con jQuery y DataTables para tablas dinámicas
- Blade para las vistas
- CSS y Bootstrap para el diseño
- Chart para dashboards

Arquitectura y funcionalidades

- Estructura MVC de Laravel: `app/Http/Controllers`, `app/Models`, `resources/views`
- Rutas definidas en `routes/web.php` para páginas públicas y protegidas
- Panel de administración `resources/views/Gestor.blade.php` con CRUD para usuarios, profesores y alumnos
- Gestión de eventos y recursos con inscripciones, subida y borrado
- Autenticación básica y control de acceso por roles
- AJAX/JSON para recarga de datos dinámica

Entorno de desarrollo

El proyecto se ejecuta con Docker usando `docker-compose.yml`:

- Servicio `app`: PHP 8.2 + Apache
- Servicio `db`: MySQL 8.0 con base de datos `coffeetime`
- Servicio `phpmyadmin`: acceso en el puerto `8081`

Cómo desplegarlo

1. Copiar `.env.example` a `.env` y ajustar en caso de puertos ocupados
2. Ejecutar `docker-compose up --build`
3. Acceder a la aplicación en `http://localhost`
4. PhpMyAdmin disponible en `http://localhost:8081`
5. Ejecutar migraciones y seeders: `docker-compose exec app php artisan migrate` y `docker-compose exec app php artisan db:seed`.
