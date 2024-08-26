# Utilizar la imagen oficial de Drupal como base
FROM drupal:latest

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Crear la carpeta custom dentro de modules si no existe
RUN mkdir -p /var/www/html/modules/custom

# Copiar el módulo personalizado al contenedor
COPY ./web/modules/custom/test_module /var/www/html/modules/custom/test_module

# Instalar dependencias adicionales, si es necesario
# RUN apt-get update && apt-get install -y some-package

# Asegurarse de que Drupal tenga los permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80 para el servidor web
EXPOSE 80
