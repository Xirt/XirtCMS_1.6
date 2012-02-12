<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   {XListBuilder::showLanguage($languageList)}

   <div class='box-tools'>
      <a href='javascript:;' onclick="new AddPanel();" title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('xid', 'title', 'category', 'status', 'mobile', 'options'))}

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

{include file="form-add.tpl"}

{include file="form-edit.tpl"}

{include file="form-config.tpl"}

{include file="form-access.tpl"}
