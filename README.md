# Maxwell Experiences - Sistema de Gestión

Sistema web para la gestión de citas, reservaciones de paquetes y experiencias románticas.

## 📋 Características Principales

- **Gestión de Paquetes**: Creación y administración de paquetes de experiencias románticas.
- **Gestión de Citas**: Reservación, confirmación y seguimiento de citas para experiencias.
- **Gestión de Clientes**: Registro de información de las parejas o clientes individuales.
- **Dashboard Interactivo**: Estadísticas en tiempo real de citas pendientes, confirmadas y paquetes activos.

## 🚀 Requisitos

- **PHP**: 7.4 o superior
- **MySQL**: 5.7 o superior
- **Apache**: Con mod_rewrite habilitado
- **Extensiones PHP**: PDO, pdo_mysql, openssl

## 📦 Instalación

### Paso 1: Configurar Base de Datos

1. Inicie XAMPP (Apache y MySQL)
2. Abra phpMyAdmin en http://localhost/phpmyadmin
3. Ejecute el archivo `create_database.sql` o:
   - Cree la base de datos `maxwell_experiences`
   - Importe el archivo `create_database.sql`

### Paso 2: Configurar Conexión

Edite `config/database.php` si necesita cambiar las credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'maxwell_experiences');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Paso 3: Copiar Logo

Coloque el logo de la empresa en:
```
imagenes/logo Maxwell Experiences.png
```

### Paso 4: Acceder al Sistema

1. Abra su navegador y vaya a: `http://localhost/MaxwellExperiences2.0/`
2. Inicie sesión con las credenciales por defecto:

| Usuario | Contraseña | Rol |
|---------|------------|-----|
| admin | admin123 | Administrador |
| operador | admin123 | Operador |

**⚠️ IMPORTANTE**: Cambie las contraseñas inmediatamente después del primer acceso.

## 📁 Estructura de Directorios

```
MaxwellExperiences2.0/
├── config/
│   ├── database.php          # Configuración de BD
│   └── constants.php         # Constantes del sistema
├── includes/
│   ├── auth.php              # Autenticación y autorización
│   ├── helpers.php           # Funciones utilitarias
│   ├── header.php            # Cabecera común
│   ├── footer.php            # Pie de página común
│   └── user_menu.php         # Menú de usuario
├── modules/
│   ├── appointments/         # Gestión de citas y reservaciones
│   ├── packages/             # Paquetes de experiencias románticas
│   └── user_management/      # Gestión de usuarios del sistema
├── assets/
│   ├── css/style.css         # Estilos personalizados (animaciones de corazones)
│   ├── js/app.js             # JavaScript personalizado
│   └── images/               # Imágenes del sistema
├── imagenes/
│   └── logo Maxwell Experiences.png     # Logo de la empresa
├── index.php                 # Dashboard principal
├── login.php                 # Página de login con animaciones románticas
├── logout.php                # Cerrar sesión
└── create_database.sql       # Script de creación de BD
```

## 🔐 Seguridad

- **Contraseñas**: Hasheadas con bcrypt (password_hash)
- **CSRF**: Tokens en todos los formularios
- **SQL Injection**: Prepared statements en todas las consultas
- **XSS**: htmlspecialchars en todos los outputs
- **Sesiones**: Timeout de 30 minutos por inactividad
- **Roles**: Admin y Operator con permisos diferenciados

## 👥 Gestión de Usuarios

El **administrador principal** (admin) puede:
- Crear nuevos usuarios
- Asignar roles (Admin u Operador)
- Activar/desactivar usuarios
- Cambiar contraseñas de cualquier usuario
- Ver historial de accesos

| Rol | Permisos |
|-----|----------|
| **Admin** | Acceso completo a todos los módulos |
| **Operator** | Acceso operativo (no puede gestionar usuarios) |

## 📊 Módulos del Sistema

### 1. Paquetes de Experiencias
- Creación de paquetes románticos.
- Detalles del paquete, precios, duraciones.
- Estado activo/inactivo.

### 2. Citas y Reservaciones
- Registro de nuevas citas para parejas.
- Asignación de paquete y fecha/hora.
- Control de estado: Pendiente, Confirmada, Completada.

### 3. Usuarios
- Administración de acceso al sistema.

## 📱 Diseño Responsivo

El sistema utiliza Bootstrap 5.3 y es completamente responsivo:
- Funciona en desktop, tablet y móvil.
- Tema visual adaptado a experiencias románticas.

## 🐛 Solución de Problemas

### Error de conexión a la base de datos
- Verifique que MySQL esté ejecutándose en XAMPP
- Confirme las credenciales en `config/database.php`

### Las páginas no cargan
- Verifique que Apache esté ejecutándose
- Confirme que la URL sea correcta: `http://localhost/MaxwellExperiences2.0/`

## 📞 Soporte

Para soporte técnico o personalizaciones, contacte al administrador del sistema.

---

**© 2026 Maxwell Experiences**  
Citas y Experiencias Románticas
