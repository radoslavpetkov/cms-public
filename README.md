# cms-simple
This is a simple CMS system.

## Install instructions:
 - download repository
 - create database
 - import **/admin/install/cms-simple.sql** to the database
 - delete **/admin/install** folder
 - edit **/inc/config.php** and change accordingly to your system
 - edit **/admin/inc/config.php** and change accordingly to your system
 
 ### Admin login: admin/
  - user: admin
  - pass : admin
  
  **Please change password after first login!**
 
## Recover password
1. point your browser tp **admin/default_password.php**
2. copy **hash** string
3. in your database **UPDATE users SET password = "hash" WHERE id=1** 
