<div id='dvAdd' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<h2>{$xLang->headers['addItem']}</h2>

		<fieldset class='box-form'>

			<label for='nx_title'>{$xLang->labels['title']}</label>
			<input type='text' name='nx_title' value='' maxlength='128' class='required' />

			<br />

			<label for='nx_category'>{$xLang->labels['category']}</label>
			<select name='nx_category'>
				<optgroup label='{$xLang->misc['optDefault']}'>
					<option value='0'>{$xLang->misc['noCategory']}</option>
				</optgroup>
				<optgroup label='{$xLang->misc['optCategories']}' id='nx_category'></optgroup>
			</select>

			<br />
			<label for='nx_language'>{$xLang->labels['language']}</label>
			{html_options options=$languages name=nx_language}

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='content' value='adm_content' />
			<input type='hidden' name='task' value='add_content' />

			<button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
