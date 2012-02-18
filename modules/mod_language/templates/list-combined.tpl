<!-- xLanguage [Start] //-->
<div class="x-mod-language{$xConf->css_name}">

	<ul>
		{foreach from=$languages item=language}
		<li>

   		{if $language->iso == $iso}
  			<a href="{$language->url}" title="{$language->name}" class="active"><img src="images/cms/flags/{$language->iso}.png" alt="{$language->name}" />{$language->name}</a>
   		{else}
  			<a href="{$language->url}" title="{$language->name}"><img src="images/cms/flags/{$language->iso}.png" alt="{$language->name}" />{$language->name}</a>
   		{/if}

		</li>
		{/foreach}
	</ul>

</div>
<!-- xLanguage [End] //-->
