<?php

require_once dirname(__FILE__).'/PhpHelper.php';

class ClassMapper {
    
	private $rootPath;
	
	private $files = null;
	
	private $map = null;
	
	public function __construct($path) {
		$this->rootPath = $path;
	}
	
	public function getMap() {
	    if (is_null($this->map)) {
    	    $this->map = array();
    	    foreach ($this->getFiles() as $file) {
                $info = phpHelper::getClassInfo(file_get_contents($file));
                if (!empty($info['class'])) {
                    $info['file'] = $file;
                    $this->map[] = $info;
                }
    	    }
	    }
	    return $this->map;
	}
	
	public function getFiles() {
	    if (is_null($this->files)) {
            $this->files = $this->findPhpFiles($this->rootPath);
	    }
	    return $this->files;
	}

	public function getMapByPrefix($prefix) {
	    $in = array();
	    foreach($this->getMap() as $info) {
	        if (empty($info['ns']) && substr($info['class'], 0, strlen($prefix)) == $prefix) {
	            $in[] = $info;
	        }
	    }
	    return $in;
	}
	
	public function getClassesInNamespace($ns) {
	    $names = array();
	    foreach($this->getMap() as $info) {
	        if ($info['ns'] == $ns) {
	            $names[] = $info['class'];
	        }
	    }
	    return $names;
	}
	
	public function getGlobalClassNames() {
	    $names = phpHelper::getPphpClassNames();
	    foreach($this->getMap() as $info) {
	        if (empty($info['ns'])) {
	            $names[] = $info['class'];
	        }
	    }
	    return $names; 
	}
	
	private function findPhpFiles($path) {
		$returnValue = array();
		$iterator = new DirectoryIterator($path);
		foreach ($iterator as $fileinfo) {
			if (!$fileinfo->isDot() && $fileinfo->getFilename() != '.svn') {
				$filename = $fileinfo->getFilename();
				if ($fileinfo->isFile()) {
					if (in_array(substr($filename, -4), array('.php','.tpl'))) {
						$returnValue[] = realpath($fileinfo->getPathname());
					}
				} else {
					$returnValue = array_merge($returnValue, $this->findPhpFiles($fileinfo->getPathname()));
				}
            }
		}
		return $returnValue;
	}
}