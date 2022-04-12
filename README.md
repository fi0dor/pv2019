A Basic implementation of the MVC Design Pattern e-shop with PHP.

# Technology Stack 
* PHP (v7.0+) (Vanilla)
* MySQL 
* Javascript (JQuery Library)
 

#  Set Up Guide
1. Install MAMP development server. Open https://www.mamp.info/en/downloads/ and download the latest version according to your OS.
2. Configure MAMP server, especially set the default port of the virtual host (on Windows the default port is 80, on Mac 8888).
   For more details open https://documentation.mamp.info/en/MAMP-Mac/Preferences/Ports/
3. Enable the .htaccess processing by Apache. Open c:\MAMP\htdocs\conf\apache\httpd.conf and search for sequence '<Directory />'. In this section change 'AllowOverride' attribute from 'None' to 'All'. Restart MAMP servers.
4. Unzip the package to the document root folder (c:\MAMP\htdocs\)
5. Create a Mysql Database using any name (e.g. 'demo_store') you wish to use. For manipulating the database one can use the PHPMyAdmin tool.
6. Open up the 'constants.php' file within the config file and edit as desired.
7. Open your browser and fire up the tables_creator file. You can do that by using 
   localhost/tables_creator.php
8. If everything worked as planned, you should see a message informing you table was successfully created and dummy contents were inserted.
9. Install 'node.js' to your OS. Open nodejs.org/en/ and download LTS (Long Term Support) version.
   For more details open https://www.vzhurudolu.cz/prirucka/npm
10. Open command prompt/shell (e.g. cmd.exe) within the document root folder (e.g. c:\MAMP\htdocs\)
11. Type 'npm install' and hit Enter. Wait until all packages and dependencies will be installed.
12. Type 'gulp' which will run an automatic SASS compiler and hot reload browser-sync
13. Develop ;)