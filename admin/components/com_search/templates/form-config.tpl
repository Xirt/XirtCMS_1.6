<div id='dvConfig' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

	<h2>{$xLang->headers['engineSettings']}</h2>

	<fieldset class='box-form'>

		<label for='x_search_type'>{$xLang->labels['searchType']}</label>
		{html_options name=x_search_type options=$xLang->options['search'] selected=$configuration->search_type id='toggler'}

		<br />

		<label for='x_recording'>{$xLang->labels['recordTerms']}</label>

		<input type='radio' name='x_recording' value='1' class='radio' {if $configuration->recording}checked='checked'{/if}/>
		<span class='label-radio'>{$xLang->options['positive']}</span>
		<input type='radio' name='x_recording' value='0' class='radio' {if !$configuration->recording}checked='checked'{/if}/>
		<span class='label-radio'>{$xLang->options['negative']}</span>

		<br />

		<label for='x_default_value'>{$xLang->labels['defaultValue']}</label>
		<input type='text' name='x_default_value' value="{$configuration->default_value}" />

		<br />

		<label for='x_default_limit'>{$xLang->labels['defaultLimit']}</label>
		<input type='text' name='x_default_limit' value="{$configuration->default_limit}" class='required validate-digits' />

		<br />

		<label>{$xLang->labels['defaultMethod']}</label>
		<div id='method_0'>{html_options name=x_default_method_0 options=$xLang->options['normal'] selected=$configuration->default_method}</div>
		<div id='method_1'>{html_options name=x_default_method_1 options=$xLang->options['fulltext'] selected=$configuration->default_method}</div>

		<label for='x_titlelength'>{$xLang->labels['titleLength']}</label>
		<input type='text' name='x_titlelength' value="{$configuration->titlelength}" class='required validate-digits' />

		<br />

		<label for='x_textlength'>{$xLang->labels['textLength']}</label>
		<input type='text' name='x_textlength' value="{$configuration->textlength}" class='required validate-digits' />

		<br />

		<label for='x_node_id'>{$xLang->labels['nodeId']}</label>
		<input type='text' name='x_node_id' value="{$configuration->node_id}" class='required validate-digits' />

	</fieldset>

	<div class='box-buttons'>

		<input type='hidden' name='content' value='com_search' />
		<input type='hidden' name='task' value='edit_config' />

		<button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
		<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

	</div>

	</form>

</div>
