<?php

require_once dirname(__FILE__).'/ClassMapper.php';
require_once dirname(__FILE__).'/PhpHelper.php';

/**
 * Switch to namespaces
 * 
 * @author bout
 */
class Namespacer {
	
	private $root;
	
	private $destination;
	
	private $mapper;
	
	private $byFile = array();
	
	private $byClass = array();
	
	public function __construct($root) {
		$this->root = $root;
		$this->mapper = new ClassMapper($this->root);
	}
	
	public function namespaceify($classPrefix, $namespace) {
	    foreach($this->mapper->getMapByPrefix($classPrefix) as $info) {
	        $parts = explode('_', trim(substr($info['class'], strlen($classPrefix)), '_'));
	        $class = array_pop($parts);
	        $ns = rtrim($namespace,'\\').(empty($parts) ? '' : '\\'.implode('\\', $parts));
	        $newFile = dirname($info['file']).DIRECTORY_SEPARATOR.substr(basename($info['file']), strpos(basename($info['file']), '.')+1);
	        $this->byFile[$info['file']] = array(
	        	'addNamespace' => $ns,
	            'move' => $newFile
	        );
	        $this->byClass[$info['class']] = rtrim($ns, '\\').'\\'.$class;
	    }
	}
	
	public function showRenames() {
	    foreach ($this->byFile as $old => $info) {
	        echo str_pad($old, 100).' '.$info['move'].PHP_EOL;
	    }
	}

	public function showAffectedFiles() {
	    echo '====  Affected Files  ===='.PHP_EOL.PHP_EOL;
	    foreach ($this->mapper->getFiles() as $file) {
	        if ($this->isAffected($file)) {
                echo $file.PHP_EOL;
	        }
	    }
	}
		
	public function showClassReplacements() {
	    echo '====  Classes  ===='.PHP_EOL.PHP_EOL;
	    foreach ($this->byClass as $from => $to) {
	        echo str_pad($from, 100).$to.PHP_EOL;
	    }
	}
	
	protected function getReferencedGlobalClasses($file) {
	    $map = array_fill_keys($this->mapper->getGlobalClassNames(), '');
	    $tokens = token_get_all(file_get_contents($file));
	    
	    $found = array();
	    foreach ($tokens as $key => $token) {
	        if (is_array($token) && $token[0] == T_STRING && isset($map[$token[1]])) {
	            $found[$token[1]] = '';
	        }
	    }
	    return array_keys($found);
	}

	protected function getNewUses($globalClasses, $currentNs = null) {
	    $newUses = array();
	    foreach ($globalClasses as $className) {
    	    if (isset($this->byClass[$className])) {
    	        $classNs = substr($this->byClass[$className], 0, strrpos($this->byClass[$className], '\\'));
    	        if (is_null($currentNs) || $classNs != $currentNs) {
                    $newUses[] = $this->byClass[$className];
    	        }
    	    }
	    }
	    return $newUses;
	}

	public function simulate() {
	    foreach ($this->mapper->getFiles() as $file) {
	        if ($this->isAffected($file)) {
                $this->simulateFile($file);
	        }
	    }
	}
	
	public function simulateFile($file) {

        echo '====  '.$file.'  ===='.PHP_EOL;
        if (isset($this->byFile[$file]['move'])) {
            echo 'will be moved to '.$this->byFile[$file]['move'].PHP_EOL;
        }
        
        echo $this->getContent($file).PHP_EOL.PHP_EOL;
	}
	
	public function execute() {
	    foreach ($this->mapper->getFiles() as $file) {
	        if ($this->isAffected($file)) {
	            $newcode = $this->getContent($file); 
	            if (isset($this->byFile[$file]['move'])) {
	                file_put_contents($this->byFile[$file]['move'], $newcode);
	                unlink($file);
	            } else {
	                file_put_contents($file, $newcode);
	            }
	            echo 'done '.$file.PHP_EOL;
	        }
	    }
	}
	
	protected function getContent($file) {
	    $code = file_get_contents($file);
	    
	    $globalClasses = $this->getReferencedGlobalClasses($file);
	    if (isset($this->byFile[$file]['addNamespace'])) {
	        $code = $this->insertNamespace($code, $this->byFile[$file]['addNamespace']);
	        $newUses = $this->getNewUses($globalClasses, $this->byFile[$file]['addNamespace']);
	        // requires adding of all global classes
	        foreach ($globalClasses as $className) {
	            if (!isset($this->byClass[$className])) {
	                $newUses[] = '\\'.$className;
	            }
	        }
	    } else {
	        $newUses = $this->getNewUses($globalClasses);
	    }
	    
	    $info = phpHelper::getClassInfo($code);
	    
	    $oldMap = $info['uses'];
	    foreach ($info['uses'] as $alias => $className) {
	        if (isset($this->byClass[$className])) {
	            unset($oldMap[$alias]);
	        }
	    }
	    
	    // remove class names in current namespace
	    if (isset($info['ns'])) {
	        $blackList = $this->mapper->getClassesInNamespace($info['ns']);
	    } else {
	        $blackList =  array();
	    }
	    
	    // prevent duplicates
	    $map = array();
	    foreach (array_unique($newUses) as $use) {
	        $className = substr($use, strrpos($use, '\\')+1);
	        if (isset($map[$className]) || in_array($className, $blackList) || isset($oldMap[$className])) {
	            $i = 2;
	            do {
	            	$alternateName = $className.'_'.$i;
	            	$i++; 
	            } while (isset($map[$alternateName]) || in_array($alternateName, $blackList));
	            $map[$alternateName] = $use;
	        } else {
	            $map[$className] = $use;
	        }
	    }
	    
	    if (count($newUses) > 0) {
	        $fullMap = $oldMap;
	        foreach ($map as $alias => $class) {
	            $fullMap[$alias] = $class;
	        }
	        $code = $this->replaceUses($code, $fullMap);
	    }
	    
	    $code = $this->replace($code, $map);
	    return $code;
	}
	
	
	protected function insertNamespace($code, $namespace) {
	    $namespaceLine = "namespace ".$namespace.";".PHP_EOL.PHP_EOL;
	    
        $tokens = token_get_all($code);
        
        $first = reset($tokens);
        if (is_array($first) && $first[0] == T_OPEN_TAG) {
            // consume open tag
            $header= array(array_shift($tokens));
            
            // find and skip license
            $skip = true;
            do {
                $token = array_shift($tokens);
                if (is_string($token) || $token[0] == T_WHITESPACE) {
                    array_push($header, $token);                    
                } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT)) && strpos($token[1], "WITHOUT ANY WARRANTY")) {
                    array_push($header, $token);
                } else {
                    // put it back in
                    array_unshift($tokens, $token);
                    $skip = false;
                }
            } while (!empty($tokens) && $skip);
            return phpHelper::tokens2code($header).$namespaceLine.phpHelper::tokens2code($tokens);
        } else {
            return "<?php".PHP_EOL.$namespaceLine."?>".$code;
        }
	}
	
	protected function replaceUses($code, $uses) {
	    $usageLine = "";
	    asort($uses);
	    foreach ($uses as $alias => $className) {
	        $shortName = substr($className, strrpos($className, '\\')+1);
	        if ($alias == $shortName) {
	            $usageLine .= "use ".$className.";".PHP_EOL;
	        } else {
	            $usageLine .= "use ".$className." as ".$alias.";".PHP_EOL;
	        }
	    }
	    
	    $tokens = token_get_all($code);
	    
        $first = reset($tokens);
        if (is_array($first) && $first[0] == T_OPEN_TAG) {
            
            // search for uses and namespace
            $firstUse = null;
            $namespaced = false;
            foreach ($tokens as $key => $token) {
                if (is_null($firstUse) && is_array($token) && $token[0] == T_USE) {
                    $firstUse = $key;
                }
                if (is_array($token) && $token[0] == T_NAMESPACE) {
                    $namespaced = true;
                }
            }
            
            // no uses no namespace
            if (is_null($firstUse) && !$namespaced) {
                
                // find and skip license
                $skip = true;
                $header = array();
                do {
                    $token = array_shift($tokens);
                    if (is_string($token) || $token[0] == T_WHITESPACE || $token[0] == T_OPEN_TAG) {
                        array_push($header, $token);
                    } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT)) && strpos($token[1], "WITHOUT ANY WARRANTY")) {
                        array_push($header, $token);
                    } else {
                        // put it back in
                        array_unshift($tokens, $token);
                        $skip = false;
                    }
                } while (!empty($tokens) && $skip);
                
            // namespaced but no uses yet
            } elseif (is_null($firstUse)) {
                // skip till namespace
                $header = array();
                do {
                    $token = array_shift($tokens);
                    array_push($header, $token);
                } while ((is_string($token) || $token[0] != T_NAMESPACE) && !empty($tokens));
            
                // keep skipping to end of declaration
                do {
                    $token = array_shift($tokens);
                    array_push($header, $token);
                } while ((is_array($token) || $token != ';') && !empty($tokens));
                if (empty($tokens)) {
                    throw new Exception('No tokens after namespace?');
                }
                
            // already contains uses
            } else {
                $header = array_slice($tokens, 0, $firstUse);
                $rest = array();
                $inUse = false;
                foreach (array_slice($tokens, $firstUse) as $token) {
                    if ($inUse && $token === ';') {
                        $inUse = false;
                        continue;
                    } elseif (!$inUse && is_array($token) && $token[0] == T_USE) {
                        $inUse = true;
                        continue;
                    } else {
                        if (!$inUse) {
                            $rest[] = $token;
                        }
                    }
                    
                }
                $header = array_slice($tokens, 0, $firstUse);
                $tokens = $rest;
            }
            
            
            
            $left = rtrim(phpHelper::tokens2code($header), PHP_EOL);
            $right = ltrim(phpHelper::tokens2code($tokens),PHP_EOL);
            return $left.PHP_EOL.PHP_EOL.$usageLine.PHP_EOL.$right;
        } else {
            // generate block for usage
            return "<?php".PHP_EOL.$usageLine."?>".PHP_EOL.$code;
        }
	}
	
	protected function replace($code, $map) {
	    $aliasMap = array_flip($map);
	    $tokens = token_get_all($code);
	    foreach ($tokens as $key => $token) {
	        if (is_array($token)) {
	            switch ($token[0]) {
	            	case T_STRING:
	            	    if (isset($this->byClass[$token[1]])) {
	            	        if (isset($aliasMap[$this->byClass[$token[1]]])) {
	            	            $tokens[$key][1] = $aliasMap[$this->byClass[$token[1]]];
	            	        } else {
                                $tokens[$key][1] = substr($this->byClass[$token[1]], strrpos($this->byClass[$token[1]], '\\')+1);
	            	        } 
	            	    }
	            	    break;
        	        case T_CONSTANT_ENCAPSED_STRING:
        	        case T_ENCAPSED_AND_WHITESPACE;
        	            $string = substr($token[1], 1, -1);
	            	    if (isset($this->byClass[$string])) {
    	            	    $tokens[$key][1] = '\''.str_replace('\'', '\\\'', str_replace('\\', '\\\\', $this->byClass[$string])).'\'';
	            	    }
	            	    break;
    	            case T_COMMENT:
        	        case T_DOC_COMMENT:
        	            $tokens[$key][1] = str_replace(array_keys($this->byClass), array_values($this->byClass), $token[1]);
	            	    break;
	            }
	        }
	    }
	    return phpHelper::tokens2code($tokens);
	}
	
	protected function isAffected($file) {
        $lines = file($file);
        $found = array();
        foreach (array_keys($this->byClass) as $className) {
            foreach ($lines as $line) {
                if (strpos($line, $className)) {
                    return true;
                }
            }
        }
        return false;
	}

}