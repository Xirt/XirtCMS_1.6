<!-- xRSSFeed [Start] //-->
<div class="x-mod-rssfeed{$xConf->css_name}">

   {if isset($xConf->title)}
      <h3>{$xConf->title}</h3>
   {/if}

   <ul>
      {foreach from=$items item=item}
      <li><a href="{$item->location}" title="{$item->title}" rel="external">{$item->title}</a></li>   
      {/foreach}
   </ul>

</div>
<!-- xRSSFeed [End] //-->
