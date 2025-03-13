<?php

define('DB_HOST', 'localhost'); 
define('DB_PORT', 3306);
define('DB_DATABASE', 'dbtest'); 
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('JWT_SECRET_KEY', '6d8HbcZndVGNAbo4Ih1TGaKcuA1y2BKs-I5CmP'); // Change cette clé pour plus de sécurité
define('JWT_ISSUER', 'http://localhost:8080');
define('JWT_EXPIRATION_TIME', 3600); // Token valide pour 1 heure

?>
