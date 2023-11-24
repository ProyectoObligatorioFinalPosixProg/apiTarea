FROM mava13/imagenlaravel

WORKDIR /app

COPY . /app

RUN composer update && \
    composer install --no-scripts

RUN php artisan key:generate

EXPOSE 8001

CMD php artisan serve --host=0.0.0.0 --port=8001
