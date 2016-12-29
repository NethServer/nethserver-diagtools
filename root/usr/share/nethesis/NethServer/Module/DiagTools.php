<?php
namespace NethServer\Module;
/**
 * Implementation of diagnostic tools
 */
class DiagTools extends \Nethgui\Controller\TabsController
{
    protected function initializeAttributes(\Nethgui\Module\ModuleAttributesInterface $base)
    {
        return \Nethgui\Module\SimpleModuleAttributesProvider::extendModuleAttributes($base, 'Status', 50);
    }
    public function initialize()
    {
        parent::initialize();
        $this->loadChildrenDirectory();
    }
}
