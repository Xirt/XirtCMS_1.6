<!-- xSitemap [Start] //-->
<div class='x-sitemap'>

<h1>{$xLang->titles['component']}</h1>

{foreach from=$menuList item=menu}

   <h2>{$menu->title}</h2>

   <ul>
   {foreach from=$menu->children item=node}
      {include file='node.html.tpl'}
   {/foreach}
   </ul>

{/foreach}

</div>
<!-- xSitemap [End] //-->
