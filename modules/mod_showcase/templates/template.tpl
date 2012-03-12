<!-- xShowcase [Start] //-->
<div class='x-mod-showcase{$xConf->css_name}'>

	{foreach from=$images item=image key=thumbnail}
	<a href='{$xConf->folder}{$image}' rel='lightbox-{$id}'>
	   <img src='{$thumbnail}' alt='{$xConf->alt}' />
	</a>
   {/foreach}

</div>
<!-- xShowcase [End] //-->
