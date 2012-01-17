<table class='table-xlist' id='table' cellspacing='0'>
<tr>
   {foreach from=$columns item=column}
   <th class='cell-{$column}'>{$xLang->labels[$column]}</th>
   {/foreach}
</tr>
<tr>
   <td colspan='{$columns|count}' class='box-combined'>
      
      <div class='box-scroll'>

         <table cellspacing='0' class='table-xlist-content'>
         <tbody id='container'></tbody>
         </table>

      </div>

   </td>
</tr>
</table>
