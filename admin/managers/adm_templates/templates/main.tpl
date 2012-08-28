<h1>{$xLang->titles['component']}</h1>

<link type='text/css' href='managers/adm_templates/templates/css/main.css' rel='stylesheet' />
<script type='text/javascript' src='managers/adm_templates/templates/js/viewer.js'></script>
<script type='text/javascript' src='managers/adm_templates/templates/js/manager.js'></script>

<div class='listBox'>

   <div class='box-tools'>
      <a href='javascript:;' onclick="new AddPanel();" title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'name', 'folder', 'published', 'default', 'options'))}

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}

{include file="form-config.tpl"}
