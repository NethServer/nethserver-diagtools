<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsIpAdd_header'));

//echo $view->buttonList()
//    ->insert($view->button('Run', $view::BUTTON_SUBMIT));
//    ->insert($view->button('Help', $view::BUTTON_HELP));

echo "<pre class='DiagTools_IpAddr'>";
echo $view->textLabel('report');
echo "</pre>";


$view->includeCss('
    pre.DiagTools_IpAddr {
        border: 2px solid #aaa;
        padding: 10px;
        width: 750px;
    }
');
