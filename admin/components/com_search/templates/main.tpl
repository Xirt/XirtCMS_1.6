<h1>{$xLang->titles['component']}</h1>

<div class='box-list'>

	{XListBuilder::showLanguage($languages)}

	<div class='box-tools'>

		<a href='javascript:;' onclick="new ConfigPanel();" title='{$xLang->headers['engineSettings']}' class='settings'>{$xLang->headers['engineSettings']}</a>
		<a href='javascript:;' onclick="new AddPanel();" title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>

	</div>

	{XListBuilder::showTable(array('id', 'term', 'uri', 'impressions', 'options'))}

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}

{include file="form-config.tpl"}
