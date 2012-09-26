<?php

/* ==========================================================================*\
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
  \*========================================================================== */
jimport('joomla.user.authentication');

class MyListAuthentication extends JAuthentication {

    function __construct() {

        JLoader::import('plugins.authentication.mylist.mylist', JPATH_BASE);
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function authenticate($credentials, $options = array()) {

        $plu = new JObject;
        $plu->type = 'authentication';
        $plu->name = 'joomla';
        $plugin = new plgAuthenticationMyList($this, (array) $plu);

        // Create authentication response
        $response = new JAuthenticationResponse;

        $plugin->onUserAuthenticate($credentials, $options, $response);
        $plugin->onUserLogin($response);
        
        return $response;
    }
    

}

?>
