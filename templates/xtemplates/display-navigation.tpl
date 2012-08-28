<div class='box-pagination'>

	{if $link = $pagination->previous('&laquo;')} {$link}| {/if} <b>{$pagination->current()}</b>

	{if $link = $pagination->next('&raquo;')} |{$link} {/if}

</div>
