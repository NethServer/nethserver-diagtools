<?php
namespace NethServer\Module\DiagTools;

use Nethgui\System\PlatformInterface as Validate;

/**
* Implement gui module for diagnostic tools
 */

class  ExternalIP extends \Nethgui\Controller\AbstractController
{

    private $report;


    private function getReport()
    {
        return $this->getPlatform()->exec('/usr/bin/sudo dig +short myip.opendns.com @resolver1.opendns.com')->getOutput();
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
