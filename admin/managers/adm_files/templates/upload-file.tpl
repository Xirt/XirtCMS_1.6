<div id='dvAdd' style='display: none;'>

	<form action='index.php' method='post' class='xForm' enctype='multipart/form-data' id='uForm'>

		<h2>{$xLang->headers['addItem']}</h2>

		<fieldset class='box-form'>

			<label for='nitem_file'>{$xLang->labels['name']}</label>
			<input type='file' name='nitem_file' id='nitem_file' class='file' value='' class='required' />

		</fieldset>

		<div id='uBar'></div>

		<div class='box-buttons' id='buttons-upload'>

			<input type='hidden' name='content' value='adm_files' />
			<input type='hidden' name='task' value='add_item' />
			<input type='hidden' name='path' value='' />

			<button type='submit' class='create green left'>{$xLang->buttons['upload']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
