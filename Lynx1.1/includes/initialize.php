<?php


ini_set('display_errors', 1); 
error_reporting(E_ALL);

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


//LOCALHOST
//Users/Yoogz/Dropbox/AWI/Travaux/awi_client/
//defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'Yoogz'.DS.'Dropbox'.DS.'AWI'.DS.'travaux'.DS.'awi_client'.DS.'1.1');

//WEB
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'var'.DS.'www'.DS.'vhosts'.DS.'anotherwayin.fr'.DS.'sitesweb'.DS.'client'.DS.'1.1');
defined('ESPACE') ?  null : define('ESPACE', '1.1');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
defined('CLASS_PATH') ? null : define('CLASS_PATH', SITE_ROOT.DS.'classes');
defined('ACTION_PATH') ? null : define('ACTION_PATH', SITE_ROOT.DS.'actions');

//SITES URL (pour images...)
//LOCALHOST
//defined('URL_SITE') ? null : define('URL_SITE', 'http://localhost:8888/AWI/Travaux/awi_client/');

//WEB
defined('URL_SITE') ? null : define('URL_SITE', 'http://client.anotherwayin.fr/1.1/');

defined('URL_THELIA') ? null : define('URL_THELIA', 'http://www.thecakeshop.fr/');


// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'fonctions.php');
$execution_debut=exec_debut();

//load core objects
require_once(CLASS_PATH.DS.'database.php');
require_once(CLASS_PATH.DS.'database_object.php');

// load des classes

require_once(CLASS_PATH.DS.'class.phpmailer.php');
require_once(CLASS_PATH.DS.'class.smtp.php');
require_once(CLASS_PATH.DS.'client.php');
require_once(CLASS_PATH.DS.'commande_thelia.php');
require_once(CLASS_PATH.DS.'favori.php');
require_once(CLASS_PATH.DS.'fournisseur.php');
require_once(CLASS_PATH.DS.'graph.php');
require_once(CLASS_PATH.DS.'ligne_commande_thelia.php');
require_once(CLASS_PATH.DS.'mail.php');
require_once(CLASS_PATH.DS.'pagination.php');
require_once(CLASS_PATH.DS.'produit.php');
require_once(CLASS_PATH.DS.'tri.php');
require_once(CLASS_PATH.DS.'date.php');
require_once(CLASS_PATH.DS.'user.php');
require_once(CLASS_PATH.DS.'acces.php');
require_once(CLASS_PATH.DS.'session.php');
require_once(CLASS_PATH.DS.'historique_stock.php');
require_once(CLASS_PATH.DS.'catalogue_fournisseur.php');
require_once(CLASS_PATH.DS.'commande_fournisseur.php');
require_once(CLASS_PATH.DS.'ligne_commande_fournisseur.php');
require_once(CLASS_PATH.DS.'prevenir_client.php');
require_once(CLASS_PATH.DS.'graph_splines.php');
require_once(CLASS_PATH.DS.'TabStock.php');
require_once(CLASS_PATH.DS.'vente_caisse.php');
require_once(CLASS_PATH.DS.'ticket.php');
require_once(CLASS_PATH.DS.'ticket_message.php');
require_once(CLASS_PATH.DS.'mail_lynx.php');
require_once(CLASS_PATH.DS.'chiffre_affaires.php');

//pour affichage correct des dates 
setlocale(LC_TIME, 'fr_FR.utf8','fra');

//IF LOGGED IN FALSE, REDIRECT TO client.anotherwayin.fr pour login et redirection.

$graph=NULL;


?>