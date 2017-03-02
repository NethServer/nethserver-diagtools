<?php
/*
 * Copyright (C) 2017 Stephane de Labrusse <stephdl@de-labrusse.fr>
 *
 * This script is part of NethServer.
 *
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License,
 * or any later version.
 *
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see COPYING.
 */

namespace NethServer\Module\DiagTools;

use Nethgui\System\PlatformInterface as Validate;

/**
* Implement gui module for diagnostic tools
 */

class  Mail extends \Nethgui\Controller\AbstractController
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
        return $this->getPlatform()->exec('echo "Subject: test email from '.$sn.'.'.$d
            . '" | /usr/lib/sendmail -f root -v ' . $user)->getOutput();
    }

    public function initialize()
    {
        $vu = $this->createValidator()->orValidator($this->createValidator(Validate::EMAIL),
                $this->createValidator()->memberOf('root',''));
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
