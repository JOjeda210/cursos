# Documentación del Sistema de Gestión de Cursos "MiAula"

## 1. CONTEXTO Y PROBLEMÁTICA

### 1.1 Situación Actual del Mercado Educativo

La reciente explosión digital y evolución acelerada de la industria tecnológica ha generado una **brecha de habilidades significativa** entre la formación académica tradicional y las necesidades reales del sector laboral. De manera histórica, los modelos de estudio no han hecho más que decrecer en comparación a la velocidad en la que la "Era Digital" ha ido evolucionando, esto ha dejado tanto a estudiantes como a profesionales con herramientas que no cuentan con la aplicabilidad necesaria para su uso en entornos de alta demanda.

Actualmente, la sociedad se encuentra con un nivel académico/laboral **hipercompetitivo** y una gran saturación de talento, lo que ha generado los siguientes problemas:

#### **Estancamiento Laboral**
En el ámbito laboral se ha encontrado un gran distanciamiento de oportunidades para ascender en las organizaciones para ciertos perfiles que no muestran actualizaciones en sus habilidades.

#### **"Barreras" al Egresar**
Los estudiantes egresados de universidades han enfrentado barreras en su transición de la escuela al mercado laboral debido a su falta de competencias/habilidades técnicas-específicas (hard skills) y blandas (soft skills).

#### **Habilidades Obsoletas**
Al no ser tan conocidas las plataformas para centralizar/optimizar el perfil profesional, se han ocasionado dificultades para abrirse paso y mantenerse relevante dentro del mismo mercado.

---

## 2. ANTECEDENTES Y JUSTIFICACIÓN DEL PROYECTO

### 2.1 Necesidad del Mercado

El proyecto **"MiAula"** nace de la creciente demanda de una **plataforma de cursos tipo LMS (Learning Management System)** accesible tanto para empresas como para el público en general. En un contexto donde:

- Las empresas requieren capacitación continua de su personal
- Los profesionales necesitan actualizar sus competencias de forma autónoma
- Las universidades y centros educativos buscan complementar su oferta académica
- El aprendizaje en línea se ha convertido en una necesidad, no solo una opción

Se identificó la necesidad de desarrollar una solución que democratice el acceso a educación de calidad, permitiendo:

1. **Para Empresas**: Capacitar a su personal de manera estructurada y medible
2. **Para Instructores**: Monetizar su conocimiento y crear comunidades de aprendizaje
3. **Para Estudiantes**: Acceder a contenido actualizado y aplicable al mercado real
4. **Para Instituciones**: Ampliar su alcance educativo más allá de las aulas físicas

### 2.2 Análisis de Soluciones Existentes

Si bien existen plataformas educativas en el mercado (Udemy, Coursera, Platzi), estas presentan limitaciones:

- **Costos elevados** para acceso premium
- **Contenido genérico** no adaptado a mercados específicos
- **Falta de flexibilidad** en la estructura de cursos
- **Dependencia de terceros** para organizaciones que desean su propia plataforma

"MiAula" surge como una alternativa que permite a organizaciones y profesionales tener **control total** sobre su plataforma educativa.

---

## 3. PROPUESTA DE SOLUCIÓN

### 3.1 "MiAula" - Sistema de Gestión de Cursos

**"MiAula"** se desarrolla como una solución de enseñanza electrónica (E-Learning) que se guía en criterios de mejora y "reciclaje" de habilidades obsoletas para orientarlas a un mejor uso/desenvolvimiento. El principal objetivo de "MiAula" es desarrollar tanto nuevas como "viejas" competencias (siendo esto clave para la falta de conocimiento académico "natural" y el "perfeccionismo" operativo).

### 3.2 Filosofía A.U.L.A

La plataforma se enfoca en la filosofía **A.U.L.A**, que busca calidad e integridad del contenido brindado. Dentro de este modelo se establecen los siguientes estándares:

#### **A - Actuales**
Contenido basado en las tendencias/necesidades del mercado laboral actual.

#### **U - Útiles**
Enfoque "pragmático" cuya finalidad es la aplicación inmediata de conocimientos.

#### **L - Lineales**
Curva de aprendizaje construida para evitar la dispersión cognitiva y garantizar progresión lógica.

#### **A - Auténticas**
Certificación para habilidades genuinas y verificables con valor curricular.

### 3.3 ¿Por Qué "MiAula" Resuelve el Problema?

La plataforma **"MiAula"** aborda efectivamente la brecha entre educación y empleabilidad por las siguientes razones:

#### **1. Autonomía y Personalización**
- **Solución Propia**: A diferencia de plataformas de terceros, "MiAula" permite a organizaciones tener su propia instancia de LMS, controlando completamente el contenido, usuarios y estructura.
- **Flexibilidad Total**: La arquitectura modular (Curso → Módulo → Lección → Recurso) permite diseñar rutas de aprendizaje personalizadas según las necesidades específicas de cada audiencia.

#### **2. Arquitectura Escalable y Moderna**
- **Tecnología Actual**: Desarrollada con Laravel (backend) y arquitectura REST API, garantiza escalabilidad y mantenibilidad.
- **Autenticación Robusta**: Sistema JWT que permite integraciones seguras con otros sistemas empresariales.
- **Soft Deletes**: Preservación de datos históricos para auditoría y recuperación.

#### **3. Gestión Integral de Contenido**
- **Estructura Jerárquica Clara**: Cursos → Módulos → Lecciones → Recursos permite organización lógica del conocimiento.
- **Multimedialidad**: Soporte para video, texto, PDF, imágenes y enlaces, cubriendo diferentes estilos de aprendizaje.
- **Seguimiento de Progreso**: Sistema de inscripciones y progreso de lecciones permite medir el avance real de los estudiantes.

#### **4. Modelo de Roles Diferenciado**
- **Instructores**: Pueden crear, gestionar y monetizar su conocimiento de forma autónoma.
- **Estudiantes**: Acceso a contenido estructurado con seguimiento de progreso.
- **Administradores**: Control total sobre la plataforma y sus usuarios.

#### **5. Enfoque en Aplicabilidad**
- **Contenido Práctico**: La filosofía A.U.L.A garantiza que el contenido sea actual y aplicable.
- **Validación de Competencias**: Sistema de valoraciones y comentarios permite evaluar la calidad real del contenido.
- **Interacción Comunidad**: Comentarios (incluyendo respuestas anidadas) fomentan el aprendizaje colaborativo.

#### **6. Economía y Accesibilidad**
- **Modelo Flexible de Precios**: Los cursos pueden ser gratuitos (precio 0.00) o de pago, democratizando el acceso.
- **Catálogo Público**: Cualquiera puede explorar la oferta educativa antes de registrarse.
- **Sistema de Favoritos**: Facilita que los estudiantes organicen su interés de aprendizaje.

#### **7. Trazabilidad y Medición**
- **Progreso Medible**: Sistema de progreso_lecciones permite tracking preciso del avance.
- **Valoraciones**: Sistema de puntuación 1-5 permite medir la efectividad del contenido.
- **Historial**: Registro de fecha de inscripción, fecha de completado, etc.

#### **8. Escalabilidad Empresarial**
- **Multi-tenancy Ready**: La arquitectura permite futuras implementaciones multi-tenant para SaaS.
- **API First**: Toda la funcionalidad expuesta vía API permite integraciones con sistemas externos (HRIS, ERP, etc.).
- **Modular**: Fácil agregar nuevas funcionalidades (quizzes, certificados, gamificación, etc.).

---

## 4. METODOLOGÍA DE DESARROLLO

### 4.1 Marco de Trabajo: SCRUM

El desarrollo de "MiAula" ha sido diseñado siguiendo la metodología **SCRUM**, un marco de trabajo ágil que permite gestionar proyectos complejos de forma iterativa e incremental.

#### **¿Qué es SCRUM?**

SCRUM es un framework de desarrollo ágil que divide el trabajo en **Sprints** (iteraciones de 1-4 semanas) donde se entrega software funcional al final de cada ciclo. Se basa en tres pilares fundamentales:

1. **Transparencia**: Todo el equipo conoce el estado del proyecto en todo momento
2. **Inspección**: Revisión constante del progreso y calidad
3. **Adaptación**: Capacidad de ajustar el rumbo según las necesidades

#### **Roles en SCRUM**

En el desarrollo de "MiAula" se definieron los siguientes roles:

- **Product Owner**: Define las funcionalidades y prioridades del producto
- **Scrum Master**: Facilita el proceso y elimina impedimentos
- **Development Team**: Equipo multifuncional que desarrolla el producto

### 4.2 Ventajas de SCRUM en el Proyecto

La implementación de SCRUM en "MiAula" proporcionó los siguientes beneficios:

#### **1. Desarrollo "Exponencial"**
- **Entregas Incrementales**: Cada Sprint entregó módulos funcionales completos del sistema
- **Estructura MVC**: La separación en Modelo-Vista-Controlador permitió trabajo paralelo del equipo
- **Feedback Temprano**: Cada iteración permitió validar funcionalidades con stakeholders

#### **2. Adaptabilidad**
- **Flexibilidad en Requerimientos**: Los cambios se incorporaron fácilmente al Product Backlog
- **Priorización Dinámica**: Las funcionalidades se priorizaron según valor de negocio
- **Respuesta Rápida**: Capacidad de pivotear ante nuevas necesidades del mercado

#### **3. Organización y Manejo**
- **Priorización Clara**: El Product Backlog ordenado permitió enfocarse en lo importante
- **Transparencia Total**: Daily Standups mantuvieron al equipo sincronizado
- **Retrospectivas**: Mejora continua del proceso en cada Sprint

#### **4. Calidad del Código**
- **Definition of Done**: Criterios claros de aceptación para cada funcionalidad
- **Code Reviews**: Revisión de código en cada Pull Request
- **Testing Continuo**: Validación funcional al final de cada Sprint

#### **5. Gestión de Riesgos**
- **Detección Temprana**: Los problemas se identifican en cada Sprint Review
- **Mitigación Ágil**: Los impedimentos se resuelven en tiempo real
- **Visibilidad**: El Sprint Burndown Chart muestra el progreso real

### 4.3 División de Issues y Gestión del Backlog

El desarrollo de "MiAula" se organizó mediante **User Stories** agrupadas en **Epics** (funcionalidades principales). A continuación se detalla cómo se dividieron las issues:

#### **Sprint 1 - Fundamentos y Autenticación**

| ID | Historia de Usuario | Responsable | Estado | Tipo |
|----|-------------------|-------------|--------|------|
| US-01 | Como usuario, quiero registrarme para poder crear mi cuenta | Backend | Aprobado | Privado |
| US-02 | Como usuario, quiero iniciar sesión para acceder a mi cuenta | Backend | Aprobado | Privado |
| US-03 | Como visitante, quiero ver cursos disponibles sin entrar | Backend | Aprobado | Público |
| BD-01 | Conexión y migraciones | Backend | Aprobado | Sistema |
| US-03 | Como visitante, quiero ver cursos disponibles sin entrar | Frontend | Aprobado | Público |
| US-04 | Ver información de Sobre Nosotros | Frontend | Aprobado | Público |
| US-05 | Ver cursos en oferta | Frontend | Aprobado | Público |

#### **Sprint 2 - Catálogo Privado y Funcionalidades de Estudiante**

| ID | Historia de Usuario | Responsable | Estado | Tipo |
|----|-------------------|-------------|--------|------|
| US-06 | Ver todos los cursos estando logueado | Backend | Aprobado | Privado |
| US-07 | Inscribirme a cursos | Backend | Aprobado | Privado |
| US-08 | Ver mis cursos inscritos | Backend | Aprobado | Privado |
| US-09 | Agregar/quitar cursos favoritos | Backend | Aprobado | Privado |
| US-10 | Comentar cursos | Backend | Aprobado | Privado |
| US-06 | Ver todos los cursos estando logueado | Frontend | Aprobado | Privado |
| US-07 | Inscribirme a cursos | Frontend | Aprobado | Privado |
| US-08 | Ver mis cursos inscritos | Frontend | Aprobado | Privado |
| US-10 | Comentar cursos | Frontend | Aprobado | Privado |
| NW-1 | Como usuario quiero poder navegar en la aplicación | Frontend | En desarrollo | Público |

#### **Sprint 3 - Panel de Instructor (CRUD Completo)**

| ID | Historia de Usuario | Responsable | Estado | Tipo |
|----|-------------------|-------------|--------|------|
| US-11 | Valoración de roles | Backend | Aprobado | Sistema |
| IN-01 | Agregar cursos | Backend | Aprobado | Privado - Instructor |
| IN-02 | Agregar módulos al curso | Backend | Aprobado | Privado - Instructor |
| IN-03 | Crear/editar lecciones del curso | Backend | Aprobado | Privado - Instructor |
| IN-01 | Agregar cursos | Frontend | Aprobado | Privado - Instructor |
| IN-02 | Agregar módulos al curso | Frontend | En desarrollo | Privado - Instructor |
| IN-03 | Crear/editar lecciones del curso | Frontend | En desarrollo | Privado - Instructor |
| DOC-01 | Documentación según la rúbrica | Frontend | En desarrollo | Documentación |

#### **Criterios de Priorización**

Las issues se priorizaron según el framework **MoSCoW**:

- **Must Have**: Autenticación, CRUD de cursos, visualización pública
- **Should Have**: Favoritos, comentarios, inscripciones
- **Could Have**: Valoraciones, progreso de lecciones
- **Won't Have (esta versión)**: Gamificación, certificados automatizados, pagos en línea

#### **Gestión de Sprints**

Cada Sprint siguió el siguiente ciclo:

1. **Sprint Planning**: Selección de User Stories del Product Backlog
2. **Daily Standup**: Sincronización diaria del equipo (15 min)
3. **Development**: Trabajo en las tareas asignadas
4. **Sprint Review**: Demostración de funcionalidades completadas
5. **Sprint Retrospective**: Análisis de qué mejorar en el próximo Sprint

#### **Herramientas Utilizadas**

- **GitHub Projects**: Gestión de issues y kanban board
- **Git Branches**: Feature branches para cada User Story
- **Pull Requests**: Code review antes de merge a develop
- **GitHub Actions**: CI/CD para validación automática (futuro)

---

## 5. OBJETIVOS DEL SISTEMA

### 5.1 Objetivo General

Desarrollar un sistema que permita gestionar cursos en línea, incluyendo la creación, edición y administración de cursos, módulos y lecciones, así como funcionalidades para el alumno y el administrador.

### 5.2 Objetivos Específicos

1. Implementar un sistema de autenticación robusto basado en JWT
2. Desarrollar un módulo de gestión de cursos con estructura jerárquica
3. Crear interfaces de usuario intuitivas para estudiantes e instructores
4. Implementar sistema de seguimiento de progreso de estudiantes
5. Desarrollar sistema de valoraciones y comentarios
6. Crear APIs RESTful para integración con sistemas externos
7. Garantizar seguridad y privacidad de datos de usuarios

---

## 6. ANÁLISIS DE REQUISITOS

### 6.1 REQUISITOS FUNCIONALES

#### **3.1 Navegación Pública**

- **RF-01**: El sistema debe permitir visualizar el apartado "Sobre nosotros"
- **RF-02**: El sistema debe mostrar el "Catálogo de cursos"
- **RF-03**: El sistema debe mostrar la sección de "Promociones"
- **RF-04**: El sistema debe permitir iniciar sesión mediante el apartado "Login"
- **RF-05**: El sistema debe permitir crear una cuenta mediante el apartado "Registro"

#### **3.2 Navegación Autenticada**

- **RF-06**: Cuando el usuario esté autenticado, se debe visualizar el apartado "Mis cursos"
- **RF-07**: Debe aparecer la opción "Cerrar sesión" para usuarios autenticados
- **RF-08**: El sistema debe ocultar las opciones de Login y Registro cuando el usuario esté autenticado
- **RF-09**: El sistema debe mostrar enlaces diferentes según el estado del usuario (logueado / no logueado)

#### **3.3 Gestión de Cursos**

- **RF-10**: El administrador debe poder crear cursos
- **RF-11**: El administrador debe poder editar información de un curso
- **RF-12**: El administrador debe poder eliminar cursos (soft delete)
- **RF-13**: Cada curso debe contener uno o varios módulos

#### **3.4 Gestión de Módulos**

- **RF-14**: El sistema debe permitir crear módulos dentro de un curso
- **RF-15**: El sistema debe permitir editar módulos ya existentes
- **RF-16**: El sistema debe permitir eliminar módulos (soft delete)
- **RF-17**: Cada módulo debe contener una o más lecciones

#### **3.5 Gestión de Lecciones**

- **RF-18**: El sistema debe mostrar una vista específica para administrar lecciones
- **RF-19**: Se debe poder crear nuevas lecciones dentro de un módulo
- **RF-20**: Se debe poder editar el contenido de una lección
- **RF-21**: Se debe poder eliminar una lección (soft delete)
- **RF-22**: Cada lección debe admitir contenido multimedia (texto, video, imágenes, PDFs)

#### **3.6 Gestión de Recursos**

- **RF-23**: El sistema debe permitir adjuntar recursos a las lecciones
- **RF-24**: Los recursos pueden ser de tipo: video, PDF, link, imagen
- **RF-25**: El sistema debe almacenar archivos en storage para tipos PDF e imagen
- **RF-26**: El sistema debe permitir editar y eliminar recursos

#### **3.7 Sistema de Inscripciones**

- **RF-27**: Los estudiantes deben poder inscribirse en cursos publicados
- **RF-28**: El sistema debe validar que un estudiante no se inscriba dos veces en el mismo curso
- **RF-29**: El sistema debe registrar la fecha de inscripción
- **RF-30**: El sistema debe permitir visualizar los cursos en los que está inscrito el estudiante

#### **3.8 Reproductor de Cursos**

- **RF-31**: El sistema debe proporcionar una vista de reproductor para estudiantes inscritos
- **RF-32**: El reproductor debe mostrar la estructura completa: Módulos → Lecciones → Recursos
- **RF-33**: El instructor del curso debe poder acceder al reproductor sin estar inscrito

#### **3.9 Sistema de Favoritos**

- **RF-34**: Los estudiantes deben poder agregar cursos a favoritos
- **RF-35**: El sistema debe validar que un curso no se agregue dos veces a favoritos
- **RF-36**: Los estudiantes deben poder eliminar cursos de favoritos

#### **3.10 Sistema de Comentarios**

- **RF-37**: Los usuarios autenticados deben poder comentar en cursos
- **RF-38**: Los comentarios deben permitir respuestas (estructura anidada)
- **RF-39**: Los usuarios deben poder eliminar sus propios comentarios
- **RF-40**: El sistema debe registrar la fecha y hora de cada comentario

#### **3.11 Control de Acceso**

- **RF-41**: El sistema debe validar si el usuario está autenticado mediante un token guardado en localStorage
- **RF-42**: Si el token es inválido o no existe, se deben mostrar únicamente las opciones públicas
- **RF-43**: El sistema debe redirigir al usuario al login al intentar acceder a áreas privadas sin autenticación
- **RF-44**: El sistema debe validar roles (Estudiante vs Instructor) para operaciones de gestión de cursos

---

### 6.2 REQUISITOS NO FUNCIONALES

#### **4.1 Usabilidad**

- **RNF-01**: La interfaz debe ser responsiva y adaptable a dispositivos móviles
- **RNF-02**: Los elementos visuales deben mantener coherencia estética en colores, fuentes y estructura
- **RNF-03**: La navegación debe ser clara y accesible
- **RNF-04**: Los formularios deben incluir validación del lado del cliente y servidor

#### **4.2 Rendimiento**

- **RNF-05**: Las vistas deben cargar en menos de 2 segundos en condiciones normales
- **RNF-06**: Las solicitudes AJAX deben minimizar recargas completas de página
- **RNF-07**: Las consultas a base de datos deben estar optimizadas (uso de índices en FK)
- **RNF-08**: El sistema debe soportar al menos 100 usuarios concurrentes

#### **4.3 Seguridad**

- **RNF-09**: Las rutas privadas deben estar protegidas mediante token JWT
- **RNF-10**: El sistema no debe permitir acceso a datos de cursos o lecciones sin autenticación válida
- **RNF-11**: Las contraseñas deben almacenarse encriptadas (bcrypt)
- **RNF-12**: El sistema debe implementar protección CSRF en formularios
- **RNF-13**: El sistema debe validar permisos de propiedad antes de operaciones de edición/eliminación

#### **4.4 Mantenibilidad**

- **RNF-14**: La arquitectura del sistema debe dividirse en componentes claros: Cursos, Módulos, Lecciones, Recursos
- **RNF-15**: El código debe ser modular y legible para facilitar futuras ampliaciones
- **RNF-16**: Debe implementarse separación de responsabilidades (Controllers, Services, Models)
- **RNF-17**: El código debe seguir estándares PSR-12 para PHP

#### **4.5 Disponibilidad**

- **RNF-18**: El sistema debe tener una disponibilidad del 99% mensual
- **RNF-19**: El sistema debe implementar manejo de errores y logs para debugging
- **RNF-20**: Debe existir un sistema de respaldos automáticos de la base de datos

#### **4.6 Escalabilidad**

- **RNF-21**: La arquitectura debe permitir escalamiento horizontal (múltiples instancias)
- **RNF-22**: El sistema debe estar diseñado para soportar crecimiento de usuarios sin refactorización mayor
- **RNF-23**: La base de datos debe soportar al menos 10,000 cursos y 100,000 usuarios

#### **4.7 Compatibilidad**

- **RNF-24**: El sistema debe funcionar en navegadores modernos (Chrome, Firefox, Safari, Edge)
- **RNF-25**: El sistema debe ser compatible con lectores de pantalla (accesibilidad)
- **RNF-26**: La API debe seguir estándares REST para facilitar integraciones

---

## 7. ARQUITECTURA DEL SISTEMA

### 7.1 Arquitectura General

El sistema "MiAula" sigue una **arquitectura de 3 capas**:

```
┌─────────────────────────────────────────┐
│     CAPA DE PRESENTACIÓN (Frontend)     │
│  - Vistas Blade                         │
│  - JavaScript (Vanilla)                 │
│  - Bootstrap 5.3.3                      │
└─────────────────┬───────────────────────┘
                  │ HTTP/REST
┌─────────────────▼───────────────────────┐
│     CAPA DE APLICACIÓN (Backend)        │
│  - Controllers (API + Web)              │
│  - Middleware (JWT Auth)                │
│  - Request Validation                   │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│     CAPA DE NEGOCIO (Services)          │
│  - AuthService                          │
│  - CursoService                         │
│  - ModuleService, LessonService, etc.   │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│     CAPA DE DATOS (Persistencia)        │
│  - MySQL Database                       │
│  - Query Builder (Laravel DB)           │
│  - Storage (archivos)                   │
└─────────────────────────────────────────┘
```

### 7.2 Tecnologías Utilizadas

#### **Backend**
- **Framework**: Laravel 12.36.1
- **Lenguaje**: PHP 8.4.13
- **Autenticación**: JWT (tymon/jwt-auth)
- **Base de Datos**: MySQL (prueba_db_laravel)

#### **Frontend**
- **Template Engine**: Blade
- **JavaScript**: Vanilla JS (ES6+)
- **CSS Framework**: Bootstrap 5.3.3
- **Iconos**: Bootstrap Icons

#### **Infraestructura**
- **Servidor Local**: Laravel Herd
- **Control de Versiones**: Git + GitHub
- **Metodología**: SCRUM

### 7.3 Modelo de Datos

El sistema utiliza las siguientes tablas principales:

- **roles**: Roles de usuario (1=Instructor, 2=Estudiante)
- **usuarios**: Información de usuarios
- **categorias**: Categorías de cursos
- **cursos**: Cursos principales
- **modulos**: Módulos dentro de cursos
- **lecciones**: Lecciones dentro de módulos
- **recursos**: Recursos multimedia de lecciones
- **inscripciones**: Relación estudiante-curso
- **progreso_lecciones**: Tracking de progreso
- **comentarios**: Comentarios en cursos
- **valoraciones**: Valoraciones de cursos
- **favoritos**: Cursos favoritos de usuarios

Para mayor detalle, consultar el archivo `diagramadoDocs.md` en el repositorio.

---

## 8. CONCLUSIONES

### 8.1 Logros Alcanzados

1. ✅ **Sistema funcional de gestión de cursos** con estructura jerárquica completa
2. ✅ **Autenticación JWT robusta** con diferenciación de roles
3. ✅ **API RESTful completa** para todas las operaciones CRUD
4. ✅ **Interfaz responsive** adaptable a múltiples dispositivos
5. ✅ **Metodología SCRUM** aplicada exitosamente con entregas incrementales

### 8.2 Impacto Esperado

"MiAula" tiene el potencial de:

- **Reducir la brecha** entre educación académica y necesidades laborales
- **Democratizar el acceso** a educación de calidad
- **Empoderar a instructores** para monetizar su conocimiento
- **Facilitar la capacitación continua** en organizaciones
- **Generar oportunidades** de crecimiento profesional

### 8.3 Trabajo Futuro

Para siguientes iteraciones se contemplan:

- [ ] Sistema de certificados automatizados
- [ ] Integración de pagos en línea (Stripe/PayPal)
- [ ] Gamificación (badges, puntos, rankings)
- [ ] Quizzes interactivos con evaluación automática
- [ ] Sistema de mensajería instructor-estudiante
- [ ] Analytics y reportes de progreso
- [ ] Implementación multi-tenant para SaaS
- [ ] App móvil nativa (React Native)

---

## 9. REFERENCIAS

- [Laravel Documentation](https://laravel.com/docs)
- [JWT-Auth Documentation](https://jwt-auth.readthedocs.io/)
- [SCRUM Guide](https://scrumguides.org/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/)
- Repositorio del proyecto: [GitHub - cursos](https://github.com/JOjeda210/cursos)

---

**Fecha de última actualización**: 27 de Noviembre, 2025  
**Versión del documento**: 1.0  
**Desarrollado por**: Equipo MiAula
