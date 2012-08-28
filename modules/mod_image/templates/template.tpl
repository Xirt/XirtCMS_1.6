<!-- xImage [Start] //-->
{if $script}<script src='modules/mod_image/js/main.js' type='text/javascript'></script>{/if}

<div class="x-mod-image{$xConf->css_name}">

   <div class="{$class}">

	{if $xConf->show_link}<a href="{$url}" title="{$xConf->alt}">{/if}
   {foreach from=$images item=image}
      <img src="{$xConf->folder}{$image}" alt="{$xConf->alt}" />
   {/foreach}
   {if $xConf->show_link}</a>{/if}

   </div>

</div>
<!-- xImage [End] //-->
