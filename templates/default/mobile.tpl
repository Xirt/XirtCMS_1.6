<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
{XPage::addStylesheet('templates/default/css/mobile.css', 1)}
{XInclude::header()}
</head>

<body>

	<div class='box-container'>

		<div class='box-header'>
			<a href='http://www.xirtcms.com/' title="{$xLang->version}" class='logo'>
				<img src='images/cms/logo.png' alt="{$xLang->version}" />
			</a>
		</div>

		{XInclude::module('menu')}

		<div class='box-body'>
			{XInclude::component()}
		</div>

	</div>

	<div class='box-bottom'>
		{XInclude::module('footer')}
		{XInclude::module('tools')}
	</div>

</body>

</html>