<?php
namespace NethServer\Module\DiagTools;

use Nethgui\System\PlatformInterface as Validate;

/**
* Implement gui module for diagnostic tools
 */

class  NsLookup extends \Nethgui\Controller\AbstractController
{

    private $report;


    private function getReport()
    {
        return $this->getPlatform()->exec('/usr/bin/sudo /usr/bin/nslookup ' . $this->parameters['Host'])->getOutput();
    }

    public function initialize()
    {
        $this->declareParameter('Host', Validate::HOSTADDRESS, array('configuration', 'diagtools', 'nsLookup'));
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
    }
}
