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

        return $this->getPlatform()->exec('/usr/bin/sudo /usr/bin/traceroute -I ' . $host)->getOutput();
    }

    public function initialize()
    {
        $this->declareParameter('Host', Validate::ANYTHING);
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
