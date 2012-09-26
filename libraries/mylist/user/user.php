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
class MyListUser extends JUser{
    public function load($id)
	{
		// Create the user table object
		$table = $this->getTable('User', "MyListTable");

		// Load the JUserModel object based on the user id or throw a warning.
		if (!$table->load($id))
		{
			JLog::add(JText::sprintf('JLIB_USER_ERROR_UNABLE_TO_LOAD_USER', $id), JLog::WARNING, 'jerror');
			return false;
		}
                $table->id = $table->get($table->getKeyName());  
                $table->block =  $table->activation = null;
		/*
		 * Set the user parameters using the default XML file.  We might want to
		 * extend this in the future to allow for the ability to have custom
		 * user parameters, but for right now we'll leave it how it is.
		 */

		

		// Assuming all is well at this point lets bind the data
		$this->setProperties($table->getProperties());

		return true;
	}
        
        	public static function getUserId($username)
	{
		// Initialise some variables
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('mylist_user_id'));
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('username') . ' = ' . $db->quote($username));
		$db->setQuery($query, 0, 1);
		return $db->loadResult();
	}
        
	/**
	 * Returns the global User object, only creating it if it
	 * doesn't already exist.
	 *
	 * @param   integer  $identifier  The user to load - Can be an integer or string - If string, it is converted to ID automatically.
	 *
	 * @return  JUser  The User object.
	 *
	 * @since   11.1
	 */
	public static function getInstance($identifier = 0)
	{
		// Find the user id
		if (!is_numeric($identifier))
		{
			if (!$id = self::getUserId($identifier))
			{
				JLog::add(JText::sprintf('JLIB_USER_ERROR_ID_NOT_EXISTS', $identifier), JLog::WARNING, 'jerror');
				$retval = false;
				return $retval;
			}
		}
		else
		{
			$id = $identifier;
		}

		// If the $id is zero, just return an empty JUser.
		// Note: don't cache this user because it'll have a new ID on save!
		if ($id === 0)
		{
			return new MyListUser;
		}

		// Check if the user ID is already cached.
		if (empty(self::$instances[$id]))
		{
			$user = new MyListUser($id);
			self::$instances[$id] = $user;
		}

		return self::$instances[$id];
	}


}
?>
