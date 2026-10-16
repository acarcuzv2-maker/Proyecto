# Básicos Mariano G.

## Descripción

Básicos Mariano G. es una aplicación web desarrollada con codeigniter 4, para la entrega del proyecto de el curso de algoritmos, brinda las opciones necesesarias para cubrir el enunciado de practica

## Se utilizó los siguientes programas:

- PHP 
- CodeIgniter 4
- BladeOne
- MySQL
- HTML5
- CSS3
- JavaScript
- XAMPP
- Git y GitHub



## Requisitos

- PHP 8.2 o superior.
- Composer.
- MySQL.
- Apache.
- Extensiones de PHP requeridas por CodeIgniter 4.

## Instalación

1. Clonar o descargar este repositorio.
2. Colocar el proyecto en un servidor compatible con PHP.
3. Abrir una terminal dentro de la carpeta del proyecto.
4. Instalar las dependencias:

```bash
composer install
```

5. Crear una base de datos en MySQL.
6. Importar el archivo `database.sql`.
7. Crear un archivo `.env` a partir de `env` y configurar la conexión a la base de datos.
8. Configurar las credenciales SMTP para habilitar los correos de activación y recuperación.
9. Configurar Apache para que el directorio público del proyecto sea `public/`.
10. Iniciar Apache y MySQL y acceder a la aplicación desde el navegador.

## Base de datos

El archivo `database.sql` contiene la estructura de las tablas necesarias para el funcionamiento del sistema.


## Seguridad

El sistema utiliza contraseñas cifradas mediante hash, sesiones de usuario y restricciones de acceso según los roles.

## Acceso de administrador

Por seguridad, las cuentas registradas inicialmente tienen el rol de usuario.

Para habilitar una cuenta administrativa:

1. Registrar una cuenta desde la aplicación.
2. Activarla mediante el correo electrónico.
3. Acceder a phpMyAdmin y seleccionar la base de datos.
4. Ejecutar la siguiente consulta SQL:

```sql
UPDATE usuarios
SET rol = 'admin'
WHERE email = 'correo_del_administrador@ejemplo.com';
```

5. Cerrar sesión y volver a iniciar sesión.

La cuenta tendrá acceso a las funcionalidades administrativas.
