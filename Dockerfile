FROM dunglas/frankenphp:1.4-php8.4-alpine

# Set working directory
WORKDIR /app

# Install system dependencies and PHP extensions
RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    ctype \
    iconv \
    opcache \
    && apk add --no-cache \
    bash \
    git \
    netcat-openbsd

# Définition du répertoire de travail
WORKDIR /app

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie des fichiers du projet
COPY . /app

# Custom entrypoint
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

# On s'assure que le dossier public est bien utilisé comme racine du serveur
ENV SERVER_NAME=:80
ENV DOCUMENT_ROOT=/app/public

ENTRYPOINT ["docker-entrypoint"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]