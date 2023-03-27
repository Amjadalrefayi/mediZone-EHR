FROM php:8.1-fpm

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && \
    apt-get install -y \
        git \
        sendmail \
        zlib1g-dev \
        libonig-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        ssh \
        nodejs \
        npm \
        rsync \
        libgtk2.0-0 \
        libgtk-3-0 \
        libgbm-dev \
        libnotify-dev \
        libgconf-2-4 \
        libnss3 \
        libxss1 \
        libasound2 \
        libxtst6 \
        xauth \
        xvfb \
        fonts-liberation \
        libappindicator3-1 \
        xdg-utils \
        mplayer \
        apt-utils \
        wget

RUN npm install -g npx

# Chrome
RUN wget -O /usr/src/google-chrome-stable_current_amd64.deb "https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb" && \
    dpkg -i /usr/src/google-chrome-stable_current_amd64.deb ; \
    apt-get install -f -y && \
    rm -f /usr/src/google-chrome-stable_current_amd64.deb

RUN docker-php-ext-install exif mbstring zip gd

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo zend_extension = "xdebug.so"
RUN echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.client_port=9002' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

