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
 * Copyright (c) 2013-2014 (original work) Open Assessment Technologies SA
 *
 */
namespace jbout\boutTools\controller;

use \tao_actions_CommonRestModule;
use oat\taoGroups\models\CrudGroupsService;
use oat\taoGroups\models\GroupsService;

/**
 * @author bout
 * Some usefull infos
 */
class Info extends \tao_actions_CommonModule
{

    public function getId()
    {
        $resource = new \core_kernel_classes_Resource($this->getRequestParameter('id'));
        $this->setData('label', $resource->getLabel());
        $this->setData('id', $this->getRequestParameter('id'));
        $this->setView('Info/getId.tpl');
    }

}