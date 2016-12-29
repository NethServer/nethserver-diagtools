<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsNsLookup_header'));

echo $view->textInput('Host');

echo $view->buttonList()
    ->insert($view->button('Run', $view::BUTTON_SUBMIT));
//    ->insert($view->button('Help', $view::BUTTON_HELP));

echo "<pre class='DiagTools_NsLookup'>";
echo $view->textLabel('report');
echo "</pre>";


$view->includeCss('
    pre.DiagTools_NsLookup {
        border: 2px solid #aaa;
        padding: 10px;
        width: 750px;
    }
');
