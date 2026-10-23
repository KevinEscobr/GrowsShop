#!/bin/sh
set -e

echo "[TiendaGrow] Starting initialization..."

cd /var/www/html

# 1. Asegurar directorios de almacenamiento y cache
mkdir -p storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache/data \
         storage/logs \
         bootstrap/cache

# 2. Corregir permisos para que www-data pueda escribir
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# 3. Asegurar que exista .env
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        echo "[TiendaGrow] .env not found. Copying from .env.example..."
        cp .env.example .env
    fi
fi

# 4. Asegurar que APP_KEY exista
if [ -f .env ]; then
    CURRENT_KEY=$(grep -E "^APP_KEY=" .env | cut -d '=' -f2-)
    if [ -z "$CURRENT_KEY" ]; then
        echo "[TiendaGrow] Generating application key..."
        php artisan key:generate --force || true
    fi
fi

# 5. Conectar a la base de datos y migrar si vendor está instalado
if [ -f vendor/autoload.php ]; then
    echo "[TiendaGrow] Waiting for MySQL database..."
    php -r '
    $attempts = 20;
    $host = getenv("DB_HOST") ?: "tiendagrow-db";
    $port = getenv("DB_PORT") ?: "3306";
    $user = getenv("DB_USERNAME") ?: "tiendagrow_user";
    $pass = getenv("DB_PASSWORD") ?: "";
    $db = getenv("DB_DATABASE") ?: "tiendagrow_db";
    while ($attempts > 0) {
        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [PDO::ATTR_TIMEOUT => 2]);
            echo "[TiendaGrow] Database connected successfully!\n";
            exit(0);
        } catch (\Exception $e) {
            $attempts--;
            sleep(1);
        }
    }
    echo "[TiendaGrow] Database not reachable yet, proceeding...\n";
    ' || true

    echo "[TiendaGrow] Running migrations..."
    php artisan migrate --force 2>/dev/null || true

    echo "[TiendaGrow] Checking if initial seeding is needed..."
    php -r '
    require "vendor/autoload.php";
    $app = require_once "bootstrap/app.php";
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    try {
        if (\App\Models\Product::count() === 0) {
            echo "[TiendaGrow] Seeding products catalog...\n";
            \Illuminate\Support\Facades\Artisan::call("db:seed", ["--force" => true]);
        }
    } catch (\Throwable $e) {}
    ' 2>/dev/null || true

    # Storage link para imágenes
    if [ ! -L public/storage ]; then
        php artisan storage:link --force 2>/dev/null || true
    fi

    # Limpiar caché obsoleta
    php artisan optimize:clear 2>/dev/null || true
fi

echo "[TiendaGrow] Initialization complete. Handing over to PHP-FPM..."
exec "$@"
