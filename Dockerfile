FROM richarvey/nginx-php-fpm:latest

# Copiamos todo el código al servidor
COPY . /var/www/html

# Configuramos para que la web apunte a la carpeta 'public' de Laravel
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1

# Instalamos las dependencias (lo que harías con composer install)
RUN composer install --no-dev --optimize-autoloader

# Damos permisos a las carpetas de caché para que no pete
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache