<?
/**
 * Configuration class
 * 
 */
class Config
{
	/**
	 * Gets the value of the specified configuration variable
	 * 
	 * Throws an exception if the configuration variable is not set
	 * 
	 * @global array $config
	 * @param string $variable
	 * @return boolean 
	 */
	public static function get( $variable )
	{
		global $config;
		
		if( isset($config[$variable]) ) return $config[$variable];
		
		return false;
	}
	
	public static function getKey( $variable, $key )
	{
		global $config;
		
		if( isset($config[$variable]) && isset($config[$variable][$key]) ) {
			return $config[$variable][$key];
		}
		
		return false;
	}
	
	/**
	 * Sets the value of a configuration variable.
	 * 
	 * Functionality not implemented (not needed yet)
	 * 
	 * @param string $variable
	 * @param string $value
	 * @return bool
	 */
				public static function set( $variable, $value )
				{
								global $config;
							
								$config[$variable] = $value;
							
								return true;
				}
	
				public function load($file) {
								global $config;
								if (isset($config[$file]))
												return $config[$file];
								
								$fileName = _APP_DIR_ . '/conf/'.$file.'.php';
								if (file_exists($fileName)) {
											include $fileName;
											$config[$file] = $data;
#var_dump($fileName, $data);exit;
											return $data;
								}
								
								return null;
				}
				
	
}