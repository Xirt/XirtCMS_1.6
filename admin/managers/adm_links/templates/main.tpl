<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   {XListBuilder::showLanguage($languageList)}

   <div class='box-tools'>
      <a href='javascript:;' onclick="new AddPanel();" title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'uri_sef', 'uri_ori', 'cid', 'options'))}

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}
