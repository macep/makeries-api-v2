<?php
/**
 * Routing handling class
 *
 */
class Router
{
	/**
	 * Returns the module folder
	 * 
	 * @param string $module
	 * @return string
	 */
	public function getModulePath($module)
	{
		return _MODULE_DIR_ . '/' . $module;
	}

	/**
	 * Returns the controller for a specific function of a module
	 *
	 * @param string $module
	 * @param string $function
	 * @return string
	 */
	public function getController($module, $function)
	{
		return _MODULE_DIR_ . '/' . $module . '/controller/' . $module . '_controller.class.php';
	}

	/**
	 * Returns the classname for a module
	 *
	 * @param string $module
	 * @return string
	 */
		public function getModuleClass($action)
		{
				return strtolower($module) . 'Actions';
		}

	/**
	 * returns the URL for a module/function/values
	 *
	 * @param string $module
	 * @param string $function
	 * @param array $values
	 * @return string
	 */
	public function getUrl($module, $function = null, $values = null)
	{
		$url = array();

		$url[] = rtrim(_BASE_URL_, '/');
		$url[] = strtolower($module);
		$url[] =  ( $function === null ? 'index' : $function );

		// if we have values specified, we add them to the URL
		if( is_array($values) )
		{
			$url = array_merge( $url, $values );
		}

		return join('/', $url);
	}

	public function display() {
	}

	/**
	 * Parses the URL
	 *
	 * URL format: /module/function/arg1/arg2/...
	 *
	 * Returns an object with the format:
	 *   ->module
	 *   ->function
	 *   ->args
	 *
	 * @return object
	 * @throws Exception
	 */

	public function parseUrl()
	{
		// we remove the base URL (application url) from the URI and remove the first and last slashes
		$baseUrl = str_replace("/", "\/", rtrim(_BASE_URL_, '/'));
		if( strlen($baseUrl) > 0 )
		{
			$tmpUrl = trim(preg_replace("/^" . str_replace("/", "\/", rtrim(_BASE_URL_, '/')) . "/", '', $_SERVER['REQUEST_URI']), '/');
		}
		else
		{
			$tmpUrl = trim($_SERVER['REQUEST_URI'], '/');
		}
		$tmp = parse_url( $tmpUrl );
		$url = $tmp['path'];

		// we explode the parts by "/"
		$parts = explode("/", $url);
		
		// since the URI must have a module and a function part, we stop if we don't find them
		if( count($parts) < 2 )
		{
			throw new Exception('Invalid URL specified.');
		}

		$return = new stdClass();
		$return->module = $parts[0];
		$return->function = $parts[1];
		$return->args = array();

		for( $idx = 2; $idx < count($parts); $idx++ )
		{
			$return->args[] = $parts[$idx];
		}

		if( ! @is_dir($this->getModulePath($return->module)) )
		{
			throw new Exception('No module named \'' . $return->module . '\' found.');
		}

		if( ! @is_readable($this->getController($return->module, $return->function)) )
		{
			throw new Exception('Controller file \'' . $this->getController($return->module, $return->function) . '\' not found.');
		}

		require_once($this->getController($return->module, $return->function));

		$modulename = $this->getModuleClass($return->module);
		$tmp = new $modulename;

		if( ! method_exists($tmp, $return->function) )
		{
			throw new Exception('Method '.$return->function.' not found in class '.$modulename);
		}

		return $return;
	}

	/**
	 * Call the method/function specified in the URL
	 *
	 */
	public function dispatch($match = array()) {
#var_dump($match);
				$className = strtolower($match['target']['c']);
				$action = strtolower($match['target']['a']);
				
				if ('' == $action) {
						$action = 'index';
				}
#var_dump($class,$action);
				$fileName = _APP_DIR_ . '/classes/app/'. _APP_DIR_TYPE_.'/modules/'.strtolower($className).'/actions/actions.class.php';
				try {
						if( file_exists($fileName) ) {
								require_once($fileName);
						} else {
								$className = 'page';
								$actionName = '404';
								$fileName = _APP_DIR_ . '/classes/app/'. _APP_DIR_TYPE_.'/modules/'.strtolower($className).'/actions/actions.class.php';
								require_once($fileName);
								#print 'Action '.$className.' not defined';
								#exit;
						}
						$modulename = $className.'Actions';
#var_dump($modulename);exit;
						$class = new $modulename;
#var_dump($class);
						$actionName = 'execute' . ucfirst($action);
#var_dump($modulename, $action, $actionName);exit;
						if( ! method_exists($class, $actionName) ) {
								$className = 'page';
								$action= 'notDefined';
								$actionName = 'executeNotdefined';
								$fileName = _APP_DIR_ . '/classes/app/'. _APP_DIR_TYPE_.'/modules/'.strtolower($className).'/actions/actions.class.php';
								require_once($fileName);
								$modulename = $className.'Actions';
								$class = new $modulename;
								#throw new Exception('Method '.$action .' not found in class '.$modulename);
						}
#var_dump($className, $actionName, $fileName);
						$class->$actionName();
						$template = is_null($class->getTemplateToDisplay()) ? $action : $class->getTemplateToDisplay();
						$class->render->addBuffer( $class->render->renderView( _APP_DIR_ . '/classes/app/'. _APP_DIR_TYPE_ .'/modules/'.strtolower($className).'/templates/'.strtolower($template).'Success.php'));
						$class->render->renderPage();
						
				} Catch(Exception $e) {
						print '<pre>';
						var_dump($e.message);
				}
		}

	/**
	 * Redirects to an URL
	 *
	 * @param string $url
	 * @param mixed $args (array or object)
	 */
	public function redirect($url, $args = array())
	{
		// just in case we have something in the output buffer, we get a chance to clean it so we don't get an error
		ob_clean();

		// query string
		$queryString = http_build_query($args);

		if( strlen($queryString) > 0 )
		{
			$url .= "?" . $queryString;
		}

		// the session MUST be stopped before we do the redirect
		#$session = new Session();
		#$session->stop();

		// do the redirect
		header('Location: '.$url);

		// the application should not output anything else below this
		exit;
	}
				
	public function redirect301($url, $args = array())
	{
		// just in case we have something in the output buffer, we get a chance to clean it so we don't get an error
		ob_clean();

		// query string
		$queryString = http_build_query($args);

		if( strlen($queryString) > 0 )
		{
			$url .= "?" . $queryString;
		}

		// the session MUST be stopped before we do the redirect
		#$session = new Session();
		#$session->stop();

		// do the redirect
		header("HTTP/1.1 301 Moved Permanently"); 
		header('Location: '.$url);

		// the application should not output anything else below this
		exit;
	}
}
