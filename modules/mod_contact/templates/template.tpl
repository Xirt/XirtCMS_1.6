<!-- xContactform [Start] //-->
<script type='text/javascript' src='modules/mod_contact/js/main.js'></script>
<div class='x-mod-contact{$xConf->css_name}'>

	<form action='{$location}' method='post' class='x-mod-contact-form'>

		<h2>{$xLang->titles['module']}</h2>
		<fieldset class='box-contact'>

			<label for='x_title'>{$xLang->labels['title']}</label>
			{html_options options=$xLang->options['titles'] name='x_title'}

			<br />

			<label for='x_name'>{$xLang->labels['name']}<b>*</b></label>
			<input type='text' name='x_name' maxlength='50' class='required' />

			<br />

			<label for='x_company'>{$xLang->labels['company']}</label>
			<input type='text' name='x_company' maxlength='50' />

			<br />

			<label for='x_email'>{$xLang->labels['email']}<b>*</b></label>
			<input type='text' name='x_email' maxlength='50' class='required validate-email' />

			<br />

			<label for='x_phone'>{$xLang->labels['phone']}</label>
			<input type='text' name='x_phone' maxlength='25' class='validate-phone' />

			<br />

			<label for='x_subject'>{$xLang->labels['subject']}<b>*</b></label>
			<input type='text' name='x_subject' maxlength='50' class='required' />

			<br />

			<label for='x_message'>{$xLang->labels['message']}<b>*</b></label>
			<textarea name='x_message' class='required'></textarea>

			<span class='required'>{$xLang->misc['required']}</span>

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='x_submit' value='1' />
			<input type='hidden' name='content' value='mod_contact' />

			<button type='submit'>{$xLang->buttons['submit']}</button>
			<button type='reset'>{$xLang->buttons['reset']}</button>

		</div>

	</form>

</div>
<!-- xContactform [End] //-->
