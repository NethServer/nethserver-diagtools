<?php
namespace NethServer\Module\DiagTools;

use Nethgui\System\PlatformInterface as Validate;

/**
* Implement gui module for diagnostic tools
 */

class  SendMail extends \Nethgui\Controller\AbstractController
{

    private $report;


    private function getReport()
    {
        $d = $this->getPlatform()->getDatabase('configuration')->getType('DomainName');
        $sn = $this->getPlatform()->getDatabase('configuration')->getType('SystemName');

        if ($this->parameters['User'] === '') {
            $user = 'root';
        } else {
            $user = $this->parameters['User'];
        }
        return $this->getPlatform()->exec('/usr/bin/sudo echo "Subject: test email from '.$sn.'.'.$d
            . '" | /usr/lib/sendmail -f root -v ' . $user)->getOutput();
    }

    public function initialize()
    {
        $vu = $this->createValidator()->orValidator($this->createValidator(Validate::EMAIL),
                $this->createValidator(\Nethgui\System\PlatformInterface::EMPTYSTRING));
        $this->declareParameter('User', $vu);
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
