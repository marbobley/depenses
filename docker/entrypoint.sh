#!/bin/sh
set -e

# Wait for MySQL to be ready
if [ "$DATABASE_URL" != "" ]; then
    echo "Attente de la base de données..."
    # You might want a better wait-for-it script, but for now:
    # sleep 5 
fi

# Run Composer install if vendor doesn't exist (dev environment)
if [ ! -d "vendor" ]; then
    echo "Installation des dépendances composer..."
    composer install --no-interaction --optimize-autoloader
fi

# Run migrations (be careful in production, but okay for dev)
if [ "$APP_ENV" = "dev" ]; then
    echo "Exécution des migrations..."
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration || true
fi

exec "$@"
