<h1>{$xLang->titles['component']}</h1>

<div class='box-list'>

   {XListBuilder::showLanguage($languageList)}

   <div class='box-tools'>
      <a href='javascript:;' onclick="new AddPanel();" title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'term', 'uri', 'impressions', 'options'))}

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}
