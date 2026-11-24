## AduanaSim

![imagen.](public/images/agnes.jpg)

## Como instalar el sistema de manera local

---

```bash
# clonar el repositorio
git clone https://github.com/xX0Zero0Xx/AduanaSim.git

# entrar al directorio del proyecto
cd AduanaSim

# instalar dependencias de composer
composer install

# instalar depencencias de npm
npm install
nmp run build

# crear llave de acceso
php artisan key:generate
```

![imagen](public/images/mambo.jpg)

---

## Configuracion de .env para pruebas locales

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=AduanaSim-Beta
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# ejecutar migraciones y seeders para la DB
php artisan migrate:fresh --seed

# ejecutar script npm para correr el programa con vite
npm run serve
```
