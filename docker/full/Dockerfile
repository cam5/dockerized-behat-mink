FROM php:7.2-apache

RUN apt update && apt install vim git-core zip unzip less -y && apt clean

# Install MySQL and then purge to keep image size small-ish.
RUN apt update && apt install -y mysql-server php7.2-mysql/testing \
  && docker-php-ext-install pdo_mysql \
  && apt purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
  && apt remove -y --purge software-properties-common \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV COMPOSER_HOME /root/composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer

RUN sed -i 's/var\/www\/html/var\/www\/html\/web/g' /etc/apache2/sites-enabled/000-default.conf
  # ^ last one to make it conform to a symfony directory

ENV MYSQL_USER_NAME symfony
ENV MYSQL_USER_PASS symfony
  # We use these in the script that follows

ADD bootstrap.sh /bootstrap.sh
  # Starts Apache2 & sets up requisite MySQL user+db permissionss & drops you into a shell
RUN chmod +x /bootstrap.sh

ENTRYPOINT ["/bootstrap.sh"]
CMD []

