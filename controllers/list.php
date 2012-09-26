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
JLoader::import('controller', JPATH_BASE);

class MyListControllerList extends MyListController {
    
//        public function saveorder()
//	{
//		
//		// Get the input
//		$pks = JRequest::getVar('cid', null, 'post', 'array');
//		$order = JRequest::getVar('order', null, 'post', 'array');
//
//		// Sanitize the input
//		JArrayHelper::toInteger($pks);
//		JArrayHelper::toInteger($order);
//
//		// Get the model
//		$model = $this->getModel();
//
//		// Save the ordering
//		$return = $model->saveorder($pks, $order);
//
//		if ($return === false)
//		{
//			// Reorder failed
//			$message = JText::sprintf('JLIB_APPLICATION_ERROR_REORDER_FAILED', $model->getError());
//			$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false), $message, 'error');
//			return false;
//		}
//		else
//		{
//			// Reorder succeeded.
//			$this->setMessage(JText::_('JLIB_APPLICATION_SUCCESS_ORDERING_SAVED'));
//			$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
//			return true;
//		}
//	}
}

class MyListControllerListGet extends MyListControllerList {
    
    function execute(){
     
                $input = new JInput;
                $input->set('view', 'list');
                $input->set('format', 'json');
                
                $config = array('default_view' => 'item',
                                'option' => 'mylist');
               
                
                $controller = & JController::getInstance('MyList', $config);
               //display item
                
                $controller->execute('display');

    }
}
?>
