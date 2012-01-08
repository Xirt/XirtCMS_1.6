<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   <div class='box-tools' style='display: none;'>
      <a href='index.php?content=adm_extensions' title='{$xLang->manageExtensions}' class='extensions'>{$xLang->headers['manageExtensions']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'name', 'options'))}

</div>

{include file="form-access.tpl"}