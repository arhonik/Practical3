FROM mysql:5.7

EXPOSE 3306

ADD ./mysql.cnf  /etc/mysql/conf.d/custom.cnf
RUN chmod 644 /etc/mysql/conf.d/custom.cnf

CMD ["mysqld"]
