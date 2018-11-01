<?
/**
 * Input handling class
 *
 */

class Input
{
	/**
	 * request IP address
	 * @var string
	 */
	private $_ipAddress = null;

	/**
	 * user agent (web browser)
	 * @var string
	 */
	private $_userAgent = null;

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Returns a value from an array, or false if the key is not defined
	 *
	 * @param array $array
	 * @param string $key
	 * @return mixed
	 * @access private
	 */
	private function _getFromArray($array, $key = '', $default_value = null)
	{
		if( ! isset($array[$key]) )
		{
		return $default_value ? $default_value : false;
		}

		return $array[$key];
	}

	/**
	 * Returns a value from the $_GET or $_POST arrays.
	 * The $_POST array has priority
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key = null, $default_value = null)
	{
		// if no key has been specified, we return the full $_POST or $_GET array
		if( $key === null )
		{
			// if we have the $_POST array, we return it. Otherwise we return the $_GET array
			if( ! empty($_POST) )
			{
				return $_POST;
			}
			else
			{
				return $_GET;
			}
		}

		// else we return the requested value
		return $this->_getFromArray( (! empty($_POST) ? $_POST : $_GET), $key, $default_value);
	}

	/**
	 * Returns an element from the $_SERVER variable
	 *
	 * @param string $key
	 * @return string
	 */
	public function getServer($key = null)
	{
		return $this->_getFromArray($_SERVER, $key);
	}

	/**
	 * Returns the IP address of the request
	 *
	 * @return string
	 */
	public function getIpAddress()
	{
		if( $this->_ipAddress !== null )
		{
			return $this->_ipAddress;
		}

		if( $this->getServer('HTTP_X_FORWARDED_FOR') )
		{
			$this->_ipAddress = $this->getServer('HTTP_X_FORWARDED_FOR');
		}
		else
		{
			$this->_ipAddress = $this->getServer('REMOTE_ADDR');
		}

		return $this->_ipAddress;
	}

	/**
	 * Returns the User Agent string (browser)
	 *
	 * @return string
	 */
	public function getUserAgent()
	{
		if( ! $this->_userAgent )
		{
			$this->_userAgent = $this->getServer('HTTP_USER_AGENT');
		}

		return $this->_userAgent;
	}
}