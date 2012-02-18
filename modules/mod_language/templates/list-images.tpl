<!-- xLanguage [Start] //-->
<div class="x-mod-language{$xConf->css_name}">

	{foreach from=$languages item=language}

		{if $language->iso == $iso}
		<a href="{$language->url}" title="{$language->name}" class="active"><img src="images/cms/flags/{$language->iso}.png" alt="{$language->name}" /> </a>
   	{else}
  		<a href="{$language->url}" title="{$language->name}"><img src="images/cms/flags/{$language->iso}.png" alt="{$language->name}" /> </a>
   	{/if}

	{/foreach}

</div>
<!-- xLanguage [End] //-->

