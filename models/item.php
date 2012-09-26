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

class MyListModelItem extends JModelForm {

    function getForm($data = array(), $loadData = true) {

        if (!$form = $this->loadForm('item', 'item', array('control' => 'jform', 'load_data' => $loadData))) {
            //gp($this->getError(), __METHOD__);           
        }

        return $form;
    }

    /**
     * Remove the proprocess. 
     * @return type 
     */
    function preprocessForm() {
        return;
    }

    function save($data = null){
        
        $table = & $this->getTable(false, 'MyListTable');
        $table->load($data[$table->getKeyName()]);
        $date = new JDate($data['duedate']);
        $data['duedate'] = $date->toSQL();
        
        if(!$table->save($data)){
            $this->setError($table->getError());
            return false;
        }
        return $table;
    }
    function delete(){
        
        $table = & $this->getTable(false, 'MyListTable');
        if(!$table->load(array($table->getKeyName()=>$this->getState($table->getKeyName()), 'user_id'=> $this->getState('user_id')))){
               $this->setError($table->getError());
               return false;
        }
        if(!$table->delete()){
            $this->setError($table->getError());
            return false;
        }
        return true;
    }
    function loadFormData() {
        
        if(!isset($this->data) || empty($this->data)){
            $this->getItem();
        }
        
        return $this->data;
    }
    
    function getItem(){
        
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $mylist_item_id = $this->getState('mylist_item_id', 0);
        $query->select("*")
                ->from("mylist_items")
                ->where("mylist_item_id = $mylist_item_id")
                ->limit("1");
        $db->setQuery($query);
        
        if(!$this->data = $db->loadObject()){
              
            $this->setError($db->getError());
            return false;
        }
        
        return $this->data;
    }
    
    function populateState() {

        $user = & MyListFactory::getUser();

        $app = & JFactory::getApplication();
        $itemid = $app->getUserStateFromRequest('mylist_item_id', 'id', 0, 'int');

        $this->setState('mylist_item_id', $itemid);
        $this->setState('user_id', $_SESSION['userid']);
        
    }

}
