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
 * Copyright (c) 2014 (original work) Open Assessment Technologies SA;
 *
 *
 */

// Platform themes
use oat\oatbox\service\ServiceManager;
use oat\tao\model\theme\ThemeService;
use jbout\boutTools\model\theme\DarkTheme;


// Platform themes
$serviceManager = ServiceManager::getServiceManager();
$themeService = $serviceManager->get(ThemeService::SERVICE_ID);
$themeService->setTheme(new DarkTheme());
$serviceManager->register(ThemeService::SERVICE_ID, $themeService);
