<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsSendMail_header'));

echo $view->textInput('User')->setAttribute('placeholder', 'root');

echo $view->buttonList()
    ->insert($view->button('SendMail', $view::BUTTON_SUBMIT));
//    ->insert($view->button('Help', $view::BUTTON_HELP));

echo "<pre class='DiagTools_SendMail'>";
echo $view->textLabel('report');
echo "</pre>";


$view->includeCss('
    pre.DiagTools_SendMail {
        border: 2px solid #aaa;
        padding: 10px;
        width: 750px;
    }
');
