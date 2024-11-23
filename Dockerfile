# Usar la imagen base de Apache
FROM httpd:latest

# Instalar Git
RUN apt-get update && apt-get install -y git

# Clonar el repositorio desde GitHub en el directorio del sitio web
RUN git clone -b main https://github.com/JoaquiinGM/DeustoCasa.git ./htdocs

# Mueve los archivos clonados al directorio de Apache
RUN cp /usr/local/apache2/DeustoCasa/ /usr/local/apache2/htdocs/

# Exponer el puerto 80 para Apache
EXPOSE 80

# Comando para mantener el contenedor corriendo
CMD ["httpd-foreground"]
