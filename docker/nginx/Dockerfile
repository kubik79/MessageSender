FROM nginx:1.25.2-alpine

ARG EXPOSE_PORT_ARG
ENV EXPOSE_PORT_ENV=$EXPOSE_PORT_ARG
ARG WORKDIR

RUN mkdir -p /srv/www
RUN mkdir -p /srv/www/public

RUN rm -rf /etc/nginx/conf.d/default.conf

COPY ./sites-enabled/       /etc/nginx/ext/sites-enabled/
COPY ./nginx.conf           /etc/nginx/

WORKDIR $WORKDIR

EXPOSE $EXPOSE_PORT_ENV
