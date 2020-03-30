FROM php:7.2-apache

# Install dependencies
# PS: individual RUN blocks allow individual caches, in case some of them fail
RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y zlib1g-dev
RUN apt-get install -y libmcrypt-dev libreadline-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libpng-dev

# Install the extensions themselves
RUN docker-php-ext-install pdo_mysql	&& docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install mysqli		&& docker-php-ext-enable mysqli
RUN pecl install xdebug					&& docker-php-ext-enable xdebug
RUN pecl install mcrypt-1.0.1			&& docker-php-ext-enable mcrypt
RUN docker-php-ext-install zip			&& docker-php-ext-enable zip
RUN docker-php-ext-install gd			&& docker-php-ext-enable gd

# Enable Apache modules
RUN a2enmod rewrite

# Restart Apache
#RUN apachectl restart

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer