# ATM
A MVC Design pattern App using Vue.js and PHP to imitate the simulation of an ATM.
![VueATMApp](preview.gif?raw=true " ")
```
Requirements : php version : 7.4
```
## Installation of  Apache2 `mod_rewrite` in Linux 20.04:

### Step 1 — Enabling mod_rewrite

First, we need to activate  `mod_rewrite`. It’s available but not enabled with a clean Apache 2 installation.

```bash
sudo a2enmod rewrite
```
This will activate the module or alert you that the module is already enabled. To put these changes into effect, restart Apache.

```bash
sudo systemctl restart apache2
```

`mod_rewrite`  is now fully enabled. In the next step we will set up an  `.htaccess`  file that we’ll use to define rewrite rules for redirects.

### Step 2 — Setting Up .htaccess

An  `.htaccess`  file allows us to modify our rewrite rules without accessing server configuration files. For this reason,  `.htaccess`  is critical to your web application’s security. The period that precedes the filename ensures that the file is hidden.

We will need to set up and secure a few more settings before we can begin.

By default, Apache prohibits using an  `.htaccess`  file to apply rewrite rules, so first you need to allow changes to the file. Open the default Apache configuration file using  `nano`  or your favorite text editor.

```bash
sudo  nano /etc/apache2/sites-available/000-default.conf
```

Inside that file, you will find a  `<VirtualHost *:80>`  block starting on the first line. Inside of that block, add the following new block so your configuration file looks like the following. Make sure that all blocks are properly indented.

```bash
<VirtualHost *:80>
    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    . . .
</VirtualHost>
```

Save and close the file. To put these changes into effect, restart Apache.

```bash
sudo systemctl restart apache2
```

Now, create the  `.htaccess`  file in the web root.

```bash
sudo  nano /var/www/html/.htaccess
```
Add this line at the top of the new file to activate the rewrite engine.
`/var/www/html/.htaccess`

```bash
RewriteEngine on
```
Save the file and exit.

## Running the App :

### Step 1 — Setup MySQL Database

Go to your Terminal and type-in 

```
./Database/db_exec.sh
```
Enter your DBusername and DBPassword

### Step 2 — Change your `DBconnection.php`

Go to `sample-atm-app/Modules/Base/Model/Dbconnection.php` and change to your dbservername,username,dbpassword and dbname.

### Step 3— Go to Browser 
Go to Browser and type -in `127.0.0.1/YOUR-APP-NAME`
