<?php

class phpHelper {
    
    public static function getPphpClassNames() {
        return array("ZipArchive" , "SimpleXMLElement", "DOMDocument", "DOMXPath", "DOMElement", "ReflectionClass", "Exception");
    }
	
    /**
     * Returns an array that contains namespace and name of the class defined in the code
     *
     * Code losely based on http://stackoverflow.com/questions/7153000/get-class-name-from-file
     * by user http://stackoverflow.com/users/492901/netcoder
     *
     * @param string $content code to anaylse
     * @return array
     */
	public static function getClassInfo($content) {
	    $tokens = @token_get_all($content);
	    $class = $namespace = '';
	    $uses = array();
        for ($i=0;$i<count($tokens);$i++) {
            if ($tokens[$i][0] === T_NAMESPACE) {
                for ($j=$i+1;$j<count($tokens); $j++) {
                    if ($tokens[$j][0] === T_STRING) {
                        $namespace .= '\\'.$tokens[$j][1];
                    } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                        break;
                    }
                }
            }

            if ($tokens[$i][0] === T_CLASS) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if ($tokens[$j] === '{') {
                        if (!isset($tokens[$i+2][1])) {
                            error_log('Does not contain a valid class definition:');
                            break(2);
                        } else {
                            $class = $tokens[$i+2][1];
				break(2);
                        }
                    }
                }
            }
            
            if ($tokens[$i][0] === T_INTERFACE) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if ($tokens[$j] === '{') {
                        if (!isset($tokens[$i+2][1])) {
                            error_log('Does not contain a valid class definition');
                            break;
                        } else {
                            $class = $tokens[$i+2][1];
                        }
                    }
                }
            }
            
            if ($tokens[$i][0] === T_USE) {
                $useClass = '';
                $alias = '';
                for ($j=$i+1;$j<count($tokens); $j++) {
                    if ($tokens[$j][0] === T_STRING) {
                        $useClass .= '\\'.$tokens[$j][1];
                    } elseif ($tokens[$j][0] === T_AS) {
                        for ($k=$j+1;$k<count($tokens); $k++) {
                            if ($tokens[$k][0] === T_STRING) {
                                $alias = $tokens[$k][1];
                            } elseif ($tokens[$k] === '{' || $tokens[$k] === ';') {
                                $uses[$alias] = ltrim($useClass, '\\');
                                break;
                            }
                        }
                        break;
                    } elseif ($tokens[$j] === ';') {
                        $alias = substr($useClass, strrpos($useClass, '\\')+1);
                        $uses[$alias] = ltrim($useClass, '\\');
                        break;
                    }
                }
            }
	    }
	    return array(
	        'ns' => $namespace,
	        'class' => $class,
	        'uses' => $uses
	    );
	}
	
	public static function tokens2code($tokens) {
	    $code = "";
	    foreach ($tokens as $token) {
	        if (is_string($token)) {
	            $code .= $token;
	        } elseif (isset($token[1])) {
	            $code .= $token[1];
	        } else {
	            throw new Exception('Unsupported token format '.gettype($token));
	        }
	    }
	    return $code;
	}
	
}
