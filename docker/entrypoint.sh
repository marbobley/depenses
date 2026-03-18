#!/bin/sh
set -e

# Attente de la base de données
if [ "$DATABASE_URL" != "" ]; then
    echo "Attente de la base de données..."
    # On extrait l'hôte et le port de DATABASE_URL
    # Format attendu: mysql://user:pass@host:port/db...
    DB_HOST=$(echo $DATABASE_URL | sed -r 's/.*@([^:]+):.*/\1/')
    DB_PORT=$(echo $DATABASE_URL | sed -r 's/.*:([0-9]+)\/.*/\1/')
    
    if [ -z "$DB_PORT" ]; then
        DB_PORT=3306
    fi
    
    echo "Hôte: $DB_HOST, Port: $DB_PORT"
    
    RETRIES=30
    until nc -z $DB_HOST $DB_PORT || [ $RETRIES -eq 0 ]; do
      echo "En attente de $DB_HOST:$DB_PORT... ($RETRIES tentatives restantes)"
      sleep 2
      RETRIES=$((RETRIES-1))
    done
fi

# Installation des dépendances composer si le dossier vendor n'existe pas
if [ ! -d "vendor" ]; then
    echo "Installation des dépendances composer..."
    composer install --no-interaction --optimize-autoloader
fi

# Exécution des migrations en dev
if [ "$APP_ENV" = "dev" ]; then
    echo "Exécution des migrations..."
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration || true
fi

exec "$@"
