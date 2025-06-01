# Sistema de Gestión de Tickets – Laravel 12

Sistema de soporte técnico desarrollado con Laravel 12. Permite a los usuarios crear tickets de ayuda, a los agentes gestionarlos según asignación, y a los administradores supervisar y administrar todo el sistema.

---

## Características Principales

### Gestión de Usuarios y Roles
- Autenticación de usuarios (registro, login, logout)
- Roles diferenciados:
  - **Usuario**: puede crear y seguir sus propios tickets
  - **Agente**: puede ver y gestionar solo los tickets asignados a él
  - **Administrador**: tiene acceso completo al sistema, incluyendo gestión de usuarios, agentes, categorías, y todos los tickets

### Gestión de Tickets
- Crear, editar y visualizar tickets
- Atributos del ticket:
  - Título
  - Descripción detallada
  - Archivos adjuntos
  - Estado: `abierto`, `en proceso`, `cerrado`
  - Prioridad: `baja`, `media`, `alta`
  - Categoría: configurable por el admin (e.g., Soporte Técnico, Facturación)
  - Usuario creador
  - Agente asignado (automáticamente o manualmente)

- **Asignación automática de tickets**:
  - Cuando se crea un ticket, el sistema asigna automáticamente un agente disponible.
  - Métodos posibles:
    - **Round-robin**: los tickets se asignan en orden rotativo entre los agentes.
    - **Menor carga**: el sistema asigna al agente con menos tickets abiertos o en proceso.

- **Reasignación manual**:
  - Los administradores pueden reasignar tickets a otros agentes desde el panel de administración si lo consideran necesario.


### Sistema de Conversaciones por Ticket
- Comunicación tipo "hilo" entre usuario y agente
- Cada mensaje puede tener texto y archivos adjuntos
- Marca de tiempo y autor de cada mensaje

### Panel de Administración y Agentes
- Vista general de tickets (según permisos del rol)
  - **Agentes**: ven solo los tickets asignados
  - **Administradores**: ven todos los tickets
- Filtros por estado, prioridad, categoría, usuario y agente
- Asignación automática inicial de tickets
- Reasignación manual de tickets por parte de administradores
- Gestión de categorías, usuarios y permisos (solo administradores)
- Estadísticas básicas:
  - Tickets abiertos/cerrados
  - Tickets por categoría o prioridad
  - Tiempo promedio de resolución

### Notificaciones
- Notificaciones por correo al crear, responder, cerrar un ticket

---

## Tecnologías Utilizadas

- **Laravel 12**
- **Laravel Breeze**
- **Livewire**
- **Tailwind CSS**
- **Spatie Laravel Permission**
- **Laravel Notifications**
- **Laravel File Storage**
- **Chart.js**
- Base de datos: **MySQL**

---

## Instalación y Ejecución

Sigue estos pasos para ejecutar el proyecto en tu entorno local:

### 1. Clonar el repositorio

```bash
git clone https://github.com/tudor-constantin/tickets-system.git
cd tickets-system
```

### 2. Instalar dependencias

```bash
composer install
npm install && npm run dev
```

### 3. Configurar archivo `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` y configura tus datos de conexión a la base de datos:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creará las tablas y cargará roles y usuarios de prueba si usas seeders.

### 5. Levantar el servidor de desarrollo

```bash
php artisan serve
```

Luego accedé a la app desde: http://localhost

---

## Accesos de prueba (incluidos por los seeders)

- **Administrador**
  - Email: `admin@example.com`
  - Contraseña: `password`

- **Agente**
  - Email: `agent@example.com`
  - Contraseña: `password`

- **Usuario**
  - Email: `user@example.com`
  - Contraseña: `password`
