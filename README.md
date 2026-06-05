# CoffeeTime

CoffeeTime es una aplicación web de gestión educativa construida con Laravel y desplegada con Docker. El proyecto incluye registro y gestión de usuarios, profesores, alumnos, eventos y recursos, junto con roles de administrador, profesor y alumno.

## Tecnologías principales

- PHP 8.2 y Laravel 11
- Docker / docker-compose
- Apache + MySQL (contenedor `db`)
- JavaScript con jQuery y DataTables para tablas dinámicas
- Blade para plantillas del frontend
- CSS personalizado y Bootstrap para el diseño

## Arquitectura y funcionalidades

- Estructura MVC típica de Laravel: `app/Http/Controllers`, `app/Models`, `resources/views`
- Rutas definidas en `routes/web.php` para páginas públicas y áreas protegidas
- Panel de administración con CRUD para usuarios, profesores y alumnos
- Gestión de eventos y recursos con inscripciones, subida y borrado
- Autenticación básica y control de acceso por roles
- AJAX/JSON para recarga de datos y operaciones en tablas sin recargar la página

## Entorno de desarrollo

El proyecto se ejecuta con Docker usando `docker-compose.yml`:

- Servicio `app`: contenedor PHP 8.2 + Apache
- Servicio `db`: MySQL 8.0 con base de datos `coffeetime`
- Servicio `phpmyadmin`: acceso UI para la base de datos en el puerto `8081`

## Cómo ejecutar

1. Copiar `.env.example` a `.env` y ajustar si es necesario
2. Ejecutar `docker-compose up --build`
3. Acceder a la aplicación en `http://localhost`
4. phpMyAdmin disponible en `http://localhost:8081`

## Qué debe evaluar el tribunal

- Uso de Docker para contenerizar la app y la base de datos
- Uso de Laravel para la lógica del servidor y el modelo de datos
- Integración de frontend dinámico con DataTables, AJAX y validaciones básicas
- Administración de distintos tipos de usuarios y roles
- Separación de responsabilidades entre rutas, controladores y vistas

## Nota

El proyecto está pensado como una plataforma sencilla de administración educativa, con énfasis en la gestión de registros, eventos y recursos dentro de un entorno web moderno e informal.
