<!-- xLogin [Start] //-->
<div class='x-mod-login{$xConf->css_name}'>

	<form action='index.php' method='post'>

		<fieldset class='box-login'>

			<legend>{$xLang->titles['login']}</legend>

			<label for='user_name'>{$xLang->labels['username']}</label>
			<input type='text' name='user_name' id='user_name' />

			<br />

			<label for='user_pass'>{$xLang->labels['password']}</label>
			<input type='password' name='user_pass' id='user_pass' />

			<div class='box-buttons'>

   			<input type='hidden' name='content' value='com_login' />
   			<input type='hidden' name='task' value='login' />

				<button type='submit'>{$xLang->buttons['login']}</button>

			</div>

		</fieldset>

	</form>

</div>
<!-- xLogin [End] //-->
