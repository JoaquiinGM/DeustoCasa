# Usar la imagen base de Apache
FROM httpd:latest

# Instalar Git
RUN apt-get update && apt-get install -y git

# Clonar el repositorio en un directorio temporal
RUN git clone -b main https://github.com/JoaquiinGM/DeustoCasa.git /tmp/DeustoCasa

# Limpiar el directorio predeterminado de Apache
RUN rm -rf /usr/local/apache2/htdocs/*

# Mover los archivos del repositorio al directorio de Apache
RUN mv /tmp/DeustoCasa/* /usr/local/apache2/htdocs/

# Limpiar archivos temporales
RUN rm -rf /tmp/DeustoCasa
# Exponer el puerto 80 para Apache
EXPOSE 80

# Comando para mantener el contenedor corriendo
CMD ["httpd-foreground"]
