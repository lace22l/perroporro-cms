#podman build -t php_8_3 --build-arg http_proxy=http://10.82.26.50:8080 --build-arg https_proxy=http://10.82.26.50:8080 .
FROM php:8.3.8-fpm-alpine
# ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php Ya no hace falta
# la extension iconv ya viene incluida con la imagen de alpine desde la 8.1

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_DISABLE_XDEBUG_WARN=1 \
    PHPREDIS_VERSION=5.1.1
RUN set -xe \
  && apk add --no-cache --virtual .build-deps \
    tzdata \
    $PHPIZE_DEPS \
  && apk add gnu-libiconv --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted \
  && apk add --no-cache \
    openssl-dev \
    bash \
    nginx \
    curl \
    supervisor  \
    tzdata \
    zabbix-utils \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    sqlite-dev \
    curl-dev \
    libsodium-dev \
    icu-dev \
    libxml2-dev \
    recode-dev \
    libxslt-dev \
    git \
    postgresql-client \
    postgresql-dev \
    openssh-client \
    libmcrypt-dev \
    libmcrypt \
    libzip-dev \
    libgcrypt-dev \
    oniguruma-dev \
    && mkdir -p /run/nginx /run/mysqld /var/log/supervisor /etc/nginx/conf.d \
  && apk --update --no-cache add grep \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install \
    gd \
    bcmath \
    opcache \
    mysqli \
    pdo_mysql \
    pdo_pgsql \
    zip \
    xsl \
    intl \
    soap \
    bcmath \
    && apk del .build-deps \
  && rm -rf /tmp/* /var/cache/apk/*
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions sockets

COPY docker-config/php/php.ini /etc/php/8.3/fpm/conf.d/99-custom.ini
COPY docker-config/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker-config/nginx/templates/ /etc/nginx/templates/
COPY docker-config/nginx/templates/default.conf.template /etc/nginx/conf.d/default.conf
COPY docker-config/nginx/templates/upstream.conf.template /etc/nginx/conf.d/upstream.conf

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
WORKDIR /var/www
COPY . .
#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

#Install supervisor
#RUN mkdir /etc/supervisor.d/
#RUN apk update && apk add --no-cache supervisor
RUN chown nginx:nginx /var/www/public -R
# Set TimeZone
ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN ls -la /var/www
RUN rm -rf /var/www/var/data_dev.db


RUN /usr/bin/composer install
RUN /usr/local/bin/php bin/console doctrine:database:create
RUN /usr/local/bin/php bin/console bin/console doctrine:migrations:migrate
RUN chown -R www-data:www-data var/data_dev.db
RUN chmod -R 775  var/data_dev.db
EXPOSE 80

# Default command
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
