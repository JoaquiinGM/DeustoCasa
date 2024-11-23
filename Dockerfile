FROM php:7.4-apache

# Instalar las extensiones necesarias para MySQL
#RUN docker-php-ext-install pdo pdo_mysql
# Instalar las extensiones necesarias para MySQLi
RUN docker-php-ext-install mysqli

# Instalar Git
RUN apt-get update && apt-get install -y git

# Clonar el repositorio en un directorio temporal
RUN git clone -b main https://github.com/JoaquiinGM/DeustoCasa.git

# Exponer el puerto 80 para Apache
EXPOSE 80
