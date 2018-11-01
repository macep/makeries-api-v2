<?

class Autoloader
{
		/**
			* method to load a class file
			* 
			* @param string $class
			* @return boolean
			* @throws Exception 
			*/
		public static function load($class)
		{
				// if the class has already been loaded, we don't do anything
				if( class_exists($class, false) ) return;
				
					
				$fileName = _CORE_DIR_ . '/' .$class.'.php';
				if( file_exists($fileName) ) {
						require_once($fileName);
						return true;
				}
				
				$fileName = _LIB_DIR_ . '/my/' .$class.'.php';
				if( file_exists($fileName) ) {
						require_once($fileName);
						return true;
				}
				
/*
 *  // LA COMPONENTS IL VEI FOLOSI
 *		$fileName = _APP_DIR_ . '/classes/app/modules/'.strtolower($class).'/actions/actions.php';
				if( file_exists($fileName) ) {
						require_once($fileName);
						return true;
				}
		*/

				global $conf;
#var_dump($conf);exit;
				if( isset($conf['classmap'][$class]) ) {
#print '<br>';
#var_dump($conf['classmap'][$class]);
						require_once(_APP_DIR_.'/classes/'. $conf['classmap'][$class]);
						return true;
				}
				/*
				#var_dump($conf['classmap']);exit;
				#/*
				$fileName = _LIB_DIR_ . '/model/'.$class.'.php';
				var_dump($fileName);
				if( file_exists($fileName) ) {
						require_once($fileName);
						return true;
				}
				$fileName = _LIB_DIR_ . '/model/om/'.$class.'.php';
				var_dump($fileName);
				if( file_exists($fileName) ) {
						require_once($fileName);
						return true;
				}
				
				$fileName = _LIB_DIR_ . '/model/map/'.$class.'.php';
				var_dump($fileName);
				if( file_exists($fileName) ) {
						require_once($fileName);
						return true;
				}
				*/
				
				
/*				
				
				#var_dump($class);exit;
			
			// class filename
			$fileName = join("_", array_map("strtolower", preg_split("/(?<=\\w)(?=[A-Z])/", $class))) . '.class.php';
			
			// if we find the class in the lib folder, we load it from there
			if( file_exists(_LIB_DIR_ . '/' . $fileName) )
			{
				require_once($fileName);
				return true;
			}
			
			// if not, we assume the class is a module class
			$parts = array_map("strtolower", preg_split("/(?<=\\w)(?=[A-Z])/", $class));
		
			// if the number of parts is less than three, we don't know what kind of class it is
			if( count($parts) < 3 )
			{
				throw new Exception('Class ' . $class . ' not found.');
			}
		
			// the folder is always made from the first and last part of "parts"
			$folderArray = array(
									_MODULE_DIR_
									, $parts[0]
									, $parts[count($parts) - 1]
									);
			$folder = join("/", $folderArray);
		
			$fileName = join("_", array_slice($parts, 1)) . ".class.php";
		
			$fullFileName = $folder . '/'. $fileName;
		
			if( @file_exists($fullFileName) )
			{
				require_once($fullFileName);
				return true;
			}
			//
		
			$excelClass = _LIB_DIR_ . '/external/' . str_replace('_', '/', $class).'.php';
			if( @file_exists($excelClass) )
			{
				require_once($excelClass);
				return true;
			}
			$pdfClass = strtolower(_LIB_DIR_ . '/external/pdf/' . str_replace('_', '/', $class).'.php');
			if( @file_exists($pdfClass) )
			{
				require_once($pdfClass);
				return true;
			}
			// if we get here... we couldn't find the class, we throw an exception
			throw new Exception('Class ' . $class . ' not found.');
		*/	
		}
	
}