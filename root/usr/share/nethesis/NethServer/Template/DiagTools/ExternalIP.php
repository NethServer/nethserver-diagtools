<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsExternalIP_header'));

//echo $view->buttonList()
//    ->insert($view->button('Run', $view::BUTTON_SUBMIT));
//    ->insert($view->button('Help', $view::BUTTON_HELP));

echo "<pre class='DiagTools_ExternalIP'>";
echo $view->textLabel('report');
echo "</pre>";


$view->includeCss('
pre.DiagTools_ExternalIP {
    padding: 10px;
    font-size: 15px;
    color: red;
    }
');
