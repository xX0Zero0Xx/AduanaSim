# AduanaSim — Rediseño de interfaz (beta)

## Cambios incluidos

- Se conserva Laravel 13 y las dependencias existentes.
- Se mantiene Blade con vistas parciales y Alpine.js para el cambio de pestañas.
- Se incorpora el logotipo proporcionado en `public/images/aduanasim-logo.png`.
- Se actualiza la navegación superior y el menú de cuenta.
- Se rediseña el dashboard con la paleta visual de AduanaSim.
- Se conservan las pestañas Inicio, Pedimentos, COVE, DODA y Mi perfil.
- Se reorganizan los paneles de Pedimentos, COVE y DODA como espacios de trabajo en preparación.
- No se agregan dependencias nuevas ni se implementa todavía lógica de captura o validación.

## Paleta de interfaz

- Azul marino: `#233147`
- Azul petróleo: `#315A70`
- Turquesa: `#3D878E`
- Dorado: `#C3A96D`
- Gris azulado: `#71818B`
- Fondo claro: `#F4F6F7`

## Archivos principales modificados

- `resources/views/layouts/navigation.blade.php`
- `resources/views/dashboard.blade.php`
- `resources/views/dashboard/partials/inicio.blade.php`
- `resources/views/capturas/pedimento-captura.blade.php`
- `resources/views/capturas/cove-captura.blade.php`
- `resources/views/capturas/doda-captura.blade.php`
- `resources/css/app.css`
- `public/images/aduanasim-logo.png`
- `public/build/` (compilación actualizada)

## Compilar recursos

```bash
npm install
npm run build
```

## Ejecutar en desarrollo

```bash
php artisan serve
npm run dev
```

El ZIP compartido omite `.env`, `.git`, `vendor` y `node_modules` por seguridad y tamaño. Conserva `.env.example`; en el entorno local existente no reemplaces tu `.env`.
