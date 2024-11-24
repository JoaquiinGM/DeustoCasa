FROM php:7.4-apache

# Instalar las extensiones necesarias para MySQL
#RUN docker-php-ext-install pdo pdo_mysql
# Instalar las extensiones necesarias para MySQLi
RUN docker-php-ext-install mysqli

# Exponer el puerto 80 para Apache
EXPOSE 80
