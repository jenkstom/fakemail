Create database valias
User valias
Assign a password
Create table mxaliases (see create.sql)

Update the following files with the correct user/pass/datbase/domain:

database.cnf
genfake.php
mysql-aliases.cf

Update the following with the correct domain name:

index.php
postfix-main.cf

Copy mysql-aliases.cf to /etc/postfix

Add lines similar to the ones postfix-main.cf to /etc/postfix/main.cf
You may need to remove the domain from other places, such as my_destination.

Add the line in cron to your root cron script. Or whichever user.

Create a folder /fakemail in you web root. Copy index.php and genfake.php into that folder.
Update owner / permissions for foder and files. Add a password in a .htaccess file.

You may need to install package postfix-mysql, php, php mysql, etc.

You can create passwords with the htpasswd program:

sudo htpasswd -c /etc/apache2/passwds myuser

sudo chown www-data.www-data /etc/apache2/passwds
