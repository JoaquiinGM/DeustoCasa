# Usar la imagen base de Apache
FROM httpd:latest

# Instalar Git
RUN apt-get update && apt-get install -y git

# Limpiar el directorio predeterminado de Apache
RUN rm -rf /usr/local/apache2/htdocs/*

# Clonar el repositorio directamente en el directorio de Apache
RUN git clone -b main https://github.com/JoaquiinGM/DeustoCasa.git /usr/local/apache2/htdocs/

# Mueve los archivos clonados al directorio de Apache
#RUN mv /usr/local/apache2/DeustoCasa/* /usr/local/apache2/htdocs/

# Exponer el puerto 80 para Apache
EXPOSE 80

# Comando para mantener el contenedor corriendo
CMD ["httpd-foreground"]
