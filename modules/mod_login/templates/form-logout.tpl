<!-- xLogin [Start] //-->
<div class='x-mod-login{$xConf->css_name}'>

	<form action='index.php' method='post'>

		<fieldset class='box-logout'>

			<legend>{$xLang->titles['logout']}</legend>

			{$xLang->misc['logout']}

			<div class='box-buttons'>

   			<input type='hidden' name='content' value='com_login' />
   			<input type='hidden' name='task' value='logout' />

				<button type='submit'>{$xLang->buttons['logout']}</button>

			</div>

		</fieldset>

	</form>

</div>
<!-- xLogin [End] //-->
