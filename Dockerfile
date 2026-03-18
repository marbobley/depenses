# Utilisation de l'image officielle FrankenPHP
FROM dunglas/frankenphp:1-php8.3

# Configuration de PHP
RUN install-php-extensions \
    pdo_mysql \
    intl \
    zip \
    opcache \
    apcu \
    ctype \
    iconv

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /app

# Configuration de Symfony
ENV SYMFONY_MODE=dev
ENV COMPOSER_ALLOW_SUPERUSER=1

# On copie d'abord les fichiers composer pour profiter du cache Docker
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copie du reste de l'application
COPY . .

# Finalisation de l'autoloader
RUN composer dump-autoload --optimize

# On peut spécifier le dossier public et utiliser le runtime Symfony
ENV FRANKENPHP_CONFIG="worker ./public/index.php"

# Exposition du port
EXPOSE 80
EXPOSE 443
EXPOSE 443/udp
