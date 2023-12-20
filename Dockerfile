FROM ubuntu:latest

# Set the environment as non-interactive
ENV DEBIAN_FRONTEND noninteractive

# Update and install Apache, PHP 8.0, git, and other necessary tools
RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y apache2 \
                       git \
                       php8.0 \
                       libapache2-mod-php8.0 \
                       php8.0-xml \
                       php8.0-mbstring \
                       php8.0-zip \
                       php8.0-curl \
                       php8.0-mysql \
                       curl

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clone the Laravel project from GitHub
RUN git clone https://github.com/ruffraff/HouseGreenYellow.git /var/www/html/house-green-yellow

# Set the working directory
WORKDIR /var/www/html/house-green-yellow

# Set the correct permissions for the Laravel project
RUN chown -R www-data:www-data /var/www/html/house-green-yellow

# Enable PHP in Apache and mod_rewrite
RUN a2enmod php8.0 rewrite

# Set the Apache document root to the Laravel public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/house-green-yellow/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose port 80
EXPOSE 80

# Start Apache in foreground mode
CMD ["apache2ctl", "-D", "FOREGROUND"]
