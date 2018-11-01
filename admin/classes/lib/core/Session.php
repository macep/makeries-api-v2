<?
/**
 * Session handling class
 *
 */
class Session
{
	/**
	 * Start the session
	 *
	 */
	public function start()
	{
		if( ! isset($_SESSION) )
		{
			@session_start();
		}
	}

	/**
	 * Stops the session
	 *
	 */
	public function stop()
	{
		if( isset($_SESSION) )
		{
			session_write_close();
		}
	}

	/**
	 * Returns a value from an array, or false if the key is not defined
	 *
	 * @param array $array
	 * @param string $key
	 * @return mixed
	 * @access private
	 */
	private function _getFromArray(&$array, $key = '')
	{
		if( ! isset($array[$key]) )
		{
			return false;
		}

		return $array[$key];
	}

	/**
	 * Returns a session value
	 *
	 * @param	string $key
	 * @return	string
	 */
	public function get($key = '')
	{
		// start the session if it's not already started
		$this->start();
		
		return $this->_getFromArray($_SESSION, $key);
	}

	/**
	 * Sets a session value
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function set($key, $value = '')
	{
		// if the key is empty we can't do anything
		if( $key == '' )
		{
			return false;
		}

		// start the session if it's not already started
		$this->start();

		$_SESSION[$key] = $value;
	}

	/**
	 * Deletes a key from the session
	 *
	 * @param string $key
	 */
	public function delete($key)
	{
		// start the session if it's not already started
		$this->start();

		if( isset($_SESSION[$key]) )
		{
			unset($_SESSION[$key]);
		}
	}

	/**
	 * Returns the current Session ID
	 *
	 * @return string
	 */
	public function getSessionId()
	{
		return session_id();
	}

	/**
	 * Destroys a session
	 *
	 */
	public function destroy()
	{
		$this->start();

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if( ini_get("session.use_cookies") )
		{
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}

		// Destroy the session
		@session_destroy();
	}

	/**
	 * Is valid session? If the user is not logged in, redirect to login page
	 *
	 */
	function checkValid()
	{
		if( $this->get('qadms_is_logged_in') !== '1' )
		{
			$router = new Router();
			$input = new Input();

			// if the user is not logged in, we set the referer url and redirect
			$this->set('urlReferer', $input->getServer('REQUEST_URI') );

			$router->redirect( $router->getUrl('user', 'login') );
		}
	}

	/**
	 * class destructor
	 *
	 */
	public function __destruct()
	{
		// stop the session so that we don't block other concurrent requests
#		$this->stop();
	}
}