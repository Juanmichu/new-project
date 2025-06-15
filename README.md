# 🚀 GUÍA COMPLETA: Docker + MongoDB + Laravel + React

# ===============================
# 1. PREPARACIÓN DEL PROYECTO
# ===============================

# Estructura de carpetas recomendada:
fittracker/
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
docker exec -it fittracker_mongodb bash

# Conectarse directamente a MongoDB shell
docker exec -it fittracker_mongodb mongosh

# Conectarse con autenticación
docker exec -it fittracker_mongodb mongosh -u admin -p admin123 --authenticationDatabase admin

# Conectarse a la base de datos específica
docker exec -it fittracker_mongodb mongosh fittracker -u fittracker_user -p fittracker_pass

# Ejecutar comandos MongoDB desde host
docker exec fittracker_mongodb mongosh --eval "db.adminCommand('listCollections')" fittracker

# Crear backup de la base de datos
docker exec fittracker_mongodb mongodump --db fittracker --out /data/backup

# Restaurar backup
docker exec fittracker_mongodb mongorestore --db fittracker /data/backup/fittracker

# ===============================
# 4. COMANDOS ÚTILES MONGODB
# ===============================

# Una vez dentro del MongoDB shell (mongosh):

# Mostrar bases de datos
show dbs

# Usar base de datos
use fittracker

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
docker exec -it fittracker_backend bash

# Ejecutar comandos Artisan
docker exec fittracker_backend php artisan migrate
docker exec fittracker_backend php artisan db:seed
docker exec fittracker_backend php artisan config:clear
docker exec fittracker_backend php artisan cache:clear

# Instalar dependencias Composer
docker exec fittracker_backend composer install

# Generar clave de aplicación
docker exec fittracker_backend php artisan key:generate

# Ver rutas
docker exec fittracker_backend php artisan route:list

# ===============================
# 6. COMANDOS REACT EN DOCKER
# ===============================

# Acceder al contenedor del frontend
docker exec -it fittracker_frontend sh

# Instalar nuevas dependencias
docker exec fittracker_frontend npm install nueva-dependencia

# Ver logs del frontend
docker exec fittracker_frontend npm run start

# Construir para producción
docker exec fittracker_frontend npm run build

# ===============================
# 7. DEBUGGING Y TROUBLESHOOTING
# ===============================

# Ver todos los contenedores
docker ps -a

# Ver uso de recursos
docker stats

# Inspeccionar un contenedor
docker inspect fittracker_mongodb

# Ver logs de un contenedor específico
docker logs fittracker_backend --tail 50

# Limpiar sistema Docker (¡CUIDADO!)
docker system prune -a

# Ver volúmenes
docker volume ls

# Inspeccionar volumen de MongoDB
docker volume inspect fittracker_mongodb_data

# Ver redes
docker network ls

# Inspeccionar red
docker network inspect fittracker_fittracker-network

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
docker exec fittracker_backend php artisan migrate --force

echo "Ejecutando seeders..."
docker exec fittracker_backend php artisan db:seed --force

echo "¡Entorno reseteado completamente!"

# Script para backup (backup.sh)
#!/bin/bash
BACKUP_DIR="./backups/$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

echo "Creando backup de MongoDB..."
docker exec fittracker_mongodb mongodump --db fittracker --out /data/backup

echo "Copiando backup al host..."
docker cp fittracker_mongodb:/data/backup $BACKUP_DIR

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
docker exec fittracker_mongodb mongosh --eval "db.serverStatus().connections"

# Ver performance de MongoDB
docker exec fittracker_mongodb mongosh --eval "db.serverStatus().opcounters"

# Verificar conexión entre servicios
docker exec fittracker_backend ping mongodb

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
docker exec fittracker_mongodb mongosh --eval "
db.getSiblingDB('admin').changeUserPassword('admin', 'nueva_password_segura')
"

# Verificar usuarios de MongoDB
docker exec fittracker_mongodb mongosh --eval "
db.getSiblingDB('admin').getUsers()
"

# Ver configuración de seguridad
docker exec fittracker_mongodb mongosh --eval "
db.getSiblingDB('admin').runCommand({getParameter: 1, authenticationMechanisms: 1})
"