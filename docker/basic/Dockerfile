FROM php:7-apache

RUN apt update && apt install git-core zip unzip less -y && apt clean \
  && apt purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
  && apt remove -y --purge software-properties-common \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV COMPOSER_HOME /root/composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer

CMD /bin/bash
