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
JLoader::import("views.view", JPATH_BASE);

class MyListViewList extends MyListView {
    
    function display($tpl = null){
    
        
        
        $this->list = $this->getModel()->getItems();
        $this->_prepareList($this->list);
        
        echo json_encode($this->list);
        //exit();
    }
    private function _prepareList(& $list){
        self::loadHelper("list");
        foreach($list as $i=>$item){
            
            $list[$i]->priority = MyListListHelper::wordPriority($item->priority);
        }
        
    }
}
?>
