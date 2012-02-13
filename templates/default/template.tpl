<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
{XPage::addStylesheet('templates/default/css/main.css', 1)}
{XInclude::header()}
{XInclude::module('head')}
</head>

<body>

	<div class='box-container'>

		<div class='box-header'>
			<a href='http://www.xirtcms.com/' title="{$xLang->version}"	class='logo'>
				<img src='images/cms/logo.png' alt="{$xLang->version}" />
			</a>

			{XInclude::module('tools')}
		</div>

		{XInclude::module('menu')}

		<div class='box-body'>
			{XInclude::component()}
			{XInclude::module('content')}
		</div>

	</div>

	<div class='box-bottom'>
		{$xLang->version} | <a href='http://www.gnu.org/licenses/gpl.html' title='GNU General Public License v3.0' class='external'>GNU General Public License v3.0</a>
		{XInclude::module('footer')}
	</div>

	{XInclude::statistics()}

</body>

</html>