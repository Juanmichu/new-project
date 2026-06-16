

# FitCoacher - Aplicación de Gestión de Fitness y Entrenamientos

Una aplicación integral de fitness construida con Laravel y MongoDB que ayuda a los usuarios a crear, rastrear y gestionar sus rutinas de entrenamiento, explorar ejercicios y mantenerse informados con artículos y noticias sobre fitness.

## 🚀 Características

* **Autenticación y Perfiles de Usuario:** Sistema seguro de registro e inicio de sesión con perfiles de usuario personalizables
* **Biblioteca de Ejercicios:** Navega y busca ejercicios por grupo muscular, nivel de dificultad y equipo
* **Gestión de Entrenamientos:** Crea, programa y rastrea rutinas de entrenamiento personalizadas
* **Seguimiento de Progreso:** Monitorea la finalización de entrenamientos, calorías quemadas y estadísticas de fitness
* **Sistema de Blog:** Lee artículos, consejos y guías sobre fitness
* **Sección de Noticias:** Mantente actualizado con las últimas noticias y tendencias de fitness
* **Diseño Responsivo:** Funciona perfectamente en dispositivos de escritorio y móviles
* **Arquitectura API-First:** API RESTful para integración con frontend

## 🛠️ Stack Tecnológico

### Backend

* **Framework:** Laravel 12.x
* **Base de Datos:** MongoDB
* **Autenticación:** Laravel Sanctum
* **Versión PHP:** 8.2+
* **Gestor de Paquetes:** Composer

### Assets Frontend

* **Framework CSS:** Tailwind CSS 4.0
* **Herramienta de Construcción:** Vite
* **JavaScript:** Vanilla JS con Axios para llamadas API

## 📋 Prerequisitos

* **PHP:** 8.2 o superior
* **Composer:** Gestor de paquetes PHP
* **MongoDB:** 4.4+
* **Node.js:** 18+ y npm
* **Docker y Docker Compose:** (opcional)

## 🔧 Instalación

### Usando Docker (Recomendado)

#### Clona el repositorio:

bash git clone <url-del-repositorio>
cd fitcoacher

### Construye los assets y dependencias (si es tu primera vez):
bash cd backend
bash composer install
bash npm install
bash npm run build

bash cd ../frontend
bash npm install
bash npm run build

### Inicia los contenedores Docker:

** Si construyes por primera vez, usa: **
bash docker-compose up --build -d

** Si ya construiste antes, usa: **
bash docker-compose up -d

La aplicación estará disponible en:

* **Backend:** http://localhost:8000
* **Frontend:** http://localhost:3000
* **MongoDB:** mongodb://user:pass@localhost:27017

### Instalación Manual

#### Clona el repositorio:

bash git clone <url-del-repositorio>
cd fitcoacher/backend

#### Instala las dependencias PHP:

bash composer install

#### Instala las dependencias Node y construye los assets:

bash npm install
bash npm run build

#### Configura tu conexión MongoDB en .env:

DB_CONNECTION=mongodb
DB_HOST=mongodb
DB_PORT=27017
DB_DATABASE=laraveldb
DB_USERNAME=app_root
DB_PASSWORD=1234

#### Genera la clave de aplicación:

bash php artisan key:generate

#### Ejecuta los seeders de la base de datos:

bash php artisan db:seed

#### Construye los assets del frontend:

bash npm run build

#### Construye el entorno y levántalo en modo “detach”

bash docker compose up —-build -d


## 📱 Endpoints de API

### Autenticación

POST /api/auth/register - Registro de usuario
POST /api/auth/login - Inicio de sesión
POST /api/auth/logout - Cerrar sesión (requiere auth)
GET /api/auth/user - Obtener usuario autenticado

### Ejercicios

GET /api/exercises - Listar todos los ejercicios
GET /api/exercises/{id} - Obtener detalles del ejercicio
GET /api/exercises/categories - Obtener categorías de ejercicios

### Entrenamientos (Requiere Autenticación)

GET /api/workouts - Listar entrenamientos del usuario
POST /api/workouts - Crear nuevo entrenamiento
GET /api/workouts/today - Obtener entrenamiento de hoy
GET /api/workouts/{id} - Obtener detalles del entrenamiento
PUT /api/workouts/{id} - Actualizar entrenamiento
DELETE /api/workouts/{id} - Eliminar entrenamiento

### Artículos y Noticias

GET /api/articles - Listar artículos
GET /api/articles/{slug} - Obtener detalles del artículo
GET /api/news - Listar noticias
GET /api/news/breaking - Obtener noticias de última hora

### Estadísticas del Usuario (Requiere Autenticación)

GET /api/stats/dashboard - Obtener estadísticas del dashboard
GET /api/stats/progress - Obtener datos de progreso

## 🗄️ Esquema de Base de Datos

### Colecciones

* **users:** Perfiles de usuario con objetivos y preferencias de fitness
* **exercises:** Biblioteca de ejercicios con instrucciones y categorías
* **workouts:** Planes de entrenamiento creados por usuarios
* **workout_exercises:** Ejercicios dentro de los entrenamientos
* **workout_sessions:** Seguimiento del rendimiento real del entrenamiento
* **articles:** Artículos del blog de fitness
* **news_articles:** Noticias y actualizaciones de fitness

## 🔐 Credenciales por Defecto

Después de ejecutar los seeders de la base de datos, puedes usar estas credenciales:

### Usuario Administrador

Email: admin@fittracker.com
Contraseña: password


### Usuarios Regulares

Email: john@example.com
Contraseña: 1234
Email: jane@example.com
Contraseña: password123

## 🧪 Pruebas

Ejecuta el conjunto de pruebas:
bash php artisan test

## 🚀 Despliegue

Configura las variables de entorno apropiadas para producción
Ejecuta migraciones y seeders
Construye los assets del frontend: npm run build
Configura tu servidor web (Nginx/Apache)
Configura certificados SSL
Configura MongoDB para uso en producción

## 📝 Variables de Entorno

Variables de entorno clave para configurar:
envAPP_NAME=new-project
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mongodb
MONGODB_URI=mongodb://usuario:contraseña@host:puerto/basededatos

FRONTEND_URL=http://localhost:3000

SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,tu-dominio.com

## 🤝 Contribuir

Haz fork del repositorio
Crea tu rama de características (git checkout -b feature/caracteristica-asombrosa)
Confirma tus cambios (git commit -m 'Añadir alguna característica asombrosa')
Empuja a la rama (git push origin feature/caracteristica-asombrosa)
Abre un Pull Request

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT.

## 👥 Autores

Juan Manuel Serrano Pérez

## 🙏 Agradecimientos

Laravel Framework
MongoDB
Tailwind CSS
Profesorado de DAW de IES Carlos III (Cartagena)


# 🚀 GUÍA COMPLETA: Docker + MongoDB + Laravel + React

# ===============================
# 1. PREPARACIÓN DEL PROYECTO
# ===============================

# Estructura de carpetas recomendada:
new-project/
├── docker-compose.yml
├── backend/
│   ├── Dockerfile
│   ├── apache-config.conf
│   ├── .env.docker
│   └── [archivos Laravel]
├── frontend/
│   ├── Dockerfile
│   ├── .env.docker
│   └── [archivos React]
└── mongodb/
    ├── mongod.conf
    └── init-scripts/
        └── 01-init-users.js

# ===============================
# 2. COMANDOS DE DOCKER COMPOSE
# ===============================

# Construir y levantar todos los servicios
docker-compose up --build -d

# Ver logs de todos los servicios
docker-compose logs -f

# Ver logs específicos
docker-compose logs -f mongodb
docker-compose logs -f backend
docker-compose logs -f frontend

# Parar todos los servicios
docker-compose down

# Parar y eliminar volúmenes (¡CUIDADO! Elimina datos de MongoDB)
docker-compose down -v

# Reconstruir un servicio específico
docker-compose up --build backend

# Ver estado de los servicios
docker-compose ps

# ===============================
# 3. COMANDOS MONGODB EN DOCKER
# ===============================

# Conectarse al contenedor de MongoDB
docker exec -it mongodb bash

# Conectarse directamente a MongoDB shell
docker exec -it mongodb mongosh

# Conectarse con autenticación
docker exec -it mongodb mongosh -u admin -p admin123 --authenticationDatabase admin

# Conectarse a la base de datos específica
docker exec -it mongodb mongosh laraveldb -u user -p pass

# Ejecutar comandos MongoDB desde host
docker exec mongodb mongosh --eval "db.adminCommand('listCollections')" laraveldb

# Crear backup de la base de datos
docker exec mongodb mongodump --db laraveldb --out /data/backup

# Restaurar backup
docker exec mongodb mongorestore --db laraveldb /data/backup/laraveldb

# ===============================
# 4. COMANDOS ÚTILES MONGODB
# ===============================

# Una vez dentro del MongoDB shell (mongosh):

# Mostrar bases de datos
show dbs

# Usar base de datos
use laraveldb

# Mostrar colecciones
show collections

# Ver usuarios
db.getUsers()

# Contar documentos
db.users.countDocuments()
db.exercises.countDocuments()

# Buscar todos los usuarios
db.users.find().pretty()

# Buscar usuario específico
db.users.findOne({email: "admin@fittracker.com"})

# Actualizar documento
db.users.updateOne(
  {email: "admin@fittracker.com"}, 
  {$set: {fitness_level: "expert"}}
)

# Eliminar documento
db.users.deleteOne({email: "test@example.com"})

# Ver estadísticas de la colección
db.users.stats()

# ===============================
# 5. COMANDOS LARAVEL EN DOCKER
# ===============================

# Acceder al contenedor del backend
docker exec -it backend bash

# Ejecutar comandos Artisan
docker exec backend php artisan migrate
docker exec backend php artisan db:seed
docker exec backend php artisan config:clear
docker exec backend php artisan cache:clear

# Instalar dependencias Composer
docker exec backend composer install

# Generar clave de aplicación
docker exec backend php artisan key:generate

# Ver rutas
docker exec backend php artisan route:list

# ===============================
# 6. COMANDOS REACT EN DOCKER
# ===============================

# Acceder al contenedor del frontend
docker exec -it frontend sh

# Instalar nuevas dependencias
docker exec frontend npm install nueva-dependencia

# Ver logs del frontend
docker exec frontend npm run start

# Construir para producción
docker exec frontend npm run build

# ===============================
# 7. DEBUGGING Y TROUBLESHOOTING
# ===============================

# Ver todos los contenedores
docker ps -a

# Ver uso de recursos
docker stats

# Inspeccionar un contenedor
docker inspect mongodb

# Ver logs de un contenedor específico
docker logs backend --tail 50

# Limpiar sistema Docker (¡CUIDADO!)
docker system prune -a

# Ver volúmenes
docker volume ls

# Inspeccionar volumen de MongoDB
docker volume inspect mongodb_data

# Ver redes
docker network ls

# Inspeccionar red
docker network inspect new-project-network

# ===============================
# 8. SCRIPTS DE DESARROLLO
# ===============================

# Script para resetear todo (reset.sh)
#!/bin/bash
echo "Parando contenedores..."
docker-compose down -v

echo "Limpiando imágenes..."
docker-compose build --no-cache

echo "Iniciando servicios..."
docker-compose up -d

echo "Esperando que MongoDB esté listo..."
sleep 30

echo "Ejecutando migraciones..."
docker exec backend php artisan migrate --force

echo "Ejecutando seeders..."
docker exec backend php artisan db:seed --force

echo "¡Entorno reseteado completamente!"

# Script para backup (backup.sh)
#!/bin/bash
BACKUP_DIR="./backups/$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

echo "Creando backup de MongoDB..."
docker exec mongodb mongodump --db laraveldb --out /data/backup

echo "Copiando backup al host..."
docker cp mongodb:/data/backup $BACKUP_DIR

echo "Backup creado en: $BACKUP_DIR"

# ===============================
# 9. URLS DE ACCESO
# ===============================

# Frontend React: http://localhost:3000
# Backend Laravel: http://localhost:8000
# MongoDB: mongodb://localhost:27017
# Mongo Express: http://localhost:8081
#   Usuario: admin
#   Contraseña: admin123

# ===============================
# 10. VARIABLES DE ENTORNO
# ===============================

# Para desarrollo local, crear archivos .env:
# backend/.env (copia de .env.docker)
# frontend/.env (copia de .env.docker)

# Para producción, usar variables de entorno del sistema:
export DB_HOST=tu-mongodb-host
export DB_USERNAME=tu-usuario
export DB_PASSWORD=tu-password

# ===============================
# 11. COMANDOS DE MONITOREO
# ===============================

# Monitorear logs en tiempo real
docker-compose logs -f --tail=100

# Ver conexiones a MongoDB
docker exec mongodb mongosh --eval "db.serverStatus().connections"

# Ver performance de MongoDB
docker exec mongodb mongosh --eval "db.serverStatus().opcounters"

# Verificar conexión entre servicios
docker exec backend ping mongodb

# ===============================
# 12. COMANDOS DE LIMPIEZA
# ===============================

# Limpiar contenedores parados
docker container prune

# Limpiar imágenes no utilizadas
docker image prune

# Limpiar volúmenes no utilizados
docker volume prune

# Limpiar redes no utilizadas
docker network prune

# ===============================
# 13. COMANDOS DE SEGURIDAD
# ===============================

# Cambiar contraseñas en producción
docker exec mongodb mongosh --eval "
db.getSiblingDB('admin').changeUserPassword('admin', 'nueva_password_segura')
"

# Verificar usuarios de MongoDB
docker exec mongodb mongosh --eval "
db.getSiblingDB('admin').getUsers()
"

# Ver configuración de seguridad
docker exec mongodb mongosh --eval "
db.getSiblingDB('admin').runCommand({getParameter: 1, authenticationMechanisms: 1})
"