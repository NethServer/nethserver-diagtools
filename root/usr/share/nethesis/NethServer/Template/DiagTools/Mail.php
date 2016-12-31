<?php
/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('DiagToolsSendMail_header'));
echo "<div id='bc_module_warning' class='ui-state-highlight'><span class='ui-icon ui-icon-info'></span>".$T('MailDeliverySystem_label')."</div>";

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
    #bc_module_warning {
     margin-bottom: 8px;
     padding: 8px;
  }

    #bc_module_warning .ui-icon {
        float: left;
        margin-right: 3px;
  }
');
