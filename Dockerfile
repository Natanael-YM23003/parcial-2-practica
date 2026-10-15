FROM debian:12

# Instalar Apache, PHP, extensiones de BD y herramientas necesarias
RUN apt update && apt install -y \
    apache2 \
    php \
    libapache2-mod-php \
    php-pgsql \
    php-mysql \
    php-cli \
    php-mbstring \
    php-xml \
    php-curl \
    php-zip \
    unzip \
    curl \
    nano \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Habilitar módulos de Apache
RUN a2enmod rewrite headers expires

# La entrada pública de la aplicación está dentro de src/public.
RUN sed -i 's#^[[:space:]]*DocumentRoot .*#\tDocumentRoot /var/www/html/src/public#' /etc/apache2/sites-available/000-default.conf \
    && printf '%s\n' '<Directory /var/www/html/src/public>' '    AllowOverride All' '    Require all granted' '</Directory>' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY composer.json ./
COPY src ./src
RUN composer dump-autoload

EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]