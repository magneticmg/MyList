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
class MyListModelList extends JModelList {
    
    function __construct($config = array()){
        
        $config['filter_fields'] = array("duedate","priority","status");
        parent::__construct($config);
    }
    function _getListQuery(){
        
        $db = $this->getDbo();
        
        $query = $db->getQuery(true);
        $userid = $this->getState('user_id', 0);
        $query->select("*")
                ->from("mylist_items")->where("user_id = $userid");
        $this->_buildOrderQuery($query);
       
        return $query;
        
    }
    
    function _buildOrderQuery(& $query){
        
        $query->order($this->getState('filter_order') . " " . $this->getState('filter_order_Dir'));
    }
    function getForm($data = array(), $loadData = true){
        
        $model= & $this->getInstance("Item", "MyListModel");
        return $model->getForm($data, $loadData);
    }
    function populateState(){
     
        $user = & MyListFactory::getUser();
        
        $app = & JFactory::getApplication();
        
        $filterColumn = $app->getUserStateFromRequest('filter_order', 'order', 'ordering');
        $filterDir = $app->getUserStateFromRequest('filter_order_Dir', 'dir', "ASC");
        if(!in_array($filterColumn, $this->filter_fields)){
            $filterColumn = 'ordering';
        }
        if(!in_array($filterDir, array("DESC","ASC"))){
            $filterDir = "ASC";
        }
        
        $this->setState('filter_order', $filterColumn);
        $this->setState('filter_order_Dir', $filterDir);
        
        $this->setState('user_id', $_SESSION['userid']);
        
    }
    
    
	/**
	 * Saves the manually set order of records.
	 *
	 * @param   array    $pks    An array of primary key ids.
	 * @param   integer  $order  +1 or -1
	 *
	 * @return  mixed
	 *
	 * @since   11.1
	 */
	public function saveorder($pks = null, $order = null)
	{
		// Initialise variables.
		$table = $this->getTable();
		$conditions = array();

		if (empty($pks))
		{
			return JError::raiseWarning(500, JText::_($this->text_prefix . '_ERROR_NO_ITEMS_SELECTED'));
		}

		// Update ordering values
		foreach ($pks as $i => $pk)
		{
			$table->load((int) $pk);

			if ($table->ordering != $order[$i])
			{
				$table->ordering = $order[$i];

				if (!$table->store())
				{
					$this->setError($table->getError());
					return false;
				}

				// Remember to reorder within position and client_id
				$condition = $this->getReorderConditions($table);
				$found = false;

				foreach ($conditions as $cond)
				{
					if ($cond[1] == $condition)
					{
						$found = true;
						break;
					}
				}

				if (!$found)
				{
					$key = $table->getKeyName();
					$conditions[] = array($table->$key, $condition);
				}
			}
		}

		// Execute reorder for each category.
		foreach ($conditions as $cond)
		{
			$table->load($cond[0]);
			$table->reorder($cond[1]);
		}

	
		return true;
	}
        
	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param   JTable  $table  A JTable object.
	 *
	 * @return  array  An array of conditions to add to ordering queries.
	 *
	 * @since   11.1
	 */
	protected function getReorderConditions($table)
	{
		return array();
	}
    
}
?>
