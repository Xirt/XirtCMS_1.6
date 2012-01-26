<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>
   {foreach from=$nodes item=node}
   {if $node->level lt 10}

   <url>
      <loc>{$xConf->baseURL}{$node->link}</loc>
      <priority>{math equation='1.1 - x / 10' x=$node->level}</priority>
   </url>

   {/if}
   {/foreach}
</urlset>
