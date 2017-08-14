## 1. Download vendors
with Composer:

    php composer.phar install

## 2. Create the database:

    php bin/console doctrine:database:create

then create the table :

    php bin/console doctrine:schema:update --dump-sql
    php bin/console doctrine:schema:update --force

fill the data base :

    use the sql script 'todolist.sql'

## 3. How to configure virtual hosts on your localhost
### 1. we will create a virtual host under the name: "todolist.dev"
- in the repository *C:\Windows\System32\drivers\etc*; open “hosts” file with admin privileges and add the following to its end;
127.0.0.1 *todolist.dev* 
### 2.  allow virtual hosts in httpd.conf  
- ckick on wamp tray icon and Apache->httpd.conf  
-search for *# Include conf/extra/httpd-vhosts.conf* and comment it out (by deleting the # caracter): *Include conf/extra/httpd-vhosts.conf*  
- then at the bottom of the file add the *snowtricks* project like this:  
```
    <VirtualHost *:80>
	    ServerName todolist.dev
	    DocumentRoot C:/web/todolist/web
	    <Directory  "C:/web/todolist/web/">
    		Options +Indexes +Includes +FollowSymLinks +MultiViews
	    	AllowOverride All
		    Require local
	    </Directory>
    </VirtualHost>
```
- and restart the wamp services

