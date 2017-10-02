<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsSpeedTest_header'));

echo $view->selector('nic', $view::SELECTOR_DROPDOWN);
echo $view->textInput('server')->setAttribute('placeholder', $T('LeaveBlankForAutomatic'));;

echo $view->buttonList()
    ->insert($view->button('SpeedTest', $view::BUTTON_SUBMIT));

echo "<pre class='DiagTools_SpeedTest'>";
echo $view->textLabel('report');
echo "</pre>";


$view->includeCss('
    pre.DiagTools_SpeedTest {
        border: 2px solid #aaa;
        padding: 10px;
        width: 850px;
    }
');
