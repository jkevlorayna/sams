<?php 
include('repository/dbcon.php'); 

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$slim_app = new \Slim\Slim();


foreach (glob("repository/*.php") as $filename) {
	include($filename);
}	


foreach (glob("controllers/*.php") as $filename) {
	include($filename);
}	

$slim_app->run();
?>