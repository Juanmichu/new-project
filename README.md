

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
* **MongoDB:** 7.0+
* **Node.js:** 20+ y npm 11+
* **Docker y Docker Compose:** (opcional)

## 🔧 Instalación

### Usando Docker (Recomendado)

#### Clona el repositorio:

```
bash git clone <url-del-repositorio>
cd fitcoacher
```
### Construye los assets y dependencias (si es tu primera vez):
```
bash cd backend
bash composer update
bash composer install
bash npm update
bash npm install
bash npm run build
```

<!-- WIP: Publica los assets de traducciones 
bash php artisan lang:publish
-->
**Construye los assets necesarios para la paginación en laravel usando tailwindcss o bootstrap:**

```bash php artisan vendor:publish --tag=laravel-pagination```

```
bash cd ../frontend
bash npm update
bash npm install
bash npm run build
```
### Inicia los contenedores Docker:

** Si construyes por primera vez, usa: **
```bash docker-compose up --build -d```

** Si ya construiste antes, usa: **
```bash docker-compose up -d```

La aplicación estará disponible en:

* **Backend:** http://localhost:8000
* **Frontend:** http://localhost:3000
* **MongoDB:** mongodb://user:pass@localhost:27017

### Instalación Manual

#### Clona el repositorio:
```
bash git clone <url-del-repositorio>
cd fitcoacher/backend
```
#### Instala las dependencias PHP:

```bash composer install```

#### Instala las dependencias Node y construye los assets:
```
bash npm install
bash npm run build
```
#### Configura tu conexión MongoDB en .env:
```
DB_CONNECTION=mongodb
DB_HOST=mongodb
DB_PORT=27017
DB_DATABASE=laraveldb
DB_USERNAME=app_root
DB_PASSWORD=1234
```
#### Genera la clave de aplicación:
```
bash php artisan key:generate
```
#### Ejecuta los seeders de la base de datos:
```
bash php artisan db:seed
```
#### Construye los assets del frontend:
```
bash npm run build
```
#### Construye el entorno y levántalo en modo “detach”
```
bash docker compose up —-build -d
```

## 📱 Endpoints de API

### Autenticación
```
POST /api/auth/register - Registro de usuario
POST /api/auth/login - Inicio de sesión
POST /api/auth/logout - Cerrar sesión (requiere auth)
GET /api/auth/user - Obtener usuario autenticado
```
### Ejercicios
```
GET /api/exercises - Listar todos los ejercicios
GET /api/exercises/{id} - Obtener detalles del ejercicio
GET /api/exercises/categories - Obtener categorías de ejercicios
```
### Entrenamientos (Requiere Autenticación)
```
GET /api/workouts - Listar entrenamientos del usuario 
POST /api/workouts - Crear nuevo entrenamiento
GET /api/workouts/today - Obtener entrenamiento de hoy
GET /api/workouts/{id} - Obtener detalles del entrenamiento
PUT /api/workouts/{id} - Actualizar entrenamiento
DELETE /api/workouts/{id} - Eliminar entrenamiento
```

### Artículos y Noticias
```
GET /api/articles - Listar artículos
GET /api/articles/{slug} - Obtener detalles del artículo
GET /api/news - Listar noticias
GET /api/news/breaking - Obtener noticias de última hora
```
### Estadísticas del Usuario (Requiere Autenticación)
```
GET /api/stats/dashboard - Obtener estadísticas del dashboard
GET /api/stats/progress - Obtener datos de progreso
```
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
```
Email: admin@fittracker.com
Contraseña: password
```

### Usuarios Regulares
```
Email: john@example.com
Contraseña: 1234
Email: jane@example.com
Contraseña: password123
```
## 🧪 Pruebas

Ejecuta el conjunto de pruebas:
```bash php artisan test```

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
```docker-compose up --build -d```

# Ver logs de todos los servicios
```docker-compose logs -f```

# Ver logs específicos
```
docker-compose logs -f mongodb
docker-compose logs -f backend
docker-compose logs -f frontend
```
# Parar todos los servicios
```docker-compose down```

# Parar y eliminar volúmenes (¡CUIDADO! Elimina datos de MongoDB)
```docker-compose down -v```

# Reconstruir un servicio específico
```docker-compose up --build backend```

# Ver estado de los servicios
```docker-compose ps```

# ===============================
# 3. COMANDOS MONGODB EN DOCKER
# ===============================

# Conectarse al contenedor de MongoDB
```docker exec -it mongodb bash```

# Conectarse directamente a MongoDB shell
```docker exec -it mongodb mongosh```

# Conectarse con autenticación
```docker exec -it mongodb mongosh -u admin -p admin123 --authenticationDatabase admin```

# Conectarse a la base de datos específica
```docker exec -it mongodb mongosh laraveldb -u user -p pass```

# Ejecutar comandos MongoDB desde host
```docker exec mongodb mongosh --eval "db.adminCommand('listCollections')" laraveldb```

# Crear backup de la base de datos
```docker exec mongodb mongodump --db laraveldb --out /data/backup```

# Restaurar backup
```docker exec mongodb mongorestore --db laraveldb /data/backup/laraveldb```

# ===============================
# 4. COMANDOS ÚTILES MONGODB
# ===============================

# Una vez dentro del MongoDB shell (mongosh):

# Mostrar bases de datos
```show dbs```

# Usar base de datos
```use laraveldb```

# Mostrar colecciones
```show collections```

# Ver usuarios
```db.getUsers()```

# Contar documentos
```
db.users.countDocuments()
db.exercises.countDocuments()
```
# Buscar todos los usuarios
```db.users.find().pretty()```

# Buscar usuario específico
```db.users.findOne({email: "admin@fittracker.com"})```

# Actualizar documento
```
db.users.updateOne(
  {email: "admin@fittracker.com"}, 
  {$set: {fitness_level: "expert"}}
)
```
# Eliminar documento
```db.users.deleteOne({email: "test@example.com"})```

# Ver estadísticas de la colección
```db.users.stats()```

# ===============================
# 5. COMANDOS LARAVEL EN DOCKER
# ===============================

# Acceder al contenedor del backend
```docker exec -it backend bash```

# Ejecutar comandos Artisan
```docker exec backend php artisan migrate```
```docker exec backend php artisan db:seed```
```docker exec backend php artisan config:clear```
```docker exec backend php artisan cache:clear```

# Instalar dependencias Composer
```docker exec backend composer install```

# Generar clave de aplicación
```docker exec backend php artisan key:generate```

# Ver rutas
```docker exec backend php artisan route:list```

# ===============================
# 6. COMANDOS REACT EN DOCKER
# ===============================

# Acceder al contenedor del frontend
```docker exec -it frontend sh```

# Instalar nuevas dependencias
```docker exec frontend npm install nueva-dependencia```

# Ver logs del frontend
```docker exec frontend npm run start```

# Construir para producción
```docker exec frontend npm run build```

# ===============================
# 7. DEBUGGING Y TROUBLESHOOTING
# ===============================

# Ver todos los contenedores
```docker ps -a```

# Ver uso de recursos
```docker stats```

# Inspeccionar un contenedor
```docker inspect mongodb```

# Ver logs de un contenedor específico
```docker logs backend --tail 50```

# Limpiar sistema Docker (¡CUIDADO!)
```docker system prune -a```

# Ver volúmenes
```docker volume ls```

# Inspeccionar volumen de MongoDB
```docker volume inspect mongodb_data```

# Ver redes
```docker network ls```

# Inspeccionar red
```docker network inspect new-project-network```

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

Attribution-ShareAlike 4.0 International

=======================================================================

Creative Commons Corporation ("Creative Commons") is not a law firm and
does not provide legal services or legal advice. Distribution of
Creative Commons public licenses does not create a lawyer-client or
other relationship. Creative Commons makes its licenses and related
information available on an "as-is" basis. Creative Commons gives no
warranties regarding its licenses, any material licensed under their
terms and conditions, or any related information. Creative Commons
disclaims all liability for damages resulting from their use to the
fullest extent possible.

Using Creative Commons Public Licenses

Creative Commons public licenses provide a standard set of terms and
conditions that creators and other rights holders may use to share
original works of authorship and other material subject to copyright
and certain other rights specified in the public license below. The
following considerations are for informational purposes only, are not
exhaustive, and do not form part of our licenses.

     Considerations for licensors: Our public licenses are
     intended for use by those authorized to give the public
     permission to use material in ways otherwise restricted by
     copyright and certain other rights. Our licenses are
     irrevocable. Licensors should read and understand the terms
     and conditions of the license they choose before applying it.
     Licensors should also secure all rights necessary before
     applying our licenses so that the public can reuse the
     material as expected. Licensors should clearly mark any
     material not subject to the license. This includes other CC-
     licensed material, or material used under an exception or
     limitation to copyright. More considerations for licensors:
    wiki.creativecommons.org/Considerations_for_licensors

     Considerations for the public: By using one of our public
     licenses, a licensor grants the public permission to use the
     licensed material under specified terms and conditions. If
     the licensor's permission is not necessary for any reason--for
     example, because of any applicable exception or limitation to
     copyright--then that use is not regulated by the license. Our
     licenses grant only permissions under copyright and certain
     other rights that a licensor has authority to grant. Use of
     the licensed material may still be restricted for other
     reasons, including because others have copyright or other
     rights in the material. A licensor may make special requests,
     such as asking that all changes be marked or described.
     Although not required by our licenses, you are encouraged to
     respect those requests where reasonable. More considerations
     for the public:
    wiki.creativecommons.org/Considerations_for_licensees

=======================================================================

Creative Commons Attribution-ShareAlike 4.0 International Public
License

By exercising the Licensed Rights (defined below), You accept and agree
to be bound by the terms and conditions of this Creative Commons
Attribution-ShareAlike 4.0 International Public License ("Public
License"). To the extent this Public License may be interpreted as a
contract, You are granted the Licensed Rights in consideration of Your
acceptance of these terms and conditions, and the Licensor grants You
such rights in consideration of benefits the Licensor receives from
making the Licensed Material available under these terms and
conditions.


Section 1 -- Definitions.

a. Adapted Material means material subject to Copyright and Similar
Rights that is derived from or based upon the Licensed Material
and in which the Licensed Material is translated, altered,
arranged, transformed, or otherwise modified in a manner requiring
permission under the Copyright and Similar Rights held by the
Licensor. For purposes of this Public License, where the Licensed
Material is a musical work, performance, or sound recording,
Adapted Material is always produced where the Licensed Material is
synched in timed relation with a moving image.

b. Adapter's License means the license You apply to Your Copyright
and Similar Rights in Your contributions to Adapted Material in
accordance with the terms and conditions of this Public License.

c. BY-SA Compatible License means a license listed at
creativecommons.org/compatiblelicenses, approved by Creative
Commons as essentially the equivalent of this Public License.

d. Copyright and Similar Rights means copyright and/or similar rights
closely related to copyright including, without limitation,
performance, broadcast, sound recording, and Sui Generis Database
Rights, without regard to how the rights are labeled or
categorized. For purposes of this Public License, the rights
specified in Section 2(b)(1)-(2) are not Copyright and Similar
Rights.

e. Effective Technological Measures means those measures that, in the
absence of proper authority, may not be circumvented under laws
fulfilling obligations under Article 11 of the WIPO Copyright
Treaty adopted on December 20, 1996, and/or similar international
agreements.

f. Exceptions and Limitations means fair use, fair dealing, and/or
any other exception or limitation to Copyright and Similar Rights
that applies to Your use of the Licensed Material.

g. License Elements means the license attributes listed in the name
of a Creative Commons Public License. The License Elements of this
Public License are Attribution and ShareAlike.

h. Licensed Material means the artistic or literary work, database,
or other material to which the Licensor applied this Public
License.

i. Licensed Rights means the rights granted to You subject to the
terms and conditions of this Public License, which are limited to
all Copyright and Similar Rights that apply to Your use of the
Licensed Material and that the Licensor has authority to license.

j. Licensor means the individual(s) or entity(ies) granting rights
under this Public License.

k. Share means to provide material to the public by any means or
process that requires permission under the Licensed Rights, such
as reproduction, public display, public performance, distribution,
dissemination, communication, or importation, and to make material
available to the public including in ways that members of the
public may access the material from a place and at a time
individually chosen by them.

l. Sui Generis Database Rights means rights other than copyright
resulting from Directive 96/9/EC of the European Parliament and of
the Council of 11 March 1996 on the legal protection of databases,
as amended and/or succeeded, as well as other essentially
equivalent rights anywhere in the world.

m. You means the individual or entity exercising the Licensed Rights
under this Public License. Your has a corresponding meaning.


Section 2 -- Scope.

a. License grant.

       1. Subject to the terms and conditions of this Public License,
          the Licensor hereby grants You a worldwide, royalty-free,
          non-sublicensable, non-exclusive, irrevocable license to
          exercise the Licensed Rights in the Licensed Material to:

            a. reproduce and Share the Licensed Material, in whole or
               in part; and

            b. produce, reproduce, and Share Adapted Material.

       2. Exceptions and Limitations. For the avoidance of doubt, where
          Exceptions and Limitations apply to Your use, this Public
          License does not apply, and You do not need to comply with
          its terms and conditions.

       3. Term. The term of this Public License is specified in Section
          6(a).

       4. Media and formats; technical modifications allowed. The
          Licensor authorizes You to exercise the Licensed Rights in
          all media and formats whether now known or hereafter created,
          and to make technical modifications necessary to do so. The
          Licensor waives and/or agrees not to assert any right or
          authority to forbid You from making technical modifications
          necessary to exercise the Licensed Rights, including
          technical modifications necessary to circumvent Effective
          Technological Measures. For purposes of this Public License,
          simply making modifications authorized by this Section 2(a)
          (4) never produces Adapted Material.

       5. Downstream recipients.

            a. Offer from the Licensor -- Licensed Material. Every
               recipient of the Licensed Material automatically
               receives an offer from the Licensor to exercise the
               Licensed Rights under the terms and conditions of this
               Public License.

            b. Additional offer from the Licensor -- Adapted Material.
               Every recipient of Adapted Material from You
               automatically receives an offer from the Licensor to
               exercise the Licensed Rights in the Adapted Material
               under the conditions of the Adapter's License You apply.

            c. No downstream restrictions. You may not offer or impose
               any additional or different terms or conditions on, or
               apply any Effective Technological Measures to, the
               Licensed Material if doing so restricts exercise of the
               Licensed Rights by any recipient of the Licensed
               Material.

       6. No endorsement. Nothing in this Public License constitutes or
          may be construed as permission to assert or imply that You
          are, or that Your use of the Licensed Material is, connected
          with, or sponsored, endorsed, or granted official status by,
          the Licensor or others designated to receive attribution as
          provided in Section 3(a)(1)(A)(i).

b. Other rights.

       1. Moral rights, such as the right of integrity, are not
          licensed under this Public License, nor are publicity,
          privacy, and/or other similar personality rights; however, to
          the extent possible, the Licensor waives and/or agrees not to
          assert any such rights held by the Licensor to the limited
          extent necessary to allow You to exercise the Licensed
          Rights, but not otherwise.

       2. Patent and trademark rights are not licensed under this
          Public License.

       3. To the extent possible, the Licensor waives any right to
          collect royalties from You for the exercise of the Licensed
          Rights, whether directly or through a collecting society
          under any voluntary or waivable statutory or compulsory
          licensing scheme. In all other cases the Licensor expressly
          reserves any right to collect such royalties.


Section 3 -- License Conditions.

Your exercise of the Licensed Rights is expressly made subject to the
following conditions.

a. Attribution.

       1. If You Share the Licensed Material (including in modified
          form), You must:

            a. retain the following if it is supplied by the Licensor
               with the Licensed Material:

                 i. identification of the creator(s) of the Licensed
                    Material and any others designated to receive
                    attribution, in any reasonable manner requested by
                    the Licensor (including by pseudonym if
                    designated);

                ii. a copyright notice;

               iii. a notice that refers to this Public License;

                iv. a notice that refers to the disclaimer of
                    warranties;

                 v. a URI or hyperlink to the Licensed Material to the
                    extent reasonably practicable;

            b. indicate if You modified the Licensed Material and
               retain an indication of any previous modifications; and

            c. indicate the Licensed Material is licensed under this
               Public License, and include the text of, or the URI or
               hyperlink to, this Public License.

       2. You may satisfy the conditions in Section 3(a)(1) in any
          reasonable manner based on the medium, means, and context in
          which You Share the Licensed Material. For example, it may be
          reasonable to satisfy the conditions by providing a URI or
          hyperlink to a resource that includes the required
          information.

       3. If requested by the Licensor, You must remove any of the
          information required by Section 3(a)(1)(A) to the extent
          reasonably practicable.

b. ShareAlike.

     In addition to the conditions in Section 3(a), if You Share
     Adapted Material You produce, the following conditions also apply.

       1. The Adapter's License You apply must be a Creative Commons
          license with the same License Elements, this version or
          later, or a BY-SA Compatible License.

       2. You must include the text of, or the URI or hyperlink to, the
          Adapter's License You apply. You may satisfy this condition
          in any reasonable manner based on the medium, means, and
          context in which You Share Adapted Material.

       3. You may not offer or impose any additional or different terms
          or conditions on, or apply any Effective Technological
          Measures to, Adapted Material that restrict exercise of the
          rights granted under the Adapter's License You apply.


Section 4 -- Sui Generis Database Rights.

Where the Licensed Rights include Sui Generis Database Rights that
apply to Your use of the Licensed Material:

a. for the avoidance of doubt, Section 2(a)(1) grants You the right
to extract, reuse, reproduce, and Share all or a substantial
portion of the contents of the database;

b. if You include all or a substantial portion of the database
contents in a database in which You have Sui Generis Database
Rights, then the database in which You have Sui Generis Database
Rights (but not its individual contents) is Adapted Material,
including for purposes of Section 3(b); and

c. You must comply with the conditions in Section 3(a) if You Share
all or a substantial portion of the contents of the database.

For the avoidance of doubt, this Section 4 supplements and does not
replace Your obligations under this Public License where the Licensed
Rights include other Copyright and Similar Rights.


Section 5 -- Disclaimer of Warranties and Limitation of Liability.

a. UNLESS OTHERWISE SEPARATELY UNDERTAKEN BY THE LICENSOR, TO THE
EXTENT POSSIBLE, THE LICENSOR OFFERS THE LICENSED MATERIAL AS-IS
AND AS-AVAILABLE, AND MAKES NO REPRESENTATIONS OR WARRANTIES OF
ANY KIND CONCERNING THE LICENSED MATERIAL, WHETHER EXPRESS,
IMPLIED, STATUTORY, OR OTHER. THIS INCLUDES, WITHOUT LIMITATION,
WARRANTIES OF TITLE, MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE, NON-INFRINGEMENT, ABSENCE OF LATENT OR OTHER DEFECTS,
ACCURACY, OR THE PRESENCE OR ABSENCE OF ERRORS, WHETHER OR NOT
KNOWN OR DISCOVERABLE. WHERE DISCLAIMERS OF WARRANTIES ARE NOT
ALLOWED IN FULL OR IN PART, THIS DISCLAIMER MAY NOT APPLY TO YOU.

b. TO THE EXTENT POSSIBLE, IN NO EVENT WILL THE LICENSOR BE LIABLE
TO YOU ON ANY LEGAL THEORY (INCLUDING, WITHOUT LIMITATION,
NEGLIGENCE) OR OTHERWISE FOR ANY DIRECT, SPECIAL, INDIRECT,
INCIDENTAL, CONSEQUENTIAL, PUNITIVE, EXEMPLARY, OR OTHER LOSSES,
COSTS, EXPENSES, OR DAMAGES ARISING OUT OF THIS PUBLIC LICENSE OR
USE OF THE LICENSED MATERIAL, EVEN IF THE LICENSOR HAS BEEN
ADVISED OF THE POSSIBILITY OF SUCH LOSSES, COSTS, EXPENSES, OR
DAMAGES. WHERE A LIMITATION OF LIABILITY IS NOT ALLOWED IN FULL OR
IN PART, THIS LIMITATION MAY NOT APPLY TO YOU.

c. The disclaimer of warranties and limitation of liability provided
above shall be interpreted in a manner that, to the extent
possible, most closely approximates an absolute disclaimer and
waiver of all liability.


Section 6 -- Term and Termination.

a. This Public License applies for the term of the Copyright and
Similar Rights licensed here. However, if You fail to comply with
this Public License, then Your rights under this Public License
terminate automatically.

b. Where Your right to use the Licensed Material has terminated under
Section 6(a), it reinstates:

       1. automatically as of the date the violation is cured, provided
          it is cured within 30 days of Your discovery of the
          violation; or

       2. upon express reinstatement by the Licensor.

     For the avoidance of doubt, this Section 6(b) does not affect any
     right the Licensor may have to seek remedies for Your violations
     of this Public License.

c. For the avoidance of doubt, the Licensor may also offer the
Licensed Material under separate terms or conditions or stop
distributing the Licensed Material at any time; however, doing so
will not terminate this Public License.

d. Sections 1, 5, 6, 7, and 8 survive termination of this Public
License.


Section 7 -- Other Terms and Conditions.

a. The Licensor shall not be bound by any additional or different
terms or conditions communicated by You unless expressly agreed.

b. Any arrangements, understandings, or agreements regarding the
Licensed Material not stated herein are separate from and
independent of the terms and conditions of this Public License.


Section 8 -- Interpretation.

a. For the avoidance of doubt, this Public License does not, and
shall not be interpreted to, reduce, limit, restrict, or impose
conditions on any use of the Licensed Material that could lawfully
be made without permission under this Public License.

b. To the extent possible, if any provision of this Public License is
deemed unenforceable, it shall be automatically reformed to the
minimum extent necessary to make it enforceable. If the provision
cannot be reformed, it shall be severed from this Public License
without affecting the enforceability of the remaining terms and
conditions.

c. No term or condition of this Public License will be waived and no
failure to comply consented to unless expressly agreed to by the
Licensor.

d. Nothing in this Public License constitutes or may be interpreted
as a limitation upon, or waiver of, any privileges and immunities
that apply to the Licensor or You, including from the legal
processes of any jurisdiction or authority.


=======================================================================

Creative Commons is not a party to its public
licenses. Notwithstanding, Creative Commons may elect to apply one of
its public licenses to material it publishes and in those instances
will be considered the “Licensor.” The text of the Creative Commons
public licenses is dedicated to the public domain under the CC0 Public
Domain Dedication. Except for the limited purpose of indicating that
material is shared under a Creative Commons public license or as
otherwise permitted by the Creative Commons policies published at
creativecommons.org/policies, Creative Commons does not authorize the
use of the trademark "Creative Commons" or any other trademark or logo
of Creative Commons without its prior written consent including,
without limitation, in connection with any unauthorized modifications
to any of its public licenses or any other arrangements,
understandings, or agreements concerning use of licensed material. For
the avoidance of doubt, this paragraph does not form part of the
public licenses.

Creative Commons may be contacted at creativecommons.org.
![](.\Logo_cc_by_sa.jpg "logo_cc_by_sa")