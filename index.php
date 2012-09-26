<?php

/*==========================================================================*\
 || ######################################################################## ||
 || # MMInc PHP                                                            # ||
 || # Project: MyList                                             # ||
 || #  $Id:  $                                                             # ||
 || # $Date:  $                                                            # ||
 || # $Author:  $                                                          # ||
 || # $Rev: $                                                              # ||
 || # -------------------------------------------------------------------- # ||
 || # @Copyright (C) 2010 - Cameron Barr, Magnetic Merchandising Inc.      # ||
 || # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html                # ||
 || # -------------------------------------------------------------------- # ||
 || # http://www.magneticmerchandising.com  info@magneticmerchandising.com # ||
 ||                                                                          ||
 || # -------------------------------------------------------------------- # ||
 || ######################################################################## ||
 \*==========================================================================*/


function gp($array = array(), $text = '', $die =false){

    if(
            $_SERVER['REMOTE_ADDR'] != '99.246.13.141' AND
            $_SERVER['REMOTE_ADDR'] != '127.0.0.1' AND
            $_SERVER['REMOTE_ADDR'] != '184.107.185.242' 
            ){
     return ;
    }
                  $html= '<pre><b>' .$text . '  </b>' ;
                  ob_start();
                  print_r($array);

                  $html .= ob_get_contents();
                  ob_end_clean();

                  $html .= '</pre>';
                  echo $html;
                  echo time().'<br/>';
                  
                  if($die){
                      exit();
                  }
            }

error_reporting(0);
ini_set('display_errors', true);

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

if($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
    define("DIRLIBRARY", "C:\\xampp\\htdocs\\JoomlaPlatform12\\joomla-platform.git" . DS . "libraries" );
} else {
    define("DIRLIBRARY", dirname(__FILE__). DS. '../../joomla-platform'. DS . "libraries");
}

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', dirname(__FILE__));
	require_once JPATH_BASE.'/includes/defines.php';
}

require_once JPATH_BASE.'/includes/framework.php';
require_once JPATH_BASE.'/includes/application.php';


$app = & JApplicationWeb::getInstance("MyList");

JFactory::$application = $app;

$app->route();
$app->execute();


?>