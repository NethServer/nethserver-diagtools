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

class  NsLookup extends \Nethgui\Controller\AbstractController
{

    private $report;


    private function getReport()
    {
        if ($this->parameters['Host'] === '') {
            $host = 'nethserver.org';
        } else {
            $host = $this->parameters['Host'];
        }
        if (isset($host)) {
            return $this->getPlatform()->exec("/usr/bin/nslookup $host 2>&1")->getOutput();
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
