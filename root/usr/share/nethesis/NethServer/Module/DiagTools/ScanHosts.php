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

class  ScanHosts extends \Nethgui\Controller\AbstractController
{

    private $report;

    private function getReport()
    {
        $nic = $this->parameters['nic'];
        if (isset($nic)) {
            return $this->getPlatform()->exec(sprintf('/usr/bin/sudo /usr/sbin/arp-scan -I %s -l 2>&1', \escapeshellarg($nic)))->getOutput();
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
