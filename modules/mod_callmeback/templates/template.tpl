<!-- xCallMeBack [Start] //-->
<script src='modules/mod_callmeback/js/main.js' type='text/javascript'></script>

{if $xConf->show_button}
   <div class='x-mod-callmeback{$xConf->css_name}'>
      <button type='button' action='new CallMeBack();'>{xLang->buttons['action']}</button>
   </div>
{/if}

<div id='xCallMeBack' class='x-mod-callmeback{$xConf->css_name}' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->titles['module']}</h2>

   <fieldset class='box-form'>

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' name='x_name' value='' class='required' />

      <br />

      <label for='x_company'>{$xLang->labels['company']}</label>
      <input type='text' name='x_company' value='' />

      <br />

      <label for='x_phone'>{$xLang->labels['phone']}</label>
      <input type='text' name='x_phone' value='' class='required validate-phone' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='mod_callmeback' />
      <input type='hidden' name='task' value='send_email' />

      <button type='submit'>{$xLang->buttons['request']}</button>
      <button type='button' class='close'>{$xLang->buttons['close']}</button>

   </div>

   </form>

</div>
<!-- xCallMeBack [End] //-->
