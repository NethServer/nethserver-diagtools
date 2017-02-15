<?php
namespace NethServer\Module\DiagTools;

use Nethgui\System\PlatformInterface as Validate;

/**
 * Implement gui module for diagnostic tools
 */

class  ScanHosts extends \Nethgui\Controller\AbstractController
{

    private $report;

    private function getReport()
    {
        $nic = $this->parameters['nic'];
        if (isset($nic)) {
            return $this->getPlatform()->exec("sudo /usr/sbin/arp-scan -I $nic -l")->getOutput();
        }
    }

    private function readNic()
    {
        static $interfaces;

        if (isset($interfaces)) {
            return $interfaces;
        }

        $nic = array();
        foreach ($this->getPlatform()->getDatabase('networks')->getAll() as $key => $values) {
            if (isset($values['role']) && $values['role'] == 'green') {
                #we can retrieve a value of a property instead of a key name
                # $ips[] = $values['ipaddr'];
                $nic[] = $key;
           }
            elseif (isset($values['role']) && $values['role'] == 'blue') {
                $nic[] = $key;
           }
        }
        return $nic;
    }

    public function initialize()
    {
        $this->declareParameter('nic', Validate::ANYTHING);
        parent::initialize();
    }

    public function bind(\Nethgui\Controller\RequestInterface $request)
    {
        parent::bind($request);
        $this->report = $this->getReport();
    }

    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);
        if (!$this->report) {
            $this->report = $this->getReport();
        }
        $view['report'] = $this->report;

        if (!$this->templates) {
            $this->templates = $this->readNic();
        }
        $view['nicDatasource'] = array_map(function($fmt) use ($view) {
            return array($fmt, $view->translate($fmt));
        }, $this->templates);
    }
}
