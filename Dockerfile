FROM ubuntu:latest

# Imposta l'ambiente come non interattivo
ENV DEBIAN_FRONTEND noninteractive

# Installa Apache, PHP 8.0, git e altri strumenti necessari
RUN apt-get update && \
    apt-get install -y apache2 software-properties-common git && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.0 libapache2-mod-php8.0 php8.0-xml php8.0-mbstring php8.0-zip curl

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clona il progetto Laravel da GitHub
RUN git clone https://github.com/ruffraff/HouseGreenYellow.git /var/www/html/house-green-yellow

# Imposta la directory di lavoro
WORKDIR /var/www/html/house-green-yellow

# Installa le dipendenze di Laravel
RUN composer install

# Assegna il proprietario alla directory del progetto
RUN chown -R www-data:www-data /var/www/html/house-green-yellow

# Abilita PHP in Apache e mod_rewrite
RUN a2enmod php8.0 rewrite

# Imposta il document root di Apache alla cartella public di Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/house-green-yellow/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Esporre la porta 80
EXPOSE 80

# Avvia Apache in modalità foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
