FROM ubuntu:latest

# Set the environment as non-interactive
ENV DEBIAN_FRONTEND noninteractive

# Update and install Nginx, PHP 8.1, git, and other necessary tools
RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y nginx \
                       git \
                       php8.1 \
                       php8.1-fpm \
                       php8.1-xml \
                       php8.1-mbstring \
                       php8.1-zip \
                       php8.1-curl \
                       php8.1-mysql \
                       curl

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clone the Laravel project from GitHub
RUN git clone https://github.com/ruffraff/HouseGreenYellow.git /var/www/house-green-yellow

# Set the working directory
WORKDIR /var/www/house-green-yellow

# Set the correct permissions for the Laravel project
RUN chown -R www-data:www-data /var/www/house-green-yellow

# Configure Nginx to use PHP-FPM
RUN sed -i 's/index index.html index.htm/index index.php index.html index.htm/g' /etc/nginx/sites-available/default
RUN echo "location ~ \\.php$ {\n\tfastcgi_pass unix:/var/run/php/php8.1-fpm.sock;\n\tfastcgi_index index.php;\n\tfastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;\n\tinclude fastcgi_params;\n}" >> /etc/nginx/sites-available/default

# Set the Nginx root to the Laravel public folder
ENV NGINX_ROOT /var/www/house-green-yellow/public
RUN sed -i 's!/usr/share/nginx/html!${NGINX_ROOT}!g' /etc/nginx/sites-available/default

# Expose port 80
EXPOSE 80

# Start Nginx and PHP-FPM in foreground mode
CMD service php8.1-fpm start && nginx -g 'daemon off;'

