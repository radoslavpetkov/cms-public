<?php
define('SITE', TRUE);

//BAse URL
define('BASE_URL','/cms-simple');
define('ADMIN_BASE__URL', '/cms-simple/admin');
//Site name
define('SITE_NAME', 'CMS проект');

// File base path
define('SERVER_ROOT', 'C:/xampp/htdocs/');
define('SITE_ROOT', 'C:/xampp/htdocs/cms-simple/');
define('ADMIN_SITE_ROOT', 'C://xampp//htdocs//cms-simple//admin//');



//databese
define('DB_SERVER','localhost');
define('DB_USER', 'root');
define('DB_PASS','');
define('DB_DATABASE', 'cms_simle');

//Image upload limits

// Allowed image properties  
define('IMGSET', array( 
    'maxsize' => 2000, //in bites
    'maxwidth' => 3000, //in pixels
    'maxheight' => 2000, //in pixels
    'minwidth' => 10, //in pixels
    'minheight' => 10, //in pixels
    'type' => array('bmp', 'gif', 'jpg', 'jpeg', 'png') 
));
define('RENAME_F', 1);
