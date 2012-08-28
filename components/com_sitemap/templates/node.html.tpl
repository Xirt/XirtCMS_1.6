{function name=sitemap_node}

<li><a href="{$node->link}" title="{$node->name}">{$node->name}</a></li>

{if $node->children}
<ul>{foreach from=$node->children item=child} {sitemap_node node=$child}
	{/foreach}
</ul>
{/if} {/function} {sitemap_node node=$node}
