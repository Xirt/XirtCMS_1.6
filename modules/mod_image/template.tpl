<!-- xImage [Start] //-->
{if !$defined}<script src='modules/mod_image/js/main.js' type='text/javascript'></script>{/if}

<div class="{$class} x-mod-image{$xConf->css_name}">

	{if $xConf->show_link}<a href="{$location}" title="{$xConf->alt}">{/if}
   {foreach from=$images item=image} <img src="{$xConf->folder}{$image}" alt="{$xConf->alt}" /> {/foreach}
   {if $xConf->show_link}</a>{/if}

</div>
<!-- xImage [End] //-->
