
<!-- xTagcloud [Start] //-->
<div class='x-mod-tagcloud'>

	{foreach from=$termList item=term} <a href='{$term->uri}'
		title='{$term->term}' class='cloud_{$term->group}'>{$term->term}</a>
	{/foreach}

</div>
<!-- xTagcloud [End] //-->
