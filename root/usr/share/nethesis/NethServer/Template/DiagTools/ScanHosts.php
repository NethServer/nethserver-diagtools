<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsScanHost_header'));

echo $view->selector('nic', $view::SELECTOR_DROPDOWN);
echo $view->buttonList()
    ->insert($view->button('ScanHost', $view::BUTTON_SUBMIT));

echo "<pre class='DiagTools_ScanHost'>";
echo $view->textLabel('report');
echo "</pre>";


$view->includeCss('
    pre.DiagTools_ScanHost {
        border: 2px solid #aaa;
        padding: 10px;
        width: 750px;
    }
');
