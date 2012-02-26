<div id='dvCreate' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<h2>{$xLang->headers['createDirectory']}</h2>

		<fieldset class='box-form'>

			<label for='nitem_name'>{$xLang->labels['name']}</label>
			<input type='text' name='nitem_name' id='nitem_name' value='' class='required validate-simple' />

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='content' value='adm_files' />
			<input type='hidden' name='task' value='create_directory' />
			<input type='hidden' name='path' value='' />

			<button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
