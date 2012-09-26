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

class MyListControllerItem extends MyListController {
    
    
    function item(){
        
     
        $model = $this->getModel('Item');
        
        $model->populateState();
        
        $response = new JObject;
        
        if(!$item = $model->getItem()){
            /**
             * Nothing returned 
             */
            $response->set('status', 0);
            $response->set('error', 
                    ($model->getError()) ? $model->getError() : 
                                           'No item was returned with that ID') ;
            
            
        } else {
            $response->set('status', 1);
            $response->set('item', $item);
            
            
        }
        $view = & $this->getVIew('item', 'json');
        $view->response = $response;
        $view->display();
    }
    function save(){
        
        $input = new JInput;
        $data = JRequest::getVar('jform');
        $response = new JObject;
        
        $model = $this->getModel('Item');
        $model->populateState();
        $userid = $model->getState('user_id');
        
        
        $data['user_id'] = $userid;
        if($userid == 0 || !$model->save($data)){
            $response->set('status', 0);
            $response->set("message","DOH! There was a problem saving your item!");
            $response->setError($model->getError());
            
        } else {
        
            $response->set('status', 1);
            $response->set("message","BAMB!Saved");
            $response->set("data", $data);
        }
        
        $view = & $this->getVIew('item', 'json');
        $view->response = $response;
        
        $view->display();
        $app = & JFactory::getApplication();
        $app->close();
        
        
    }
    function delete(){
        
        $input = new JInput;
        $data = JRequest::getVar('jform');
        $response = new JObject;
        
        $model = $this->getModel('Item');
        $userid = $model->getState('user_id');
        $model->populateState();
        if(!$model->delete()){
            $response->set('status', 0);
            $response->set("message","DOH! There was a problem deleting your item!");
            $response->setError($model->getError());
        } else {
            $response->set('status', 1);
            $response->set("message","BAMB!Delete!");
            
        }
    
        $view = & $this->getView('item', 'json');
        $view->response = $response;
        $view->display();
        $app = & JFactory::getApplication();
        $app->close();
    }
}
class MyListControllerItemGet extends MyListControllerItem {
    
    function execute(){
     
                $input = new JInput;
                $input->set('view', 'item');
                
                $config = array('default_view' => 'item',
                                'option' => 'mylist');
               
                $task = 'item.item';
                $input->set('task', $task);
                $controller = & JController::getInstance('MyList', $config);
               //display item
                
                $controller->execute('item');

    }
}
class MyListControllerItemPost extends MyListControllerItem {
    
    function execute(){
              
                $input = new JInput;
                
                $config = array('default_view' => 'item',
                                'option' => 'mylist');
                $data = JRequest::get();
              
                $data['mylist_item_id'] = $data['id'];
                
           
                if(JRequest::getMethod() =='PUT'){
                    $content = file_get_contents("php://input");
                    $content = explode("&", $content);
                    
                    foreach($content as $i => $value){
                            
                        $array = explode("=", $value);
                        $data[$array[0]] = $array[1];
                    }
                    
                    
                    
                }
                $input->set('jform',$data);
                
                $task = 'item.save';
                
                $input->set('task', $task);
                $controller = & JController::getInstance('MyList', $config);
                $controller->execute('save');
        
    }
}

class MyListControllerItemDelete extends MyListControllerItem {
    
    function execute(){
                $input = new JInput;
                $input->set('view', 'item');
                
                $config = array('default_view' => 'item',
                                'option' => 'mylist');
               
                $task = 'item.delete';
                $input->set('task', $task);
                $controller = & JController::getInstance('MyList', $config);
                $controller->execute('delete');
                
        
    }

}


?>
