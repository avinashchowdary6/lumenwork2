FROM php:7.3-fpm-alpine
WORKDIR /var/www/html/
COPY crt.crt /usr/local/share/ca-certificates/my-cert.crt
RUN cat /usr/local/share/ca-certificates/my-cert.crt >> /etc/ssl/certs/ca-certificates.crt && \
    apk --no-cache add \
        curl
RUN docker-php-ext-install pdo_mysql
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
COPY . .
RUN composer install
RUN composer require illuminate/notifications
RUN composer require tymon/jwt-auth
RUN composer require illuminate/mail


