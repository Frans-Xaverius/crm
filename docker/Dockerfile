FROM php:8.1-fpm-alpine3.15

# Copy composer.lock and composer.json
COPY composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install prerequisites required for tools and extensions installed later on.
RUN apk add --update bash gnupg libpng-dev libzip-dev su-exec unzip shadow nginx xvfb ttf-dejavu ttf-droid ttf-freefont ttf-liberation mysql-client

# Configurations wkhtmltopdf
# RUN ln -s /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf;
# RUN chmod +x /usr/local/bin/wkhtmltopdf;

# Install prerequisites for the sqlsrv and pdo_sqlsrv PHP extensions.
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.7.1.1-1_amd64.apk \
    && curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.7.1.1-1_amd64.apk \
    && curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.7.1.1-1_amd64.sig \
    && curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.7.1.1-1_amd64.sig \
    && curl https://packages.microsoft.com/keys/microsoft.asc  | gpg --import - \
    && gpg --verify msodbcsql17_17.7.1.1-1_amd64.sig msodbcsql17_17.7.1.1-1_amd64.apk \
    && gpg --verify mssql-tools_17.7.1.1-1_amd64.sig mssql-tools_17.7.1.1-1_amd64.apk \
    && apk add --allow-untrusted msodbcsql17_17.7.1.1-1_amd64.apk mssql-tools_17.7.1.1-1_amd64.apk \
    && rm *.apk *.sig

# Retrieve the script used to install PHP extensions from the source container.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

# Install required PHP extensions and all their prerequisites available via apt.
RUN chmod uga+x /usr/bin/install-php-extensions \
    && sync \
    && install-php-extensions bcmath ds exif gd intl opcache pcntl pdo_sqlsrv sqlsrv zip pdo pdo_mysql mysqli pgsql pdo_pgsql mbstring xml openssl json dom session zlib curl tokenizer xmlreader xmlwriter ctype bcmath sockets ldap

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Copy existing application directory permissions
ADD . /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 777 /var/www/html/storage/logs

# Copy PHP.INI
COPY docker/app/php.ini /usr/local/etc/php/

# Change current user to www
USER www-data

# Expose port 9000
EXPOSE 9000
