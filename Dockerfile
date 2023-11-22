FROM ubuntu:latest

# Imposta l'ambiente come non interattivo
ENV DEBIAN_FRONTEND noninteractive

# Installa Apache e PHP 8.0
RUN apt-get update && \
    apt-get install -y apache2 software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.0 libapache2-mod-php8.0

# Abilita PHP in Apache
RUN a2enmod php8.0

# Esporre la porta 80
EXPOSE 80

# Avvia Apache in modalità foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
