FROM php:7.3-cli

RUN apt-get update && apt-get -y upgrade && \
  apt-get install -y zlib1g-dev git
RUN curl -sS https://getcomposer.org/installer |php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["/app/.docker/entrypoint.sh"]

CMD ["php", "bin/console"]
