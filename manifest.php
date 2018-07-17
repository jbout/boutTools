<?php
/**  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA;
 *               
 * 
 */               
use jbout\boutTools\scripts\install\AddIdAction;
use jbout\boutTools\scripts\install\PreventSafePasswords;
use oat\Taskqueue\Action\InitRdsQueue;
use jbout\boutTools\scripts\install\SetTheme;

return array(
    'name' => 'boutTools',
	'label' => 'Boutools',
	'description' => 'Simple Tools and a DARRRK theme',
    'license' => 'GPL-2.0',
    'version' => '0.1.0',
	'author' => 'Open Assessment Technologies SA',
	'requires' => array(
        'ontoBrowser' => '>=2.7',
        'taoDevTools' => '>=2.8'
    ),
	'managementRole' => 'http://www.tao.lu/Ontologies/generis.rdf#boutToolsManager',
    'acl' => array(
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#boutToolsManager', array('ext'=>'boutTools')),
    ),
    'install' => array(
        'php' => array(
            SetTheme::class,
            InitRdsQueue::class,
            PreventSafePasswords::class,
            //AddIdAction::class,
        )
    ),
    'uninstall' => array(
    ),
    'routes' => array(
        '/boutTools' => 'jbout\\boutTools\\controller'
    ),    
	'constants' => array(
	    # views directory
	    "DIR_VIEWS" => dirname(__FILE__).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR,
	    
		#BASE URL (usually the domain root)
		'BASE_URL' => ROOT_URL.'boutTools/',
	    
	    #BASE WWW required by JS
	    'BASE_WWW' => ROOT_URL.'boutTools/views/'
	),
    'extra' => array(
        'structures' => dirname(__FILE__).DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'structures.xml',
    )
);