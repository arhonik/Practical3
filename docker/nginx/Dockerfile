FROM nginx:1.17

RUN apt-get update

COPY nginx.conf /etc/nginx

VOLUME ["/var/www", "/etc/nginx/conf.d", "/var/log/nginx"]

WORKDIR /var/www

CMD ["/usr/sbin/nginx"]
