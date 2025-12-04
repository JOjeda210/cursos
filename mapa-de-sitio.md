# Mapa de Sitio - MiAula

## 📋 Estructura del Sitio Web

### 🌍 Área Pública (Sin Autenticación)

#### **Navegación Principal**
```
Navbar Principal:
├── Logo: "MiPlataforma" (/)
├── Sobre nosotros (/)
├── Catálogo de cursos (/catalogos)
├── Promociones (/promociones)
├── Login (/login)
└── Registro (/registro)
```

#### **Páginas Públicas**

**1. Página Principal - Sobre Nosotros**
- **Ruta**: `/`
- **Vista**: `resources/views/client/about.blade.php`
- **Descripción**: Página de inicio con información de la plataforma
- **Acceso**: Público (sin JWT)

**2. Catálogo Público de Cursos**
- **Ruta**: `/catalogos`
- **Vista**: `resources/views/client/catalogo-publico.blade.php`
- **Descripción**: Lista de cursos disponibles para visitantes
- **Funcionalidades**:
  - Visualización de cursos publicados
  - Información básica sin acceso a contenido
  - Call-to-action para registro/login
- **Acceso**: Público (sin JWT)

**3. Promociones**
- **Ruta**: `/promociones`
- **Vista**: `resources/views/client/promociones.blade.php`
- **Descripción**: Ofertas y descuentos en cursos
- **Acceso**: Público (sin JWT)

**4. Iniciar Sesión**
- **Ruta**: `/login`
- **Vista**: `resources/views/client/login.blade.php`
- **Descripción**: Formulario de autenticación
- **Funcionalidades**:
  - Login con email/password
  - Validación JWT
  - Redirección post-login
- **Acceso**: Público (sin JWT)

**5. Registro de Estudiantes**
- **Ruta**: `/registro`
- **Vista**: `resources/views/client/registro.blade.php`
- **Descripción**: Formulario de registro para estudiantes
- **Funcionalidades**:
  - Registro como estudiante (rol_id = 2)
  - Validación de campos
  - Envío a API `/api/register`
- **Acceso**: Público (sin JWT)

**6. Registro de Instructores**
- **Ruta**: `/registro-instructor`
- **Vista**: `resources/views/client/registro-instructor.blade.php`
- **Descripción**: Formulario de registro para instructores
- **Funcionalidades**:
  - Registro como instructor (rol_id = 1)
  - Validación de credenciales
  - Envío a API `/api/register-instructor`
- **Acceso**: Público (sin JWT)

---

### 🔐 Área Privada (Con Autenticación JWT)

#### **Navegación Autenticada**
```
Navbar Privado:
├── Logo: "MiPlataforma" (/)
├── Sobre nosotros (/)
├── Catálogo de cursos (/catalogos)
├── Promociones (/promociones)
├── Mis cursos (/mis-cursos)
└── Cerrar sesión (logout)
```

#### **Páginas para Estudiantes**

**1. Catálogo Privado**
- **Ruta**: `/catalogo-privado`
- **Vista**: `resources/views/catalogo-private.blade.php`
- **Descripción**: Catálogo con funcionalidades completas para usuarios autenticados
- **Funcionalidades**:
  - Inscripción a cursos
  - Agregar/quitar favoritos
  - Comentarios y valoraciones
  - Ver detalles completos
- **Middleware**: `web.jwt`

**2. Mis Cursos**
- **Ruta**: `/mis-cursos`
- **Vista**: `resources/views/mis-cursos.blade.php`
- **Descripción**: Panel de cursos en los que está inscrito el estudiante
- **Funcionalidades**:
  - Lista de cursos inscritos
  - Progreso de cada curso
  - Acceso directo a lecciones
- **Middleware**: `web.jwt`

**3. Ver Curso (Estudiante)**
- **Ruta**: `/mis-cursos/{id}`
- **Vista**: `resources/views/ver_curso_estudiante.blade.php`
- **Controlador**: `CursoController::verCursoEstudiante`
- **Descripción**: Vista detallada del curso para estudiante inscrito
- **Funcionalidades**:
  - Estructura completa: Módulos → Lecciones → Recursos
  - Seguimiento de progreso
  - Navegación entre lecciones
- **Middleware**: `web.jwt`

**4. Ver Lección**
- **Ruta**: `/mis-cursos/{curso}/leccion/{leccion}`
- **Vista**: `resources/views/ver_leccion.blade.php`
- **Controlador**: `LeccionController::verLeccion`
- **Descripción**: Reproductor de lección individual
- **Funcionalidades**:
  - Contenido de la lección
  - Recursos multimedia
  - Marcar como completada
  - Navegación prev/next
- **Middleware**: `web.jwt`

---

### 🎓 Área de Instructor

#### **Navegación de Instructor**
```
Panel Instructor:
├── Cursos (/panel-instructor)
├── Módulos (/panel-instructor/modulos)
├── Lecciones (/panel-instructor/lecciones)
└── Recursos (/panel-instructor/recursos)
```

#### **Páginas del Panel de Instructor**

**1. Gestión de Cursos**
- **Ruta**: `/panel-instructor`
- **Vista**: `resources/views/panel_cursos.blade.php`
- **Descripción**: CRUD completo de cursos del instructor
- **Funcionalidades**:
  - Crear nuevos cursos
  - Editar cursos existentes
  - Publicar/despublicar
  - Eliminar cursos (soft delete)
  - Ver estadísticas básicas
- **Middleware**: `web.jwt`

**2. Gestión de Módulos**
- **Ruta**: `/panel-instructor/modulos`
- **Vista**: `resources/views/panel_modulos.blade.php`
- **Descripción**: CRUD de módulos dentro de cursos
- **Funcionalidades**:
  - Crear módulos por curso
  - Ordenar módulos
  - Editar información
  - Eliminar módulos
- **Middleware**: `web.jwt`

**3. Gestión de Lecciones**
- **Ruta**: `/panel-instructor/lecciones`
- **Vista**: `resources/views/lecciones.blade.php`
- **Descripción**: CRUD de lecciones dentro de módulos
- **Funcionalidades**:
  - Crear lecciones por módulo
  - Editor de contenido
  - Ordenar lecciones
  - Gestionar duración y descripción
- **Middleware**: `web.jwt`

**4. Gestión de Recursos**
- **Ruta**: `/panel-instructor/recursos`
- **Vista**: `resources/views/panel_recursos.blade.php`
- **Descripción**: CRUD de recursos multimedia por lección
- **Funcionalidades**:
  - Subir archivos (PDF, imágenes)
  - Enlaces de video
  - Enlaces externos
  - Organizar recursos por lección
- **Middleware**: `web.jwt`

**5. Ver Curso (Instructor)**
- **Ruta**: `/panel-instructor/cursos/{id}`
- **Vista**: `resources/views/ver_curso.blade.php`
- **Controlador**: `CursoController::verCurso`
- **Descripción**: Vista previa del curso como lo vería un estudiante
- **Funcionalidades**:
  - Preview completo del curso
  - Acceso sin inscripción
  - Validación de contenido
- **Middleware**: `web.jwt`

---

### 🔧 Endpoints de Sistema

#### **APIs y Servicios**

**1. Health Check**
- **Ruta**: `/helth`
- **Controlador**: `HealthController::check`
- **Descripción**: Endpoint para verificar estado del sistema
- **Respuesta**: Status de base de datos y servicios

**2. APIs REST**
- **Base**: `/api/`
- **Documentación**: Ver `routes/api.php`
- **Funcionalidades**:
  - Autenticación JWT
  - CRUD de cursos, módulos, lecciones, recursos
  - Gestión de inscripciones
  - Sistema de comentarios y favoritos
  - Player de contenido

---

### 🗂️ Componentes Reutilizables

#### **Componentes de Vista**

**1. Navegación Principal**
- **Archivo**: `resources/views/components/navbar.blade.php`
- **Funcionalidad**: Navbar adaptable según estado de autenticación

**2. Navegación de Instructor**
- **Archivo**: `resources/views/components/instructor-nav.blade.php`
- **Funcionalidad**: Submenu para panel de instructor

**3. Botón de Inscripción**
- **Archivo**: `resources/views/components/boton-inscribir.blade.php`
- **Funcionalidad**: Botón dinámico para inscripción a cursos

**4. Sistema de Comentarios**
- **Archivo**: `resources/views/components/comentarios.blade.php`
- **Funcionalidad**: Widget de comentarios con respuestas anidadas

---

### 🔄 Flujos de Usuario

#### **Flujo de Estudiante**
```
1. Landing (/) → 
2. Registro (/registro) → 
3. Login (/login) → 
4. Catálogo Privado (/catalogo-privado) → 
5. Inscripción a curso → 
6. Mis Cursos (/mis-cursos) → 
7. Ver Curso (/mis-cursos/{id}) → 
8. Ver Lección (/mis-cursos/{curso}/leccion/{leccion})
```

#### **Flujo de Instructor**
```
1. Landing (/) → 
2. Registro Instructor (/registro-instructor) → 
3. Login (/login) → 
4. Panel Instructor (/panel-instructor) → 
5. Crear Curso → 
6. Gestionar Módulos (/panel-instructor/modulos) → 
7. Crear Lecciones (/panel-instructor/lecciones) → 
8. Agregar Recursos (/panel-instructor/recursos) → 
9. Publicar Curso
```

---

### 📱 Responsive Design

- **Framework**: Bootstrap 5
- **Breakpoints**:
  - Mobile: 576px
  - Tablet: 768px  
  - Desktop: 992px+
- **Navegación móvil**: Hamburger menu en componente navbar
- **Grid adaptativo**: Cursos se ajustan a diferentes pantallas

---

### 🔒 Seguridad y Middleware

**1. Middleware Web JWT**
- **Archivo**: `app/Http/Middleware/WebJwtMiddleware.php`
- **Función**: Validar token JWT en localStorage para rutas privadas

**2. Protección de Rutas**
- **Públicas**: Sin middleware
- **Privadas**: `web.jwt` middleware
- **API**: `jwt.auth` middleware

**3. Validación de Roles**
- **Estudiante**: rol_id = 2
- **Instructor**: rol_id = 1
- **Validación en servicios y controladores**

---

### 📊 Métricas y Analytics

**Páginas con mayor tráfico esperado:**
1. Landing page (/)
2. Catálogo público (/catalogos)  
3. Login (/login)
4. Mis cursos (/mis-cursos)
5. Panel instructor (/panel-instructor)

**Conversiones clave:**
- Registro de estudiantes
- Inscripción a cursos
- Completado de lecciones
- Creación de cursos por instructores