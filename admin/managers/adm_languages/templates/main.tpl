<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   <div class='box-tools'>
      <a href='javascript:;' onclick="XAdmin.showWindow('dvAdd');" title='{$xLang->headers['addItem']}' class='new' style='display: none;'>{$xLang->headers['addItem']}</a>
   </div>

   {XListBuilder::showTable(array('id', 'flag', 'iso', 'name', 'preference', 'status', 'options'))}

</div>
