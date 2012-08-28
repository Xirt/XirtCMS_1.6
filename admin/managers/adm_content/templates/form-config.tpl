<div id='dvConfig' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<h2>{$xLang->headers['editConfig']}</h2>

		<fieldset class='box-form'>

			<label for='x_css_name'>{$xLang->labels['CSSName']}</label>
			<input type='text' name='x_css_name' maxlength='16' class='validate-simple' />

			<br />

			<label for='x_show_title'>{$xLang->labels['showTitle']}</label>
			{html_options name=x_show_title options=$options}

			<br />

			<label for='x_show_author'>{$xLang->labels['showAuthor']}</label>
			{html_options name=x_show_author options=$options}

			<br />

			<label for='x_show_created'>{$xLang->labels['showCreated']}</label>
			{html_options name=x_show_created options=$options}

			<br />

			<label for='x_show_modified'>{$xLang->labels['showModified']}</label>
			{html_options name=x_show_modified options=$options}

			<br />

			<label
				for='x_back_icon'>{$xLang->labels['backIcon']}</label> {html_options
			name=x_back_icon options=$options}

			<br />

			<label for='x_download_icon'>{$xLang->labels['downloadIcon']}</label>
			{html_options name=x_download_icon options=$options}

			<br />

			<label for='x_print_icon'>{$xLang->labels['printIcon']}</label>
			{html_options name=x_print_icon options=$options}

			<br />

			<label for='x_mail_icon'>{$xLang->labels['mailIcon']}</label> {html_options
			name=x_mail_icon options=$options}

			<div class='box-affect'>

				<input type='checkbox' name='affect_all' value='1' class='checkbox' />
				{$xLang->misc['affectAll']}

			</div>

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='content' value='adm_content' />
			<input type='hidden' name='task' value='edit_config' />
			<input type='hidden' name='xid' value='' />
			<input type='hidden' name='id' value='' />

			<button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
