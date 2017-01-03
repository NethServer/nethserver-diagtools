<?php
namespace NethServer\Module\DiagTools;

use Nethgui\System\PlatformInterface as Validate;

/**
* Implement gui module for diagnostic tools
 */

class  TraceRoute extends \Nethgui\Controller\AbstractController
{

    private $report;


    private function getReport()
    {
        if ($this->parameters['Host'] === '') {
            $host = 'nethserver.org';
        } else {
            $host = $this->parameters['Host'];
        }

        if isset($host) {
            return $this->getPlatform()->exec("/usr/bin/sudo /usr/bin/traceroute -I -n --wait=3 $host 2>&1")->getOutput();
        }
    }

    public function initialize()
    {
        $vh = $this->createValidator()->orValidator($this->createValidator(Validate::HOSTADDRESS),
            $this->createValidator(\Nethgui\System\PlatformInterface::EMPTYSTRING));

        $this->declareParameter('Host', $vh);
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
