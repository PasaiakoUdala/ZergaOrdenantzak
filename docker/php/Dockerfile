FROM php:5.6-fpm

ARG USER_ID=${USER_ID}
ARG GROUP_ID=${GROUP_ID}
ARG WITH_XDEBUG=${WITH_XDEBUG}
ARG DOCKER_TIMEZONE=${DOCKER_TIMEZONE}

RUN echo "Timezone => " ${DOCKER_TIMEZONE}
RUN echo "GROUP_ID => " ${GROUP_ID}
RUN echo "USER_ID => " ${USER_ID}
RUN echo " XDEBUG  => " ${WITH_XDEBUG}

# Configurar repositorios para Debian Stretch (EOL)
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list

# Instalación de todas las dependencias en un solo paso
RUN apt-get update && apt-get install -y --allow-unauthenticated \
    gnupg \
    locales \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libldap2-dev \
    && locale-gen es_ES.UTF-8 \
    && echo "LC_ALL=es_ES.UTF-8" >> /etc/environment \
    && echo "LANG=es_ES.UTF-8" >> /etc/environment \
    && echo "LC_ALL=es_ES.UTF-8" >> /etc/default/locale \
    && echo "LANG=es_ES.UTF-8" >> /etc/default/locale \
    && rm -rf /var/lib/apt/lists/*

# Configurar usuario www-data con los IDs proporcionados
RUN userdel -f www-data && \
    if getent group www-data ; then groupdel www-data; fi && \
    groupadd -g ${GROUP_ID} www-data && \
    useradd -l -u ${USER_ID} -g www-data www-data && \
    install -d -m 0755 -o www-data -g www-data /home/www-data && \
    echo 'www-data ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Configurar e instalar todas las extensiones PHP en un solo paso
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
       pdo \
       pdo_mysql \
       ldap \
       zip \
       xml \
       mbstring \
       gd \
       opcache

# Instalar Xdebug
RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug
COPY ./docker/php/conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Configurar timezone
RUN ln -snf /usr/share/zoneinfo/${DOCKER_TIMEZONE} /etc/localtime \
    && echo ${DOCKER_TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${DOCKER_TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Configurar límite de memoria
RUN echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/zerbikat.ini

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

WORKDIR /usr/src/app
COPY . /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
