<div id='dvPassword' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

	<h2>{$xLang->headers['resetPassword']}</h2>

	<fieldset class='box-form'>

		<input type='checkbox' name='randomizer' id='randomizer' value='0' class='checkbox' />
		{$xLang->misc['randomizePassword']}

	</fieldset>

	<div id='custom-password'>

		<h3>{$xLang->headers['definePassword']}</h3>
		<fieldset class='box-form'>

			<label for='x_password'>{$xLang->labels['password']}</label>
			<input type='password' name='x_password' id='x_password' value='' class='minLength:8 validate-password' />

			<br />

			<label for='x_password_rt'>{$xLang->labels['password']}</label>
			<input type='password' name='x_password_rt' value='' class="required validate-match matchInput:'x_password'" />

		</fieldset>

	</div>

	<div class='box-buttons'>

		<input type='hidden' name='content' value='adm_users' />
		<input type='hidden' name='task' value='reset_password' />
		<input type='hidden' name='id' value='' />

		<button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
		<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

	</div>

	</form>

</div>
