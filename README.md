# VIP2Cars - Proyecto Laravel

Proyecto Laravel para gestión de VIP2Cars.

---

## 🔧 Requisitos del entorno

Antes de instalar, asegúrate de tener:

- **PHP:** 8.1 o superior  
- **Composer:** 2.x  
- **Base de datos:** MySQL 8.0+ o MariaDB 10.5+  
- **Extensiones PHP necesarias:**
  - OpenSSL  
  - PDO  
  - Mbstring  
  - Tokenizer  
  - XML  
  - Ctype  
  - JSON  
  - BCMath  
- **Node.js y npm** (opcional, si usas Vite/compilación de assets)

---

## 🧰 Instalación y configuración

1. Clonar el repositorio:

```bash
git clone https://github.com/usuario/repositorio.git
cd nombre-del-proyecto
```

2. Instalar dependencias de PHP:

```bash
composer install
```

3. Copiar archivo de variables de entorno:

```bash
cp .env.example .env
```

4. Configurar variables de entorno en `.env`:

```env
APP_NAME=VIP2Cars
APP_ENV=local
APP_KEY=base64:GENERADA_POR_LARAVEL
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vip2cars
DB_USERNAME=root
DB_PASSWORD=secret
```

5. Generar la clave de la aplicación:

```bash
php artisan key:generate
```

---

## ▶️ Puesta en marcha

1. Levantar servidor de desarrollo:

```bash
php artisan serve
```

2. Compilar assets (si aplica):

```bash
npm install
npm run dev
```

3. Acceder al proyecto en el navegador:

```
http://localhost:8000
```

---

## 🗄️ Estructura de la base de datos

La base de datos puede crearse mediante migraciones o importando el script SQL:

- Migraciones:

```bash
php artisan migrate
```

- Script SQL (si prefieres importarlo en phpMyAdmin o MySQL Workbench):

```
/database/sql/vip2cars.sql
```

Estructura básica:

- `users` → usuarios del sistema  
- `clientes` → información de clientes  
- `vehiculos` → datos de vehículos  
- `ventas` → registros de ventas  
- `pagos` → información de pagos y facturación

*(Agregar más tablas según tu proyecto)*

---

## 📝 Notas

- Recuerda ajustar permisos de almacenamiento y bootstrap/cache:

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

- Para actualizar dependencias futuras:

```bash
composer update
npm update
```

