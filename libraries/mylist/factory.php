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

class MyListFactory extends JFactory{
    
    
        public static function getUser($id = null)
	{
		$instance = self::getSession()->get('user');
                
	
                if ( !($instance instanceof MyListUser) || (isset($instance->id) &&  $instance->id != $id))
		{
			
                 $table = & JTable::getInstance("User", "MyListTable");
                 $table->load($id);
                 $instance = new JObject($table->getProperties());
                 
                 self::getSession()->set('user', $instance);
		}
                
                
		return $instance;
	}
}
?>
