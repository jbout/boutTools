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
 * Copyright (c) 2020 (original work) Open Assessment Technologies SA;
 *
 *
 */
namespace jbout\boutTools\scripts;

use taoQtiTest_models_classes_QtiTestService;
use oat\generis\model\OntologyAwareTrait;
use oat\oatbox\extension\AbstractAction;

class EvalBenchmark extends AbstractAction {

    public function __invoke($params)
    {
        $logDir = $params[0];
        $files = \tao_helpers_File::scandir($logDir, ['recursive' => true, 'absolute' => true]);
        sort($files);
        foreach ($files as $fileName) {
            echo PHP_EOL.$fileName.PHP_EOL;
            $metrics = $this->extractMetrics($fileName);
            foreach ($metrics as $entry) {
                echo str_pad($entry['endpoint'], 70, ' '). str_pad(isset($entry['default']) ? $entry['default'] : 0, 10, ' ').' '.str_pad(isset($entry['default_kv']) ? $entry['default_kv'] : 0, 10, ' ').PHP_EOL;
                //echo implode(' ', $entry).PHP_EOL;
            }
        }
    }
    
    public function extractMetrics($fileName) {
        $fn = fopen($fileName, "r");

        $entries = [];
        $entry = null;
        while(! feof($fn))  {
            $line = fgets($fn);
            $words = explode(' ', $line);
            if ($words[0] == 'Invoking') {
                if (!is_null($entry)) {
                    $entries[] = $entry;
                }
                $entry = ['endpoint' => $words[1]];
            } elseif (count($words) > 3 && ($words[1] == 'calls' || $words[1] == 'queries') && $words[2] == 'to') {
                $entry[$words[3]] = $words[0];
            }
        }
        if (!is_null($entry)) {
            $entries[] = $entry;
        }
        
        fclose($fn);
        return $entries;
    }
}