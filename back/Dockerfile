FROM php:8.0.5

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /back

COPY . .

RUN composer install
RUN composer run post-autoload-dump
RUN composer run post-root-package-install
RUN composer run post-create-project-cmd

EXPOSE 8000

CMD ["php","artisan","serve", "--host=0.0.0.0", "--port=8000 "]