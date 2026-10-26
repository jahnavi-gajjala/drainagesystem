FROM php:8.3-apache
RUN docker-php-ext-install mysqli
COPY . /var/www/html/
CMD ["sh", "-c", "sed -ri \"s/Listen 80/Listen ${PORT:-10000}/\" /etc/apache2/ports.conf && sed -ri \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT:-10000}>/\" /etc/apache2/sites-available/000-default.conf && echo 'DirectoryIndex home.html' > /etc/apache2/conf-enabled/home.conf && apache2-foreground"]
