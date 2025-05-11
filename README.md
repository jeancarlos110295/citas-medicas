# 🚀 API de Citas Médicas

# Requerimientos:

## Objetivo: 

Realizar una API Restfull haciendo uso de POO, con endpoints que permitan lo siguiente: 
- Pedir cita médica (al paciente) 
- Pagar cita para confirmar asistencia (al paciente) (Implementar una pasarela de pago con ambiente sandbox) 
- Confirmar cita (al médico) (Validar que la cita esté pagada para confirmarla) 
- Listar mis citas del día (al médico) 
- Correlación de citas por paciente. (Agenda) (El horario de atención es de 7:00 a 12:00 y de 14:00 a 18:00) 

## Parámetros: 

Imaginar los parámetros necesarios de cada endpoint. Campos comunmente usados para una cita médica. 

## Roles y Permisos de usuario: 

- Paciente, únicamente pedirá cita. 
- Médico, podrá confirmar la cita o rechazarla de acuerdo.  
- Podrá gestionar sus citas. 

## Validaciones: 

- No se puede pedir cita en un horario no permitido. 
- No se puede pedir cita en un horario ya ocupado. 
- No se puede confirmar una cita que no ha sido pagada. 
- Otras validaciones que se consideren necesarias. 


## Seguridad y autenticación: 

Implementar un sistema de autenticación simple, puede ser un token en la URL o un token en  el header de la petición. 
No es necesario implementar un sistema de autenticación complejo. 

## Base de datos: 

Utilizar MariaDB, MySQL, PostgreSQL o MongoDB. Crear las tablas necesarias para el funcionamiento de la API.  Se debe entregar el script de creación de la base de datos. 

## Entrega: 

Se debe entregar el código fuente de la API, el script de creación de la base de datos y un archivo README.md con las instrucciones de uso. 

## Desarrollo, Se evaluará: 

- La calidad y arquitectura del código. 
- La estructura del proyecto. 
- Uso de Patrones de diseño. 
- Uso de principios SOLID. 
- Uso de gestor de dependencias. 
- Uso de control de versiones. 
- Pruebas unitarias. 
- Documentación del código. 
- Uso de comentarios en el código. 
- Uso de buenas prácticas de programación. 
- Uso de buenas prácticas de seguridad. 

# 🛠️ Tecnologías Utilizadas

- **[laravel](https://laravel.com/docs/12.x)**: Framework de Laravel en su ultima versión.
- **[PostgreSQL](https://www.postgresql.org/)**: Sistema de gestión de bases de datos relacional.
- **[Nginx](https://www.nginx.com/)**: Servidor web y proxy inverso.
- **Docker**: Para la contenerización y fácil despliegue.

# 📂 Repositorio

El código fuente está disponible en [Github]().

# 📋 Requisitos

- Docker (La más reciente)
- Docker Compose (La más reciente)

# Configuración

## Docker

1. Crear archivo `.env`: `cp .env.example .env`
2. Configurar las siguientes variables:
    - Nombre Base de datos: POSTGRES_DB=""
    - Usuario Base de datos: POSTGRES_USER=""
    - Clave Base de datos: POSTGRES_PASSWORD=""
    - Puerto Base de datos: POSTGRES_PORT=""


## Laravel

1. Navegar al directorio del proyecto: `cd api`.
2. Crear archivo `.env`: `cp .env.example .env`
    - Nombre BD : POSTGRES_DB=""
    - Usuario BD : POSTGRES_USER=""
    - Clave BD : POSTGRES_PASSWORD=""
    - Puerto DB : POSTGRES_DB_PORT=""
    - Host DB : POSTGRES_DB_HOST=""


# 🚀 Instalación

1. Correr contenedores:

```bash
    docker-compose up -d --build
```

# Desinstalación

1. Eliminar contenedores del proyecto:

```bash
    docker-compose down --volumes --remove-orphans && docker image rmi citas_medicas_app:latest
```
