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
jimport("joomla.application.router.rest");

class JRouterMyList extends JApplicationWebRouterRest {
    
    protected $suffixMap = array(
		'GET' => 'Get',
		'POST' => 'Post',
		'PUT' => 'Post',
		'PATCH' => '',
		'DELETE' => 'Delete',
		'HEAD' => '',
		'OPTIONS' => ''
	);
    
   
      function __construct($app, $input = null){
        
        parent::__construct($app, $input);
        $this->setDefaultController('MyList');
        $this->setControllerPrefix("MyListController");
        $this->addMap("/item", 'Item');
        $this->addMap("/list", 'List');
        
        JLoader::import('controllers.item', JPATH_BASE);
        JLoader::import('controllers.list', JPATH_BASE);
        
    }
    
    /**
     * We are only useing the router for the REST for now. 
     * @param type $route 
     */
    public function execute($route)
	{
		// Get the controller name based on the route patterns and requested route.
		$name = $this->parseRoute($route);

             //   gp($route, __METHOD__);
		// Append the HTTP method based suffix.
		$name .= $this->fetchControllerSuffix();

		// Get the controller object by name.
		$controller = $this->fetchController($name);
                
		// Execute the controller.
		$controller->execute();
	}
}
?>
