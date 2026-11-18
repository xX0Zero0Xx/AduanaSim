# AduanaSim v3 — Auditoría y correcciones

## Correcciones aplicadas

- Alineación del namespace y ubicación del controlador de usuarios con PSR-4.
- Reubicación de `EnsureUserHasRole` al directorio `app/Http/Middleware`.
- Registro de middleware de roles y de cuenta activa en `bootstrap/app.php`.
- Middleware de cuenta activa: invalida la sesión si la cuenta está suspendida.
- Validación de cuenta suspendida durante el login.
- Registro público deshabilitado; las cuentas se crean desde administración.
- Contraseña individual al crear cuentas (mínimo 10 caracteres y confirmación), en lugar de contraseña compartida.
- Redirección centralizada al dashboard, pestaña Usuarios, para las operaciones de gestión.
- Modal de gestión de usuarios en dashboard: creación, información completa, edición, suspensión/reactivación y eliminación.
- Edición de la propia cuenta Admin habilitada; el rol Admin se conserva al editar su perfil.
- Eliminación de la propia cuenta Admin permitida solo si existe otro Admin activo; la sesión se cierra después de la eliminación.
- Protección contra suspensión, eliminación o degradación del último Admin activo.
- Migración `activo` para las instalaciones que aún no tengan el campo en `users`.
- Indicadores de la pantalla inicial Admin conectados a los conteos reales de usuarios por rol.
- Pestaña Usuarios carga la gestión real y conserva la pestaña tras redirecciones/errores de validación.
- Pruebas Feature agregadas para creación, edición propia, suspensión/eliminación del último Admin, autoeliminación con otro Admin y login de cuenta suspendida.
- Prueba de registro actualizada para reflejar que el registro público está deshabilitado.


## Cambios de gestión de usuarios

- **Crear:** nombre(s), apellido(s), rol y contraseña individual; correo institucional generado automáticamente.
- **Gestión completa:** muestra nombre, correo, rol, estado, fecha de registro y equipo(s) asignado(s).
- **Editar:** permite modificar nombre, correo y rol; Admin puede editar sus datos sin perder el rol Admin.
- **Suspender/reactivar:** confirmación modal; la cuenta suspendida no puede autenticarse ni continuar con una sesión existente.
- **Eliminar:** confirmación modal; elimina la cuenta y la desvincula de equipos. Admin puede eliminarse a sí mismo, con protección para no dejar al sistema sin Admin activo.


## Pasos para aplicar en la instalación local

1. Respaldar la base de datos y el proyecto actual.
2. Copiar los archivos corregidos sobre el proyecto local (conservar el `.env` local; no se incluye en el paquete por seguridad).
3. Instalar dependencias si hace falta: `composer install`.
4. Aplicar la migración: `php artisan migrate`.
5. Reconstruir assets si hace falta: `npm install` y `npm run build`.
6. Probar la gestión desde una cuenta Admin: crear, abrir gestión completa, editar, suspender/reactivar, eliminar otra cuenta y editar la propia.
7. Probar la autoeliminación con dos Admin activos; intentar eliminar al último Admin y confirmar que se bloquea.


## Validación realizada en el entorno de análisis

- Sintaxis PHP de los archivos modificados y nuevos comprobada.
- Autoload de controlador y middleware comprobado.
- Compilación Blade de 39 vistas comprobada; sintaxis PHP de las vistas compiladas comprobada.
- PHPUnit no pudo ejecutarse en este entorno porque faltan extensiones PHP (`dom`, `mbstring`, `xmlwriter`) y PDO SQLite. Por tanto, los flujos de base de datos y HTTP aún deben validarse en la instalación local con esas extensiones.
- No se afirma que las pruebas funcionales hayan pasado; se agregaron para ejecutarlas en el entorno local.

## Nota de seguridad

El ZIP de entrega excluye `.env`, `.git`, `vendor`, `node_modules` y vistas compiladas. Mantén el `.env` local y no compartas credenciales. Si las credenciales de tu archivo `.env` anterior se han distribuido, cámbialas.
