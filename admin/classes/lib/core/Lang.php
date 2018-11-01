<?
/**
 * Language translation class
 * 
 */

class Lang
{
	// object instance
	private static $_instance = null;

	/**
	 * Default language
	 * @var string
	 */
	private $_lang = 'en_US';

	/**
	 * Array containing translation data
	 * @var array
	 */
	private $_langData = null;

	/**
	 * Language data needs saving
	 * @var bool
	 */
	private $_needSave = false;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		// check if a new language is specified
		$this->_checkLanguageOverride();

		// trying to get the configured language
		try {
			$this->_lang = Config::get('lang');
		} catch (Exception $e) {
			// default language not set
		}

		// read the language information from disk
		$this->loadLanguage( $this->_lang );
	}

	/**
	 * Returns an instance of the object
	 *
	 * @return object
	 */
	public static function getInstance()
	{
		if( self::$_instance === null )
		{
			// pregatim instanta daca nu o avem setata
			self::$_instance = new Lang();
		}

		return self::$_instance;
	}

	/**
	 * Reads a translation from disk
	 * @param string $lang
	 * @throws Exception
	 * @version 1.0.0
	 */
	private function loadLanguage( $lang = '' )
	{
		$baseFileName = _LANG_DIR_ . '/' . $lang;

		$languageFileName = $baseFileName . '.inc';

		if( !( ( @file_exists($languageFileName) ) && ( is_readable($languageFileName) ) ) )
		{
			$fp = fopen($languageFileName, 'w');
			fclose($fp);
		}
			// timestamp of the last modification time of the language file
			$tsLastModified = @filemtime($languageFileName);

			$compiledFileNamePrefix = _CACHE_DIR_ . '/' . $lang . '.inc.compiled.';
			$compiledFileName = $compiledFileNamePrefix . $tsLastModified;

			// checking if the compiled file is still valid
			if( ! @file_exists($compiledFileName) )
			{
				// the file doesn't exist or it's too old. We delete old compile files
				foreach( glob($compiledFileNamePrefix . '*') as $fileName )
				{
					@unlink($fileName);
				}

				// we try to create the compiled language file
				try {
					$this->createCompiledLanguageFile( $languageFileName, $compiledFileName );
				} catch (Exception $e) {
					throw new Exception($e->getMessage());
				}
			}
			else
			{
				// the compiled file is still valid, we use it
				$s = @file_get_contents($compiledFileName);

				if( ! $s )
				{
					throw new Exception('The compiled language file '.$compiledFileName.' could not be read');
				}

				// data is stored as serialized in the compiled file
				$this->_langData = unserialize($s);
			}
#		}
#		else
#		{
#			throw new Exception('Language file '.$languageFileName.' doesn\'t exist');
#		}
	}

	/**
	 * Reads the language data and compiles the language file so it can be parsed faster later
	 * @param string $languageFileName
	 * @param string $compiledFileName
	 * @return boolean
	 * @throws Exception
	 * @version 1.0.0
	 */
	private function createCompiledLanguageFile( $languageFileName, $compiledFileName )
	{
		// reading the language file into an array
		$a = @file($languageFileName, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );

		if( $a === false )
		{
			throw new Exception('Language file '.$languageFileName.' could not be read');
		}

		// empty the language data
		$this->_langData = array();

		// parses each line of the language file
		for( $i = 0; $i < count($a); $i++)
		{
			// each valid translation line should have the following format:
			// "text","translation"
			if( preg_match('/^"(.*)","(.*)"$/', $a[$i], $m) )
			{
				$this->_langData[$m[1]] = $m[2];
			}
		}
		// saves the compiled file
		if( ! @file_put_contents($compiledFileName, serialize($this->_langData)) )
		{
			throw new Exception('Error saving compiled language file '.$compiledFileName);
		}

		return true;
	}
	
	/**
	 * Returns the translation for the specified text
	 * 
	 * The translation can contain {variables} which will be replaced if the $replace parameter is set:
	 * Ex. $replace = array( '{variable}' => 'value' )
	 * 
	 * @param string $text
	 * @param array $replace
	 * @return string
	 */
	public function get( $text = '', $replace = array() )
	{
		// If the translation data doesn't contain the translation for a specific text, we mark the translation file as needing saving.
		// The translation file will be saved on object destruction
		if( ! isset($this->_langData[$text]) )
		{
			$this->_needSave = true;
			$this->_langData[$text] = $text;
		}

		$translation = $this->_langData[$text];

		// If we have elements in the $replace array, we do a search and replace
		if( count($replace) > 0 )
		{
			$searchFor = array_keys( $replace );
			$replaceWith = array_values( $replace );

			return str_replace($searchFor, $replaceWith, $translation);
		}
		else
		{
			return $translation;
		}
	}

	/**
	 * Saves the language file
	 * @param string $lang
	 * @return boolean
	 * @throws Exception
	 * @version 1.0.0
	 */
	private function saveLanguage( $lang )
	{
		$baseFileName = _LANG_DIR_ . '/' . $lang;

		$languageFileName = $baseFileName . '.inc';

		if( ! $f = @fopen( $languageFileName, "wt" ) )
		{
			throw new Exception("Could not save the language file ".$languageFileName);
		}

		// file header
		fprintf($f, "// This file stores the translation for %s\n//\n", $lang);
		fprintf($f, "// Valid lines have the following format:\n// \"application text\",\"translation text\"\n//\n");
		fprintf($f, "// Lines not conforming to this format will be ignored\n\n", $lang);

		foreach( $this->_langData as $text => $translation )
		{
			fprintf($f, "\"%s\",\"%s\"\n", $text, $translation);
		}

		fclose($f);

		return true;
	}

	/**
	 * Check if a language has been specified in URL or in session
	 *
	 * @access private
	 */
	private function _checkLanguageOverride()
	{
		// change the application language if specified or present in session
		$input = new Input();
		if( $_lang = $input->get('lang') )
		{
			// permit only known languages (security, to prevent directory traversal)
			foreach( glob(_LANG_DIR_ . '/*.inc') as $fileName )
			{
				if( $_lang . '.inc' === basename($fileName) )
				{
					$session = new Session();
					$session->set('lang', $_lang);

					unset($session);

					break;
				}
			}
		}
		unset($input);

		// check if we have a new language in the session
		$session = new Session();
		if( $_lang = $session->get('lang') )
		{
			Config::set('lang', $_lang );
		}

		// destroy the session object so that the session is closed
		unset($session);
	}

	/**
	 * Class destructor.
	 *
	 * Saves the language file if needed
	 *
	 */
	public function __destruct()
	{
		// If we need to save the translation data, we save it
		if( $this->_needSave == true )
		{
			try {
				$this->saveLanguage( $this->_lang );
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
}

/**
 * Shorthand for translation (calls Lang::get)
 * @param type $text
 * @param type $replace 
 */
function __( $text = '', $replace = array() )
{
	$lang = Lang::getInstance();
	
	try {
		$return = $lang->get( $text, $replace );
	} catch (Exception $e) {
		echo $e->getMessage();
		$return = $text;
	}

	return $return;
}