FROM php:7.4-apache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip

RUN chmod -R a+r /var/www/html/
RUN chown -R www-data:www-data /var/www
COPY .htaccess .htaccess
EXPOSE 8080

