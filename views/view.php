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
class MyListView extends JView {
    
    function _loadTemplate($name = null, $vars = array()){
        
        if(!$name) return '';
        
        if(empty($vars)){
            return parent::loadTemplate($name);
        }
        
        foreach($vars as $var=>$value){
            ${$var} = $value; 
        }
        $layout = $this->getLayout();
        
        $path = $this->getPath($layout."_$name");

		// Check if the layout path was found.
		if (!$path)
		{
			throw new RuntimeException('Layout Path Not Found');
		}
       
       
        ob_start();
        
        include $path; 
        
        return ob_get_clean();
        
    }
}
?>
