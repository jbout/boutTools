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

use oat\oatbox\extension\InstallAction;
use taoQtiTest_models_classes_QtiTestService;
use oat\generis\model\OntologyAwareTrait;
use oat\taoDeliveryRdf\model\DeliveryFactory;
use oat\taoDeliveryRdf\model\DeliveryAssemblyService;
use oat\ltiDeliveryProvider\model\delivery\DeliveryContainerService;
use oat\taoQtiItem\model\qti\metadata\MetadataService;
use oat\taoQtiItem\model\qti\metadata\importer\MetadataImporter;
use oat\tao\model\taskQueue\QueueDispatcher;
use oat\oatbox\service\ConfigurableService;
use oat\tao\model\taskQueue\QueueDispatcherInterface;
use oat\tao\model\taskQueue\Queue\Broker\InMemoryQueueBroker;
use oat\tao\model\taskQueue\TaskLogInterface;
use oat\tao\model\taskQueue\Queue\TaskSelector\WeightStrategy;
use oat\tao\model\taskQueue\Queue;
use oat\tao\model\entryPoint\EntryPointService;
use oat\taoDelivery\model\entrypoint\GuestAccess;
use oat\oatbox\log\LoggerService;
use oat\oatbox\log\LoggerAggregator;
use oat\oatbox\log\logger\TaoLog;

class SetupBenchmark extends InstallAction {
    
    use OntologyAwareTrait;

    public function __invoke($params) {
//        $old = $this->disableQueue();
        $this->simpleGuestBenchmark();
        $this->registerUdpLogger(6879);
//        $this->restoreQueue($old);
        return new \common_report_Report(\common_report_Report::TYPE_SUCCESS);
    }
    
    private function simpleGuestBenchmark(): void
    {
        $testUri = $this->importTest(ROOT_PATH.'taoQtiTest/test/samples/archives/QTI 2.2/basic/Basic.zip');
        $deliveryId = $this->compileTest($testUri);
        $this->setGuestAccess($deliveryId);
    }
    
    private function registerUdpLogger(int $port): void
    { 
        $logService = $this->getServiceLocator()->get(LoggerService::class);
        $logger = $logService->getLogger();
        if ($logger instanceof LoggerAggregator) {
            $options = $logger->getOptions();
            $options[] = new TaoLog(array(
                'appenders' => array(
                    array(
                        'class' => 'UDPAppender',
                        'host' => '127.0.0.1',
                        'port' => $port,
                        'threshold' => 1
                    )
                )
            ));
            $logger->setOptions($options);
        }
        $this->getServiceManager()->register(LoggerService::SERVICE_ID, $logService);
    }

    private function importTest(string $filePath): ?string
    {
        $this->disableGuardiansAndValidators();
        
        $testService = $this->getServiceLocator()->get(taoQtiTest_models_classes_QtiTestService::class);
        $testClass = $testService->getRootClass();
        $report = $testService->importMultipleTests($testClass, $filePath);
        
        $subReports = $report->getChildren();
        if (count($subReports) != 1) {
            throw new \Exception('Expected 1 test imported');
        }
        $testUri = reset($subReports)->getData()->rdfsResource->getUri();
        return $testUri;
    }
    
    private function compileTest(string $testUri): ?string
    {
        $deliveryFactory = $this->getServiceLocator()->get(DeliveryFactory::class);
        $deliveryFactory->setOption(DeliveryFactory::OPTION_PROPERTIES, []);
        $deliveryClass = $this->getServiceLocator()->get(DeliveryAssemblyService::class)->getRootClass();
        $service = $this->getServiceLocator()->get(DeliveryFactory::class);
        $report = $service->create($deliveryClass, $this->getResource($testUri));
        return $report->getData()->getUri();
    }
    
    private function disableGuardiansAndValidators(): void
    {
        $metadataservice = $this->getServiceLocator()->get(MetadataService::class);
        $importer = $metadataservice->getImporter();
        $importerOptions = $importer->getOptions();
        $importerClass = get_class($importer);
        $importerOptions[MetadataImporter::GUARDIAN_KEY] = [];
        $importerOptions[MetadataImporter::VALIDATOR_KEY] = [];
        $this->registerService(MetadataService::SERVICE_ID, new MetadataService([
            MetadataService::IMPORTER_KEY => new $importerClass($importerOptions),
            MetadataService::EXPORTER_KEY => $metadataservice->getExporter()
        ]));
    }
    
    private function setGuestAccess(string $deliveryId): void
    {
        $resource = $this->getResource($deliveryId);
        $resource->editPropertyValues($this->getProperty('http://www.tao.lu/Ontologies/TAODelivery.rdf#ProctorAccessible'), 'http://www.tao.lu/Ontologies/TAODelivery.rdf#ComplyDisabled');
        $resource->removePropertyValues($this->getProperty(DeliveryContainerService::TEST_RUNNER_FEATURES_PROPERTY));
        $resource->setPropertyValue($this->getProperty(DeliveryContainerService::PROPERTY_ACCESS_SETTINGS), DeliveryAssemblyService::PROPERTY_DELIVERY_GUEST_ACCESS);
        $entryService = $this->getServiceLocator()->get(EntryPointService::class);
        $entryService->addEntryPoint(new GuestAccess(), EntryPointService::OPTION_PRELOGIN);
        $this->registerService(EntryPointService::SERVICE_ID, $entryService);
    }
    
    private function disableQueue(): QueueDispatcherInterface
    {
        $old = $this->getServiceLocator()->get(QueueDispatcherInterface::SERVICE_ID);
        $this->registerService(QueueDispatcherInterface::SERVICE_ID, new QueueDispatcher([
            QueueDispatcherInterface::OPTION_QUEUES       => [
                new Queue('queue', new InMemoryQueueBroker())
            ],
            QueueDispatcherInterface::OPTION_TASK_LOG     => TaskLogInterface::SERVICE_ID,
            QueueDispatcherInterface::OPTION_TASK_TO_QUEUE_ASSOCIATIONS => [],
            QueueDispatcherInterface::OPTION_TASK_SELECTOR_STRATEGY => new WeightStrategy()
        ]));
        return $old;
    }
    
    private function restoreQueue(QueueDispatcherInterface $oldservice): void
    {
        $this->registerService(QueueDispatcherInterface::SERVICE_ID, $oldservice);
    }
    
}