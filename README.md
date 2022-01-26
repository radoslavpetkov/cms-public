# cms-simple
This is a simple CMS system.

## install instructions:
 - download repository
 - create database
 - import **/admin/install/cms-simple.sql** to the database
 - delete **/admin/install** folder
 - edit **/inc/config.php** and change accordingly to your system
 - edit **/admin/inc/config.php** and change accordingly to your system
 
## Change/recover password
- point your browser tp **admin/default_password.php**
- copy **hash** string
- in your database **UPDATE users SET password = "hash" WHERE id=1** 
