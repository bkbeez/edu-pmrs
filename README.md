
# Performance Measurement Reporting System's Faculty of Education, Chiang Mai University #

## Environment ##
1. Create folder: ~/app/install
2. Create a file: ~/app/install/.htaccess
```
<IfModule mod_rewrite.c>
    Options -Indexes
</IfModule>
<Files .env> 
    Order Allow,Deny
    Deny from all
</Files>
```
3. Create a file: ~/app/install/.env
```
DB_DRIVER=mysql
DB_HOST=localhost
DB_NAME=mysql
DB_USER=
DB_PASS=
MAIL_HOST=
MAIL_POST=
MAIL_USER=
MAIL_PASS=
MAIL_SMTP=
MAIL_ADMIN=
MAIL_NOREPLY=no-reply-apiedu@cmu.ac.th
```