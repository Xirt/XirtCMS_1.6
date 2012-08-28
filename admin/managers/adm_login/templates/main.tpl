<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
{XInclude::header()}
</head>

<body>

<div class='bar-main'>

   <form action='index.php' method='post' id='form-login' class='xForm'>

      <div class='box-login'>

			<a href='http://www.xirtcms.com' title="{$xMainLang->version}" rel='external'>
			   <img src='../images/cms/logo.png' alt="{$xMainLang->version}" />
			</a>

         <div class='box-content'>

            {$xLang->texts['login']}

			<fieldset>

               <label for='user_name'>{$xLang->labels['username']}</label>
               <input type='text' name='user_name' id='user_name' />

               <label for='user_pass'>
                  {$xLang->labels['password']}
                  <span class='password'>(<a href='javascript:;' title="{$xLang->messages['forgotPassword']}" id='a-password'>{$xLang->messages['forgotPassword']}</a>)</span>
               </label>
               <input type='password' name='user_pass' id='user_pass' />

			</fieldset>

            <div class='box-buttons'>

               <input type='hidden' name='content' value='adm_login' />
               <input type='hidden' name='task' value='attempt_login' />

               <button type='submit'>{$xLang->buttons['login']}</button>

            </div>

         </div>

      </div>

   </form>

</div>

<div id='dvRequestPassword' style='display: none;'>

   <form action='index.php' method='post' id='passwordForm' class='xForm'>

   <h2>{$xLang->titles['forgotPassword']}</h2>

   {$xLang->texts['forgotPassword']}

   <fieldset class='formBox'>

      <label for='request_name'>{$xLang->labels['username']}</label>
      <input type='text' name='request_name' id='request_name' title='{$xLang->messages['nameFail']}' class='required' />

      <label for='request_mail'>{$xLang->labels['email']}</label>
      <input type='text' name='request_mail' id='request_mail' title='{$xLang->messages['mailFail']}' class='required validate-email' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_login' />
      <input type='hidden' name='task' value='request_password' />

      <button type='submit' class='submit green left'>{$xLang->buttons['request']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>

</body>

</html>