<?php
/*==========================================================================*\
 || ######################################################################## ||
 || # MMInc PHP                                                            # ||
 || # Project: DarkRedDoor                                             # ||
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
$doc = & JFactory::getDocument();

$doc->addStyleSheet("templates/light/javascript/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css");
$doc->addStyleSheet("templates/light/css/style.css");
$doc->addScript("templates/light/javascript/jquery-ui-1.8.23.custom/js/jquery-1.8.0.min.js");
$doc->addScript("templates/light/javascript/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js");


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<jdoc:include type="head" />
</head>
<body>
    <div id="whole">
        
        <div id="top">
            <h1><?php echo "My List"; ?></h1>
        </div> 
        
            <div id="content" class="maincontent">
                       <jdoc:include type="component" name="main" />
            </div>
        
        <div id="footer">
             
        </div>
    </div>

</body>
</html>