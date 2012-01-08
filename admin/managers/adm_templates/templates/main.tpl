<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   <div class='box-tools'>
      <a href='javascript:;' onclick="new AddPanel();" title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'name', 'folder', 'published', 'default', 'options'))}

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}

{include file="form-config.tpl"}
