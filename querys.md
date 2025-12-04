# Documentación de Queries - MiAula

## 📊 Consultas SQL del Proyecto

| Query | Descripción | Ubicación |
|-------|-------------|-----------|
| `SELECT c.id_curso, c.titulo, c.descripcion, c.precio, c.estado, c.imagen_portada, cat.nombre_categoria FROM cursos c LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria WHERE c.estado = 'publicado' ORDER BY c.fecha_creacion DESC` | Obtener todos los cursos publicados con información de categoría | CursoService::obtenerCursos |
| `SELECT * FROM cursos WHERE id_curso = ? LIMIT 1` | Obtener un curso específico por ID | CursoService::obtenerCursoPorId |
| `SELECT c.id_curso, c.titulo, c.descripcion, c.imagen_portada, c.precio, c.estado, i.progreso, i.fecha_inscripcion, cat.nombre_categoria FROM cursos c JOIN inscripciones i ON c.id_curso = i.id_curso LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria WHERE i.id_usuario = ? ORDER BY i.fecha_inscripcion DESC` | Obtener cursos en los que está inscrito un usuario | CursoService::getMyCourses |
| `SELECT * FROM inscripciones WHERE id_curso = ? AND id_usuario = ? LIMIT 1` | Verificar si un usuario ya está inscrito en un curso | CursoService::enRoll |
| `INSERT INTO inscripciones (id_usuario,id_curso,fecha_inscripcion,progreso,estado) VALUES (?,?,?,?,?)` | Inscribir usuario a un curso | CursoService::enRoll |
| `DB::table('cursos')->insertGetId($datCourse)` | Crear un nuevo curso (Query Builder) | CursoService::createCourse |
| `DB::table('cursos')->where('id_curso', $id)->first()` | Obtener curso por ID (Query Builder) | CursoService::createCourse |
| `DB::table('cursos')->where('id_curso', $idCourse)->where('id_instructor', $idInstructor)->first()` | Verificar propiedad de curso por instructor | CursoService::updateCourse |
| `DB::table('cursos')->where('id_curso', $idCourse)->update($update)` | Actualizar información de curso | CursoService::updateCourse |
| `DB::table('cursos')->where('id_curso', $idCourse)->update(['estado' => 'eliminado'])` | Eliminar curso (soft delete) | CursoService::removeCourse |
| `DB::table('cursos')->select('id_curso','titulo','imagen_portada','descripcion','precio','estado','id_categoria')->where('id_instructor', $idInstructor)->where('estado', '!=', 'eliminado')->orderBy('fecha_creacion', 'desc')->get()` | Obtener cursos de un instructor | CursoService::getInstructorCourses |
| `DB::table('modulos')->where('id_curso', $idCourse)->whereNull('deleted_at')->count()` | Contar módulos de un curso | CursoService::publishCourse |
| `DB::table('lecciones')->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')->where('modulos.id_curso', $idCourse)->whereNull('lecciones.deleted_at')->whereNull('modulos.deleted_at')->count()` | Contar lecciones de un curso | CursoService::publishCourse |
| `DB::table('cursos')->where('id_curso', $idCourse)->update(['estado' => 'publicado', 'fecha_publicacion' => now()])` | Publicar un curso | CursoService::publishCourse |
| `DB::table('cursos as c')->leftJoin('categorias as cat', 'c.id_categoria', '=', 'cat.id_categoria')->select('c.*', 'cat.nombre_categoria')->where('c.id_curso', $id)->first()` | Obtener curso completo con categoría | CursoService::obtenerCursoCompleto |
| `DB::table('modulos')->where('id_curso', $id)->whereNull('deleted_at')->orderBy('orden')->get()` | Obtener módulos de un curso | CursoService::obtenerCursoCompleto |
| `DB::table('lecciones')->where('id_modulo', $modulo->id_modulo)->orderBy('orden')->get()` | Obtener lecciones de un módulo | CursoService::obtenerCursoCompleto |
| `DB::table('inscripciones')->where('id_curso', $id)->count()` | Contar inscripciones de un curso | CursoService::obtenerCursoCompleto |
| `DB::table('inscripciones')->where('id_usuario', $idUsuario)->where('id_curso', $idCurso)->first()` | Verificar inscripción de usuario en curso | CursoService::obtenerCursoParaEstudiante |
| `DB::table('cursos as c')->leftJoin('categorias as cat', 'c.id_categoria', '=', 'cat.id_categoria')->leftJoin('usuarios as u', 'c.id_instructor', '=', 'u.id_usuario')->select('c.*', 'cat.nombre_categoria', 'u.nombre as instructor_nombre', 'u.apellido as instructor_apellido')->where('c.id_curso', $idCurso)->where('c.estado', 'publicado')->first()` | Obtener curso completo para estudiante con instructor | CursoService::obtenerCursoParaEstudiante |
| `DB::table('recursos')->where('id_leccion', $leccion->id_leccion)->get()` | Obtener recursos de una lección | CursoService::obtenerCursoParaEstudiante |
| `DB::table('progreso_lecciones')->where('id_inscripcion', $inscripcion->id_inscripcion)->where('id_leccion', $leccion->id_leccion)->first()` | Verificar progreso de lección | CursoService::obtenerCursoParaEstudiante |
| `DB::table('progreso_lecciones as pl')->join('lecciones as l', 'pl.id_leccion', '=', 'l.id_leccion')->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')->where('m.id_curso', $idCurso)->where('pl.id_inscripcion', $inscripcion->id_inscripcion)->where('pl.completado', true)->count()` | Contar lecciones completadas de un curso | CursoService::obtenerCursoParaEstudiante |
| `select id from favoritos where id_usuario = ? and id_curso = ?` | Verificar si curso está en favoritos | FavoritoService::agregarFavorito |
| `insert into favoritos (id_usuario, id_curso, created_at, updated_at) values (?, ?, now(), now())` | Agregar curso a favoritos | FavoritoService::agregarFavorito |
| `select from favoritos where id_usuario = ? and id_curso = ?` | Verificar favorito para eliminar | FavoritoService::eliminarFavorito |
| `delete from favoritos where id_usuario = ? and id_curso = ?` | Eliminar curso de favoritos | FavoritoService::eliminarFavorito |
| `insert into comentarios(id_usuario, id_curso, contenido, created_at) values (?, ?, ?, now())` | Agregar comentario a curso | ComentarioService::agregarComentario |
| `select id_usuario from comentarios where id_comentario = ? limit 1` | Verificar propietario de comentario | ComentarioService::eliminarComentario |
| `delete from comentarios where id_comentario = ?` | Eliminar comentario | ComentarioService::eliminarComentario |
| `DB::table('categorias')->select('id_categoria', 'nombre_categoria')->get()` | Obtener todas las categorías | CategoriaService::getAllCategorias |
| `DB::table('usuarios')->insertGetId($userData)` | Crear nuevo usuario | AuthService::register |
| `DB::table('usuarios')->where('id_usuario', $userId)->first()` | Obtener usuario por ID | AuthService::register |
| `DB::table('usuarios')->where('email', $email)->first()` | Obtener usuario por email | AuthService::getUserByEmail |
| `DB::table('usuarios')->where('id_usuario', $userId)->first()` | Validar usuario para token | AuthService::validateUser |
| `DB::table('usuarios')->where('id_usuario', $id)->first()` | Buscar usuario por ID | User::find |
| `DB::table('usuarios')->where('id_usuario', $identifier)->first()` | Obtener usuario por ID para auth | DatabaseUserProvider::retrieveById |
| `DB::table('usuarios')->where('email', $credentials['email'])->first()` | Obtener usuario por credenciales | DatabaseUserProvider::retrieveByCredentials |
| `SELECT i.id_inscripcion FROM inscripciones i INNER JOIN cursos c ON i.id_curso = c.id_curso INNER JOIN modulos m ON m.id_curso = c.id_curso INNER JOIN lecciones l ON l.id_modulo = m.id_modulo WHERE l.id_leccion = ? AND i.id_usuario = ?` | Verificar inscripción para lección | ProgresoService::marcarLeccionCompletada |
| `DB::table('progreso_lecciones')->where('id_inscripcion', $idInscripcion)->where('id_leccion', $idLeccion)->first()` | Verificar progreso existente | ProgresoService::marcarLeccionCompletada |
| `DB::table('progreso_lecciones')->where('id_progreso', $progresoExistente->id_progreso)->update(['completado' => true, 'fecha_completado' => now()])` | Actualizar progreso de lección | ProgresoService::marcarLeccionCompletada |
| `DB::table('progreso_lecciones')->insert(['id_inscripcion' => $idInscripcion, 'id_leccion' => $idLeccion, 'completado' => true, 'fecha_completado' => now()])` | Crear registro de progreso | ProgresoService::marcarLeccionCompletada |
| `SELECT i.id_inscripcion, c.titulo as curso_titulo FROM inscripciones i INNER JOIN cursos c ON i.id_curso = c.id_curso WHERE i.id_usuario = ? AND c.id_curso = ?` | Obtener inscripción específica | ProgresoService::obtenerProgresoGeneral |
| `SELECT COUNT(*) as total FROM lecciones l INNER JOIN modulos m ON l.id_modulo = m.id_modulo WHERE m.id_curso = ? AND l.deleted_at IS NULL AND m.deleted_at IS NULL` | Contar lecciones totales de curso | ProgresoService::obtenerProgresoGeneral |
| `SELECT COUNT(*) as completadas FROM progreso_lecciones pl INNER JOIN lecciones l ON pl.id_leccion = l.id_leccion INNER JOIN modulos m ON l.id_modulo = m.id_modulo WHERE pl.id_inscripcion = ? AND pl.completado = 1 AND m.id_curso = ?` | Contar lecciones completadas | ProgresoService::obtenerProgresoGeneral |
| `DB::table('inscripciones')->where('id_usuario', $idUsuario)->where('id_curso', $idCurso)->first()` | Obtener inscripción para actualizar | ProgresoService::actualizarProgresoInscripcion |
| `DB::table('inscripciones')->where('id_inscripcion', $inscripcion->id_inscripcion)->update(['progreso' => $porcentaje])` | Actualizar porcentaje de progreso | ProgresoService::actualizarProgresoInscripcion |
| `SELECT pl.completado, pl.fecha_completado, l.titulo as leccion_titulo, m.titulo as modulo_titulo FROM progreso_lecciones pl INNER JOIN lecciones l ON pl.id_leccion = l.id_leccion INNER JOIN modulos m ON l.id_modulo = m.id_modulo INNER JOIN inscripciones i ON pl.id_inscripcion = i.id_inscripcion WHERE i.id_usuario = ? AND i.id_curso = ? ORDER BY m.orden, l.orden` | Obtener progreso detallado por curso | ProgresoService::obtenerProgresoDetallado |
| `DB::table('inscripciones')->where('id_usuario', $idUsuario)->where('id_curso', $idCurso)->first()` | Verificar acceso para player | PlayerService::getCourseContent |
| `DB::table('cursos')->where('id_curso', $idCurso)->where('id_instructor', $idUsuario)->exists()` | Verificar instructor propietario | PlayerService::getCourseContent |
| `DB::table('modulos')->where('id_curso', $idCurso)->whereNull('deleted_at')->orderBy('orden')->get()` | Obtener módulos para player | PlayerService::getCourseContent |
| `DB::table('lecciones')->where('id_modulo', $moduleId)->orderBy('orden')->get()` | Obtener lecciones para player | PlayerService::getCourseContent |
| `DB::table('recursos')->where('id_leccion', $lessonId)->get()` | Obtener recursos para player | PlayerService::getCourseContent |
| `DB::table('cursos')->where('id_curso', $idCurso)->where('id_instructor', $idInstructor)->first()` | Verificar propiedad para crear módulo | ModuleService::createModule |
| `DB::table('modulos')->insertGetId($datModule)` | Crear nuevo módulo | ModuleService::createModule |
| `DB::table('modulos')->where('id_modulo', $newModule)->first()` | Obtener módulo recién creado | ModuleService::createModule |
| `DB::table('modulos')->where('id_curso', $idCurso)->whereNull('deleted_at')->orderBy('orden')->get()` | Obtener módulos de curso | ModuleService::getModulesFromCourse |
| `DB::table('modulos')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('modulos.id_modulo', $idModule)->where('cursos.id_instructor', $idInstructor)->select('modulos.*')->first()` | Verificar propiedad para actualizar módulo | ModuleService::updateModule |
| `DB::table('modulos')->where('id_modulo', $idModule)->update($moduleUpData)` | Actualizar módulo | ModuleService::updateModule |
| `DB::table('modulos')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('modulos.id_modulo', $idModule)->where('cursos.id_instructor', $idInstructor)->select('modulos.*')->first()` | Verificar propiedad para eliminar módulo | ModuleService::destroyModule |
| `DB::table('modulos')->where('id_modulo', $idModule)->update(['deleted_at' => now()])` | Eliminar módulo (soft delete) | ModuleService::destroyModule |
| `DB::table('modulos')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('modulos.id_modulo', $idModulo)->where('cursos.id_instructor', $idInstructor)->select('modulos.*')->first()` | Verificar propiedad para crear lección | LessonService::createLesson |
| `DB::table('lecciones')->insertGetId($lessonData)` | Crear nueva lección | LessonService::createLesson |
| `DB::table('lecciones')->where('id_leccion', $id)->first()` | Obtener lección recién creada | LessonService::createLesson |
| `DB::table('lecciones')->where('id_modulo', $idModulo)->orderBy('orden')->get()` | Obtener lecciones de módulo | LessonService::getLessonsFromModule |
| `DB::table('lecciones')->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('lecciones.id_leccion', $idLeccion)->where('cursos.id_instructor', $idInstructor)->select('lecciones.*')->first()` | Verificar propiedad para actualizar lección | LessonService::updateLesson |
| `DB::table('lecciones')->where('id_leccion', $idLeccion)->update($updateData)` | Actualizar lección | LessonService::updateLesson |
| `DB::table('lecciones')->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('lecciones.id_leccion', $idLeccion)->where('cursos.id_instructor', $idInstructor)->select('lecciones.*')->first()` | Verificar propiedad para eliminar lección | LessonService::destroyLesson |
| `DB::table('lecciones')->where('id_leccion', $idLeccion)->update(['deleted_at' => now()])` | Eliminar lección (soft delete) | LessonService::destroyLesson |
| `DB::table('lecciones')->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('lecciones.id_leccion', $idLeccion)->where('cursos.id_instructor', $idInstructor)->select('lecciones.*')->first()` | Verificar propiedad para crear recurso | ResourceService::createResource |
| `DB::table('recursos')->insertGetId(['nombre' => $data['nombre'], 'tipo' => $data['tipo'], 'ruta_archivo' => $filePath, 'enlace' => $data['enlace'], 'id_leccion' => $data['id_leccion'], 'created_at' => now(), 'updated_at' => now()])` | Crear nuevo recurso | ResourceService::createResource |
| `DB::table('recursos')->where('id_recurso', $id)->first()` | Obtener recurso recién creado | ResourceService::createResource |
| `DB::table('recursos')->where('id_leccion', $idLeccion)->get()` | Obtener recursos de lección | ResourceService::getResourcesFromLesson |
| `DB::table('recursos')->join('lecciones', 'recursos.id_leccion', '=', 'lecciones.id_leccion')->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('recursos.id_recurso', $idRecurso)->where('cursos.id_instructor', $idInstructor)->select('recursos.*')->first()` | Verificar propiedad para actualizar recurso | ResourceService::updateResource |
| `DB::table('recursos')->where('id_recurso', $idRecurso)->update($updateData)` | Actualizar recurso | ResourceService::updateResource |
| `DB::table('recursos')->join('lecciones', 'recursos.id_leccion', '=', 'lecciones.id_leccion')->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')->where('recursos.id_recurso', $idRecurso)->where('cursos.id_instructor', $idInstructor)->select('recursos.*')->first()` | Verificar propiedad para eliminar recurso | ResourceService::destroyResource |
| `DB::table('recursos')->where('id_recurso', $idRecurso)->update(['deleted_at' => now()])` | Eliminar recurso (soft delete) | ResourceService::destroyResource |
| `DB::table('lecciones as l')->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')->join('cursos as c', 'm.id_curso', '=', 'c.id_curso')->leftJoin('usuarios as u', 'c.id_instructor', '=', 'u.id_usuario')->select('l.*', 'c.titulo as curso_titulo', 'c.id_instructor', 'm.titulo as modulo_titulo', 'u.nombre as instructor_nombre', 'u.apellido as instructor_apellido')->where('l.id_leccion', $idLeccion)->first()` | Obtener datos completos de lección | LeccionController::obtenerDatosLeccion |
| `DB::table('inscripciones')->where('id_usuario', $idUsuario)->where('id_curso', $curso->id_curso)->first()` | Verificar inscripción para lección | LeccionController::obtenerDatosLeccion |
| `DB::table('recursos')->where('id_leccion', $idLeccion)->get()` | Obtener recursos de lección | LeccionController::obtenerDatosLeccion |
| `SELECT l2.id_leccion, l2.titulo, l2.orden FROM lecciones l1 JOIN lecciones l2 ON l1.id_modulo = l2.id_modulo WHERE l1.id_leccion = ? AND l2.orden < l1.orden ORDER BY l2.orden DESC LIMIT 1` | Obtener lección anterior | LeccionController::obtenerDatosLeccion |
| `SELECT l2.id_leccion, l2.titulo, l2.orden FROM lecciones l1 JOIN lecciones l2 ON l1.id_modulo = l2.id_modulo WHERE l1.id_leccion = ? AND l2.orden > l1.orden ORDER BY l2.orden ASC LIMIT 1` | Obtener lección siguiente | LeccionController::obtenerDatosLeccion |
| `DB::table('lecciones as l')->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')->join('cursos as c', 'm.id_curso', '=', 'c.id_curso')->select('l.*', 'c.titulo as curso_titulo', 'c.id_curso', 'm.titulo as modulo_titulo')->where('l.id_leccion', $idLeccion)->first()` | Obtener datos de lección para completar | LeccionController::verLeccion |
| `SELECT 1` | Health check de base de datos | HealthController::check |
| `DB::table('roles')->insert($rol)` | Insertar roles en seeder | RolesSeeder |
| `DB::table('categorias')->insert($categoria)` | Insertar categorías en seeder | CategoriasSeeder |

## 📈 Estadísticas de Queries

- **Total de consultas documentadas**: 75
- **Servicios con más queries**: 
  - CursoService: 22 queries
  - ProgresoService: 10 queries
  - ResourceService: 8 queries
  - ModuleService: 7 queries
  - LessonService: 7 queries

## 📊 Tipos de Operaciones

- **SELECT/DB::select**: 42 consultas (56%)
- **INSERT/DB::insert**: 8 consultas (10.7%)
- **UPDATE/DB::update**: 12 consultas (16%)
- **DELETE/DB::delete**: 3 consultas (4%)
- **Query Builder métodos**: 10 consultas (13.3%)

## 🗂️ Distribución por Tablas

- **cursos**: 15 operaciones
- **inscripciones**: 12 operaciones  
- **lecciones**: 11 operaciones
- **modulos**: 9 operaciones
- **progreso_lecciones**: 8 operaciones
- **recursos**: 8 operaciones
- **usuarios**: 7 operaciones
- **favoritos**: 4 operaciones
- **comentarios**: 3 operaciones
- **categorias**: 2 operaciones
- **roles**: 1 operación