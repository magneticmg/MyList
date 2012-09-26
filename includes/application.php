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
jimport('legacy.application.web');

/**
 * Using the Legacy application because it gives us a 
 * whole lot out of the box (and still extends JApplicationWeb.
 * 
 */
class MyList extends JApplicationWeb {

    function doExecute() {


        $type = $this->input->get("format", 'html');

        $this->loadDocument();
        JLoader::import("views.view", JPATH_BASE);
        JLoader::import('list', JPATH_CONTROLLERS);
        // get the Controller if xists
        $config = array(//'default_view' => 'list',
            'option' => 'mylist');

        $controller = & JController::getInstance('MyList', $config);

        ob_start();

        $controller->execute($this->input->get('task'));

        $content = ob_get_clean();

        if ($type == 'json') {
            echo $content;
            die();
        }
        $this->document->setBuffer($content, array('type' => 'component', 'name' => 'main', 'title' => null));

        return $this;
    }

    function route() {


        $uri = clone JURI::getInstance();

        $route = $path = $uri->getPath();
        $pattern = "/resource/";

        /**
         * If this happens route through REST API 
         *
         * parts  Array
          (
          [0] => resource
          [1] => item
          [2] => 10
          )
         *  */
        
            $session = JFactory::getSession();
            $session->initialise($this->input);
            
            $session->start();
            
        if (preg_match($pattern, $path)) {

            $this->set('isREST', 1);
            if (!$this->authorise()) {
            $response = new JObject;
            $response->status = 0;
            $response->message = 'You are not authorised to view that. Specific: ' . $this->get('message');
            echo json_encode($response);
            die();
         }
            $path = str_replace($pattern, '', $path);

            $parts = explode('/', $path);

            if (empty($parts[0])) {
                $response = new JObject;
                $response->message = 'You did not specify a resource, i.e. list or item';
                echo json_encode($response);
                die();
            }
            $id = isset($parts[1]) ? $parts[1] : false;

            $type = $parts[0];

            $this->input->set('type', $type);
            $this->input->set('id', $id);
            unset($parts[1]);

            if ($type == 'item') {

                if (!$id && $_SERVER['METHOD']=="GET" ) {
                    $response = new JObject;
                    $response->message = 'No Item Id is set, i.e. /resource/item/10 where 10 is the Item Id';
                    echo json_encode($response);
                    die();
                }
            }
            

            $route = implode("/", $parts);
            $router = new JRouterMyList($this);

            $router->execute("/" . $route);
            $this->close();
        }
        
        
            if (!$this->authorise()) {
            
               $this->_message[] =  'You are not authorised to view that. Specific: ' . $this->get('message');
               return false;
            
         }
    }

    function authorise() {

        // app REST

        $authid = $this->input->get('a', false);
        $pass = $this->input->get('p', false);

        if (!$authid OR !$pass) {
            return false;
        }
        $creds['username'] = $authid;
        $creds['password'] = $pass;
        JLoader::import('mylist.user.authentication', JPATH_BASE . DS . "libraries");

        $auth = MyListAuthentication::getInstance();

        $response = $auth->authenticate($creds, array());
            
        if ($response->status != 1) {
             
            $this->set('message', $response->get('error_message'));
            return false;
        }
        //**
        
            
       // if(!$this->get('isREST', false)){
           
            
            $session = & MyListFactory::getSession();
            $session->set('user', $response);
            $_SESSION['userid'] = $response->id;
            
            
                      
            
        //}
        return true;
    }

    /**
     * Gets the value of a user state variable.
     *
     * @param   string  $key      The key of the user state variable.
     * @param   string  $request  The name of the variable passed in a request.
     * @param   string  $default  The default value for the variable if not found. Optional.
     * @param   string  $type     Filter for the variable, for valid values see {@link JFilterInput::clean()}. Optional.
     *
     * @return  The request user state.
     *
     * @since   11.1
     */
    public function getUserStateFromRequest($key, $request, $default = null, $type = 'none') {
        $cur_state = $this->getUserState($key, $default);
        $new_state = $this->input->get($request, null, $type);

        // Save the new value only if it was set in this request.
        if ($new_state !== null) {
            $this->setUserState($key, $new_state);
        } else {
            $new_state = $cur_state;
        }

        return $new_state;
    }

    public function getCfg($varname, $default = null) {
        $config = JFactory::getConfig();
        return $config->get('' . $varname, $default);
    }

    /**
     * Gets a user state.
     *
     * @param   string  $key      The path of the state.
     * @param   mixed   $default  Optional default value, returned if the internal value is null.
     *
     * @return  mixed  The user state or null.
     *
     * @since   11.1
     */
    public function getUserState($key, $default = null) {
        $session = JFactory::getSession();
        $registry = $session->get('registry');

        if (!is_null($registry)) {
            return $registry->get($key, $default);
        }

        return $default;
    }

    /**
     * Sets the value of a user state variable.
     *
     * @param   string  $key    The path of the state.
     * @param   string  $value  The value of the variable.
     *
     * @return  mixed  The previous state, if one existed.
     *
     * @since   11.1
     */
    public function setUserState($key, $value) {
        $session = JFactory::getSession();
        $registry = $session->get('registry');

        if (!is_null($registry)) {
            return $registry->set($key, $value);
        }

        return null;
    }

    function getTemplate() {

        return $this->get('theme');
    }

    function getMenu() {
        return false;
    }

    protected function render() {

        $tmpl = $this->input->get('tmpl', 'index');
        $file = $tmpl . '.php';
        if ($tmpl == 'json') {
            $this->setHeader("content-type", "application/json", true);
        }

        // Setup the document options.
        $options = array(
            'template' => $this->get('theme'),
            'file' => $file,
            'params' => $this->get('themeParams')
        );

        if ($this->get('themes.base')) {
            $options['directory'] = $this->get('themes.base');
        }
        // Fall back to constants.
        else {
            $options['directory'] = defined('JPATH_THEMES') ? JPATH_THEMES : (defined('JPATH_BASE') ? JPATH_BASE : __DIR__) . '/themes';
        }

        // Parse the document.
        $this->document->parse($options);

        // Render the document.
        $data = $this->document->render($this->get('cache_enabled'), $options);

        // Set the application output data.
        $this->setBody($data);
    }
    
    	protected function _createSession($name)
	{
            
                 return MyListFactory::getSession();
		$options = array();
		$options['name'] = $name;

	
		$session = MyListFactory::getSession($options);

		//TODO: At some point we need to get away from having session data always in the db.

		$db = JFactory::getDBO();

		// Remove expired sessions from the database.
		$time = time();
		if ($time % 2)
		{
			// The modulus introduces a little entropy, making the flushing less accurate
			// but fires the query less than half the time.
			$query = $db->getQuery(true);
			$query->delete($query->qn('#__session'))
				->where($query->qn('time') . ' < ' . $query->q((int) ($time - $session->getExpire())));

			$db->setQuery($query);
			$db->execute();
		}



		return $session;
	}
        
	/**
	 * Provides a secure hash based on a seed
	 *
	 * @param   string  $seed  Seed string.
	 *
	 * @return  string  A secure hash
	 *
	 * @since   11.1
	 */
	public static function getHash($seed)
	{
		return md5(JFactory::getConfig()->get('secret') . $seed);
	}


}

?>
