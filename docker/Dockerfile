FROM ruslankus/ub16_php71:v1

MAINTAINER ruslan.kiricenko@locatory.com


RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

#enable xdebug
RUN echo "xdebug.remote_enable=on" >> /etc/php/7.1/mods-available/xdebug.ini \
    && echo "xdebug.idekey='PHPSTORM'" >> /etc/php/7.1/mods-available/xdebug.ini \
    && echo 'xdebug.remote_handler="dbgp"' >> /etc/php/7.1/mods-available/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /etc/php/7.1/mods-available/xdebug.ini

RUN rm /etc/apache2/sites-available/000-default.conf \
 && rm /etc/apache2/sites-enabled/000-default.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY default.conf /etc/apache2/sites-enabled/default.conf

VOLUME /var/www

ENV TERM xterm
EXPOSE 22 80 3306

#ENTRYPOINT /usr/sbin/apache2ctl -D FOREGROUND
# By default start up apache in the foreground, override with /bin/bash for interative.
CMD usr/sbin/apache2ctl -D FOREGROUND

