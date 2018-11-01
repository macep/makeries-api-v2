<?
/**
 * Rendering class
 *
 */

class Render
{
	/**
	 * render data
	 * @access private
	 * @var object 
	 */
	private $_data = null;

	/**
	 * list of JSs to be included
	 * @var array
	 */
	private $_js = array();

	/**
	 * list of CSSs to be included
	 * @var array
	 */
	private $_css = array();
	
	/**
	 * list of footer links
	 * @var array
	 */
	private $_footerLinks = array();

	/**
	 * content to be displayed
	 * @var array
	 */
	private $_buffer = array();
	
	private $_template = 'layout.php';

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
		// prepare the rendering data
		$this->clearData();
	}

	/**
	 * Prepares the data (empty)
	 *
	 */
	public function clearData()
	{
		$this->_data = new stdClass();
	}

	/**
	 * Sets the render data
	 *
	 * The $name parameter can be a string or an object storing the data
	 *
	 * @param string|object $name
	 * @param mixed $value
	 * @return boolean
	 */
	public function setData( $name = '', $value = null )
	{
		if( is_object($name) )
		{
			// if name is an object we set the data from this object
			foreach( get_object_vars($name) as $key => $val )
			{
				$this->_data->$key = $val;
			}
		}
		elseif( is_array($name) )
		{
			// if name is an array we set the data from this array
			foreach( array_keys($name) as $key => $val )
			{
				$this->_data->$key = $val;
			}
		}
		elseif( is_string($name) )
		{
			// if the name is a string
			$this->_data->$name = $value;
		}
		else
		{
			// if the first parameter is not an object or a string, we don't do anything
			return false;
		}

		return true;
	}

	/**
	 * Clears the output buffer
	 *
	 */
	public function clearBuffer()
	{
		$this->_buffer = array();
	}

	/**
	 * Adds content to the output buffer (used by renderPage)
	 *
	 * @param string $content
	 */
	public function addBuffer( $content, $bufferName = "body" )
	{
		if( ! isset($this->_buffer[$bufferName])) $this->_buffer[$bufferName] = array();
		$this->_buffer[$bufferName][] = $content;
	}

	/**
	 * Renders a view
	 *
	 * @param string $view - file name
	 * @return string
	 */
	public function renderView( $view = '' )
	{
		// we redefine the input variables so we can make it harder to overwrite their values from the template
		$__view = $view;

		// if we can't find the view, we throw an exception
		if( ! @file_exists($__view) )
		{
			throw new Exception( __METHOD__ . ': couldn\'t find file \'' . $__view . '\'.' );
		}

		if( ! @is_readable($__view) )
		{
			throw new Exception( __METHOD__ . ': couldn\'t open file \'' . $__view . '\'.' );
		}

		// we prepare the data object to be available to standard echo functions in the template
		foreach( get_object_vars($this->_data) as $__idx => $__val )
		{
			$$__idx = $__val;
		}

		// start output buffering
		ob_start();

		include( $__view );

		$buffer = ob_get_clean();

		// we clear the data for the next render
		$this->clearData();

		// return the buffer
		return $buffer;
	}

	/**
	 * Converts filename to unix format
	 *
	 * @param string $file
	 * @return string
	 */
	public function unixFilename( $file )
	{
		if( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' )
		{
            // Replace back-slash with slash
            $_file = str_replace('\\', '/', $file);
			
            // Replace duplicated // with single /
			return preg_replace('/\/+/i', '/', $_file);
		}

		return $file;
	}

	/**
	 * Adds a new javascript to the list of page javascripts
	 *
	 * @param string $file
	 * @return bool
	 */
	public function addJs( $file )
	{
		if( strlen($file) > 0 )
		{
			$tmp = $this->unixFilename(realpath($file));
			
			// daca fisierul exista, il adaugam in lista, altfel nnu
			if( strlen($tmp) > 0 )
			{
				$this->_js[] = $tmp;
			}
			else
			{
				return false;
			}
			
			return true;
		}

		return false;
	}

	/**
	 * Adds a new javascript to the list of page javascripts (by URL)
	 *
	 * @param string $url
	 * @return bool
	 */
	public function addJsUrl( $url )
	{
		if( strlen($url) > 0 )
		{
			$this->_js[] = $url;

			return true;
		}

		return false;
	}

	/**
	 * Clears the page js
	 *
	 */
	public function clearJs()
	{
		$this->_js = array();
	}

	/**
	 * Adds a new css to the list
	 *
	 * @param string $file
	 * @return bool
	 */
	public function addCss( $file )
	{
		if( strlen($file) > 0 )
		{
			$tmp = $this->unixFilename(realpath($file));
			
			// daca fisierul exista, il adaugam in lista, altfel nnu
			if( strlen($tmp) > 0 )
			{
				$this->_css[] = $tmp;
			}
			else
			{
				return false;
			}

			return true;
		}

		return false;
	}

	/**
	 * Clears the page Css
	 *
	 */
	public function clearCss()
	{
		$this->_css = array();
	}
	
	/**
	 * Adds a new link to the footer
	 * 
	 * Parameters supported for the link:
	 *    - id
	 *    - href
	 *
	 * @param mixed $link (array or object)
	 * @return bool
	 */
	public function addFooterLink( $link )
	{
		if( is_object($link) )
		{
			// if parameter is an object
			$this->_footerLinks[] = $link;
		}
		elseif( is_array($link) )
		{
			// if parameter is an array
			$this->_footerLinks[] = (object) $link;
		}
		else
		{
			return false;
		}
		
		return true;
	}

	/**
	 * Clears the footer links
	 *
	 */
	public function clearFooterLinks()
	{
		$this->_footerLinks = array();
	}
	
	/**
	 * Returns the date in string format
	 * 
	 * @return string
	 */
	public function getDateString()
	{
		return date('Y/m/d');
	}
	
	/**
	 * Returns the time in string format
	 * 
	 * @param bool $ampm
	 * @return string
	 */
	public function getTimeString( $ampm = false )
	{
		if( $ampm === false )
		{
			return date('G:i');
		}
		else
		{
			return date('g:i A');
		}
	}
	
	/**
	 * Returns a SCRIPT tag for a JS file
	 * 
	 * @param string $file
	 * @return string
	 */
	function jsLink( $file )
	{
		if( preg_match("/^http/", $file) )
		{
			// JS by URL
			return '<script type="text/javascript" src="' . $file . '"></script>';
		}
		else
		{
			// local JS file
			return '<script type="text/javascript" src="' . _BASE_URL_ . str_replace(_APP_DIR_, '', $file) . '?v=' . @filemtime($file) . '"></script>';
		}
	}
	
	/**
	 * Returns a LINK tag for a CSS file
	 * 
	 * @param string $file
	 * @return string
	 */
	function cssLink( $file )
	{
		return '<link rel="stylesheet" type="text/css" href="' . _BASE_URL_ . str_replace(_APP_DIR_, '', $file) . '?v=' . @filemtime($file) . '" />';
	}
	
	/**
	 * Returns the URL form of a file/folder
	 * 
	 * @param string $file
	 * @return string
	 */
	function getFileUrl( $file )
	{
		return _BASE_URL_ . str_replace(_APP_DIR_, '', $this->unixfilename(realpath($file)));
	}

	public function setTemplate($template) {
		$this->_template = $template;
	}
	
	public function getTemplate() {
		return $this->_template;
	}
	/**
	 * Renders the page. If the $noDisplay flag is set to true, the result is not displayed
	 *
	 * Uses the buffer to display content
	 *
	 * @param bool $noDisplay
	 * @param string $layoutFile
	 * @return string
	 */
	public function renderPage( $noDisplay = false, $layoutFile = "layout.php" )
	{
		$layoutFile = $this->getTemplate();
		$pageContent = array();

		/*** PAGE HEADER ***/
		$data = new stdClass();

		$tmp = array();
		for( $i = 0; $i < count($this->_js); $i++ )
		{
			$js = $this->_js[$i];
			$tmp[] = $this->jsLink( $js );
		}
		$data->js = join("\n", $tmp);

		$tmp = array();
		for( $i = 0; $i < count($this->_css); $i++ )
		{
			$css = $this->_css[$i];
			$tmp[] = $this->cssLink( $css );
		}
		$data->css = join("\n", $tmp);
        
		$this->setData($data);
        
        // define and set the session id
        $session = new Session();
        $this->setData('session_id', $session->getSessionId());
		/*** END PAGE HEADER ***/
		 
		foreach( $this->_buffer as $key => $value)
		{
			$this->setData($key, join("", $value));
		}
		
		$pageContent = $this->renderView(_LAYOUT_DIR_ . '/' . $layoutFile);

		// internal variables cleanup
		$this->clearBuffer();
		$this->clearJs();
		$this->clearCss();

		// start output buffering
		ob_start();

		$buffer = ob_get_clean();

		// if the $return flag is false, we display the result
		if( ! $noDisplay )
		{
			echo $pageContent;
		}

		// return the buffer
		return $buffer;
	}

	/**
	 * Encodes html entities in a text
	 *
	 * @param string $text
	 * @return string
	 */
	public function htmlEntities( $text )
	{
		return htmlentities( $text, ENT_COMPAT, 'UTF-8' );
	}
}