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
namespace jbout\boutTools\scripts\install;

// Platform themes
use oat\oatbox\extension\InstallAction;
use oat\generis\persistence\PersistenceManager;
use oat\taoTaskQueue\scripts\tools\InitializeQueue;
use oat\taoDevTools\models\persistence\SqlProxyDriver;
use oat\taoLti\models\classes\ResourceLink\LinkService;
use oat\taoLti\models\classes\ResourceLink\KeyValueLink;
use oat\taoLti\models\classes\user\LtiUserService;
use oat\taoLti\models\classes\user\KvLtiUserService;
use oat\ltiDeliveryProvider\model\execution\implementation\KvLtiDeliveryExecutionService;
use oat\ltiDeliveryProvider\model\execution\LtiDeliveryExecutionService;
use oat\generis\model\OntologyAwareTrait;
use oat\taoLti\models\classes\ConsumerService;
use oat\taoLti\models\classes\user\LtiUserFactoryService;
use oat\taoDelivery\model\execution\implementation\KeyValueService;
use oat\taoDelivery\model\execution\ServiceProxy;
use tao_models_classes_service_StateStorage;

class OptimizationSetup extends InstallAction {
    
    use OntologyAwareTrait;

    public function __invoke($params) {
        // use redis for KV
        /*
        $pm = $this->getServiceLocator()->get(PersistenceManager::SERVICE_ID);
        $pm->registerPersistence('default_kv', [
            'driver' => \common_persistence_PhpRedisDriver::class
            ,'host' => 'localhost'
        ]);
        $this->registerQueryTracker($pm);
        $this->getServiceManager()->register(PersistenceManager::SERVICE_ID, $pm);
        */
        
        $em = $this->getServiceLocator()->get(\common_ext_ExtensionsManager::SERVICE_ID);
        
        $this->registerService(tao_models_classes_service_StateStorage::SERVICE_ID, new \tao_models_classes_service_StateStorage([
            tao_models_classes_service_StateStorage::OPTION_PERSISTENCE => 'default_kv'
        ]));
        
        // check TQ
        if ($em->isEnabled('taoTaskQueue')) {
            $action = new InitializeQueue();
            $action->setServiceLocator($this->getServiceLocator());
            $action->__invoke(["--broker=rds","--persistence=default"]);
        }
        // check LTI
        if ($em->isEnabled('taoLti')) {
            $this->getServiceManager()->register(LinkService::SERVICE_ID, new KeyValueLink([
                KeyValueLink::OPTION_PERSISTENCE => 'default_kv'
            ]));
            $this->getServiceManager()->register(LtiUserService::SERVICE_ID, new KvLtiUserService([
                KvLtiUserService::OPTION_PERSISTENCE => 'default_kv',
                KvLtiUserService::OPTION_FACTORY_LTI_USER => LtiUserFactoryService::SERVICE_ID
            ]));
            $class = $this->getClass(ConsumerService::CLASS_URI);
            $class->createInstanceWithProperties([
                'http://www.tao.lu/Ontologies/TAO.rdf#OauthKey' => 'jisc.ac.uk',
                'http://www.tao.lu/Ontologies/TAO.rdf#OauthSecret' => 'secret' 
            ]);
        }
        if ($em->isEnabled('ltiDeliveryProvider')) {
            $this->getServiceManager()->register(LtiDeliveryExecutionService::SERVICE_ID, new KvLtiDeliveryExecutionService([
                KvLtiDeliveryExecutionService::OPTION_PERSISTENCE => 'default_kv'
            ]));
        }
        if ($em->isEnabled('taoDelivery')) {
            $this->getServiceManager()->register(ServiceProxy::SERVICE_ID, new KeyValueService([
                KeyValueService::OPTION_PERSISTENCE => 'default_kv'
            ]));
        }
    }
    
    public function registerQueryTracker(PersistenceManager $pm) {
        foreach ($pm->getOption(PersistenceManager::OPTION_PERSISTENCES) as $key => $config) {
            $pers = $pm->getPersistenceById($key);
            if ($pers instanceof \common_persistence_SqlPersistence) {
                $pm->registerPersistence($key.'_real', $config);
                $pm->registerPersistence($key, [
                    'driver' => SqlProxyDriver::class,
                    SqlProxyDriver::OPTION_PERSISTENCE => $key.'_real'
                ]);
            }
        }
    }
}