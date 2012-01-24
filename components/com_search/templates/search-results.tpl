<div class='x-search'>

   <h2>{$xLang->headers['results']}</h2>

   {$xLang->misc['results']|sprintf:$data->terms:$result->count}

   {if $result->count}

      {foreach from=$result->results item=item}
      <fieldset class='box-results'>
         <legend>{$item->title}</legend>
         {$item->content}

         <a href='{$item->link}' title='{$xLang->misc['continue']}'>{$xLang->misc['continue']}</a>
      </fieldset>
      {/foreach}

	{/if}

</div>