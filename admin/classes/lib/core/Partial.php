<?
/**
 * Base controller class
 *
 */

class Partial
{
	private $_render = null;

	/**
	 * stores an instance of the Router object
	 * @var object
	 * @access private
	 */
	private $_router = null;

	/**
	 * stores an instance of the template which will be displayed
	 * @var object
	 * @access private
	 */
	private $_template_to_display = null;
	/**
	 * Class constructor
	 *
	 */
	function __construct()
	{
	}

	/**
	 * class get overloading (accessing private methods from outside the class)
	 *
	 * @param string $name
	 * @return object
	 */
	public function __get( $name )
	{
		
		// we only permit accessing the $input, $cookie and $session variables in this way
		switch( $name )
		{
			case 'render':
			case 'router':
				$private = '_' . $name;

				if( $this->$private === null )
				{
					// instantiate class if not instantiated
					$className = ucfirst($name);
					$this->$private = new $className;
				}

				return $this->$private;

				break;
		}

		// we return NULL otherwise
		return null;
	}
	
	public function setTemplateToDisplay($_template_to_display) {
		$this->_template_to_display = $_template_to_display;
	}
	
	public function getTemplateToDisplay() {
		return $this->_template_to_display;
	}
	
	/**
	 * 
	 * Log error 
	 * @param int $errorCode
	 * @param string $errorText
	 */
	public function logError($errorCode, $errorText)
	{
           //log here	    
	}
}