FROM php:7.3-cli

ARG GITHUB_TOKEN

RUN apt-get update && apt-get upgrade -y

# PHP extensions and tools
RUN apt-get install -y --fix-missing libzip-dev zlib1g zlib1g-dev && docker-php-ext-configure zip --with-zlib-dir="/usr" && docker-php-ext-install zip
# Install git
RUN apt-get install -y --fix-missing git
# Add sudo
RUN apt-get install -y --fix-missing sudo

RUN rm /etc/apt/preferences.d/no-debian-php && apt-get update -yqq && apt-get install -y --fix-missing libxml2-dev php-soap
RUN docker-php-ext-install soap

COPY php.ini /usr/local/etc/php/

# Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN echo "export PATH=$HOME/.composer/vendor/bin:$PATH" >> /root/.bashrc

# Install tools
RUN apt-get install -y --fix-missing \
    dnsutils \
    telnet \
    sudo \
    vim-tiny \
    nano \
    dos2unix

WORKDIR /var/www/html

RUN mkdir /etc/skel/.composer
RUN addgroup --gid 1000 docker
RUN useradd --uid 1000 --gid 1000 -md /home/docker -s /bin/bash docker
RUN adduser docker www-data
COPY .bashrc_root /root/.bashrc
COPY php.ini /usr/local/etc/php/
COPY .bashrc_docker /home/docker/.bashrc
COPY sudo_docker /etc/sudoers.d/docker
# Configure composer tokens
RUN sudo -u docker composer config -g github-oauth.github.com ${GITHUB_TOKEN}

# Clean
RUN apt-get purge -y \
&& apt-get autoremove -y \
&& apt-get clean \
&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
