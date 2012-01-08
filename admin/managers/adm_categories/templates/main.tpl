<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   {XListBuilder::showLanguage($languageList)}

   <div class='box-tools'>

      <a href='javascript:;' onclick='new AddPanel();' title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>

   </div>

   {XListBuilder::showTable(array('id', 'name', 'ordering', 'status', 'sitemap', 'mobile', 'options'))}

</div>

<div class='box-legend'>

   <div class='legend'>

      <div class='box-translation'></div>
      {$xMainLang->legends['translation']}

   </div>

   <div class='legend'>

      <div class='box-missing'></div>
      {$xMainLang->legends['noTranslation']}

   </div>

</div>

{include file="add-node.tpl"}

{include file="edit-node.tpl"}

{include file="edit-config.tpl"}

{include file="edit-access.tpl"}
