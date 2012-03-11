<div id='dvAccess' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<h2>{$xLang->headers['editAccess']}</h2>

		<fieldset class='box-form'>

			<label for='access_min'>{$xLang->labels['accessMin']}</label>
			{html_options name=access_min id=access_min options=$ranks} <br />

			<label for='access_max'>{$xLang->labels['accessMax']}</label>
			{html_options name=access_max id=access_max options=$ranks}

			<div class='box-affect'>

				<input type='checkbox' name='affect_all' value='1' class='checkbox' />
				{$xLang->misc['affectAll']}

			</div>

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='content' value='adm_menueditor' />
			<input type='hidden' name='task' value='edit_access' />
			<input type='hidden' name='xid' value='' />
			<input type='hidden' name='id' value='' />

			<button type='submit' class='submit green left'>{$xLang->buttons['save']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
