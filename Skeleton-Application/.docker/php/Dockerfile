FROM php:7.2.10-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip \
    gnupg gnupg1 gnupg2 \
    zlib1g-dev \
    libpng-dev \
    libxml2-dev \
    libxrender1 \
    libfontconfig1 \
    libx11-dev \
    libssl1.0-dev \
    libjpeg62 \
    libxtst6 \
    sudo \
    wget \
    optipng \
    jpegoptim \
    libexif-dev \
    && wget https://github.com/h4cc/wkhtmltopdf-amd64/blob/master/bin/wkhtmltopdf-amd64?raw=true -O /usr/local/bin/wkhtmltopdf \
    && wget https://github.com/h4cc/wkhtmltoimage-amd64/blob/master/bin/wkhtmltoimage-amd64?raw=true -O /usr/local/bin/wkhtmltoimage \
    && chmod +x /usr/local/bin/wkhtmltopdf \
    && chmod +x /usr/local/bin/wkhtmltoimage

RUN apt-get install openssl
RUN docker-php-ext-install pdo pdo_mysql zip xml gd exif soap

COPY php.ini /usr/local/etc/php/php.ini
COPY php-fpm-pool.conf 	/usr/local/etc/php/pool.d/www.conf

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer

RUN wget --no-check-certificate https://phar.phpunit.de/phpunit-6.5.3.phar && \
    mv phpunit*.phar phpunit.phar && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m
RUN passwd -d dev

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "pt_BR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN echo "dev ALL=(ALL) ALL" > /etc/sudoers

WORKDIR /home/wwwroot/

RUN mkdir -p var/cache
RUN chown -R www-data:www-data var/cache

RUN mkdir -p var/log
RUN chown -R www-data:www-data var/log
RUN chmod 777 -R var/log

RUN mkdir -p var/sessions
RUN chown -R www-data:www-data var/sessions

RUN mkdir -p var/cache/dev
RUN chown -R www-data:www-data var/cache/dev
RUN chmod 777 -R var/cache/dev

RUN mkdir -p var/cache/dev/profiler
RUN chown -R www-data:www-data var/cache/dev/profiler
RUN chmod 777 -R var/cache/dev/profiler

RUN mkdir -p web
RUN chown -R www-data:www-data web
RUN chmod 777 -R web

RUN mkdir -p web/img
RUN chown -R www-data:www-data web/img
RUN chmod 777 -R web/img

RUN mkdir -p web/uploads
RUN chown -R www-data:www-data web/uploads
RUN chmod 777 -R web/uploads

RUN mkdir -p vendor
RUN chown -R www-data:www-data vendor

WORKDIR /home/wwwroot

EXPOSE 9000