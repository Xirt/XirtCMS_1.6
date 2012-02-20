<div id='dvItem' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<h2>{$xLang->headers['editItem']}</h2>

		<fieldset class='box-form'>

			<label for='x_name'>{$xLang->labels['name']}</label>
			<input type='text' name='x_name' id='x_name' value='' maxlength='64' class='required' />

			<br />

			<label for='x_parent_id'>{$xLang->labels['parent']}</label>
			<select name='x_parent_id' id='x_parent_id'>
				<option value='0'>{$xLang->misc['root']}</option>
			</select>

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='content' value='adm_menueditor' />
			<input type='hidden' name='task' value='edit_item' />
			<input type='hidden' name='id' value='' />

			<button type='submit' class='submit green left'>{$xLang->buttons['save']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
