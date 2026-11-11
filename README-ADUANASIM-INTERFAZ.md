# AduanaSim — Interfaz por perfiles (beta)

Esta entrega amplía la interfaz existente de AduanaSim. Conserva Laravel 13, Blade, Breeze, Alpine.js, Tailwind CSS y Vite, además de las dependencias que ya tenía el proyecto.

## Perfiles y navegación

- **Admin:** Resumen, Usuarios, Equipos, Módulos, Catálogos, Actividad y Mi perfil.
- **Agente:** Resumen, Por revisar, Validados, No validados, Historial y Mi perfil.
- **Capturista:** Resumen, Pedimentos, COVE, DODA, Mis documentos, Mi equipo y Mi perfil.

Los historiales, listados, indicadores y áreas de gestión muestran estados vacíos intencionales hasta que se implementen sus controladores y consultas.

## Requisitos

- PHP 8.3 o superior compatible con Laravel 13.
- Composer.
- Node.js y npm.
- MySQL (según la configuración del proyecto).

## Preparación después de extraer

```bash
cd AduanaSim
composer install
cp .env.example .env
php artisan key:generate
```

Configura las variables `DB_*` del archivo `.env` para tu base de datos MySQL. Si ya tienes una base de datos y migraciones ejecutadas, conserva tu `.env` actual y no vuelvas a ejecutar migraciones destructivas.

Instala y compila los recursos frontend:

```bash
npm install
npm run build
```

En desarrollo puedes ejecutar Vite y Laravel en terminales separadas:

```bash
npm run dev
php artisan serve
```

Si Laravel informa que falta `bootstrap/cache` o no puede escribir en `storage`, crea los directorios y ajusta la propiedad a tu usuario local:

```bash
mkdir -p bootstrap/cache storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
sudo chown -R "$USER:$(id -gn)" bootstrap/cache storage
chmod -R ug+rwX bootstrap/cache storage
```

## Importante: alcance de esta entrega

Esta versión implementa la **capa visual** y la navegación de pestañas por el campo `users.rol` (`admin`, `agente`, `capturista`). Los indicadores y listados todavía no consultan datos reales; los controles administrativos, la validación documental, los permisos de módulos y la colaboración por equipos aún no ejecutan operaciones de base de datos.

Ocultar una pestaña en la interfaz no constituye una medida de seguridad. Antes de habilitar funciones reales, cada operación deberá protegerse en backend mediante middleware, policies o gates y validaciones de propiedad/equipo. La revisión del agente será académica y los PDF/QR/códigos de barras deberán llevar identificación de simulación y la leyenda **DOCUMENTO SIN VALOR JURÍDICO**.

## Archivos principales modificados

- `resources/views/dashboard.blade.php`: navegación y paneles según rol.
- `resources/views/dashboard/partials/roles/`: resumen por perfil.
- `resources/views/dashboard/partials/estado-vacio.blade.php`: plantilla de estados vacíos.
- `resources/views/auth/login.blade.php`: inicio de sesión con identidad AduanaSim.
- `resources/views/welcome.blade.php`: página pública de bienvenida.
- `resources/views/layouts/guest.blade.php`: layout de autenticación.
- `resources/css/app.css`: componentes y estilos de la interfaz.
- `routes/web.php`: nombre de ruta `home` para la página de bienvenida.
