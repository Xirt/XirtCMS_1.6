<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   <div class='box-tools'>
      <a href='javascript:;' onclick='new AddPanel();' title='{$xLang->headers['addItem']}' class='adduser'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'rank', 'name', 'username', 'mail', 'joined', 'options'))}

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}
