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

jimport('legacy.controller.controller');

class MyListController extends JController {
    
    
    function display(){
        $input = new JInput;
        $type = $input->get("format",'html');
        
        $viewName = $input->get('view', 'mylist');
        $view = $this->getView($viewName, $type);
        
        if($model = $this->getModel($viewName)){
            
            $view->setModel($model, true);
        }
        //gp($this->getModel('login', 'MyListModel'));
        if($loginModel = & $this->getModel('Login', 'MyListModel')){
            $view->setModel($loginModel, false);
        }
         
        $view->display();
        $this->redirect();
    }
}
?>
