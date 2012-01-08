<div id='dvConfig' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editConfig']}</h2>

   <fieldset class='box-form'>

      <table>
      <tr>
         <td>
            <input type='text' name='nx_position' id='nx_position' value='' />
         </td>

         <td class='mid-column'>
            <button type='button' id='button_add' class='right'>{$xLang->buttons['add']}</button><br />
            <button type='button' id='button_rem' class='left'>{$xLang->buttons['remove']}</button>
         </td>

         <td>
            {html_options options=$pagesList name=positions id=positions multiple=multiple size=14}
            <input type='hidden' name='x_positions' id='x_positions' value='' />
         </td>
      </tr>
      </table>

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_templates' />
      <input type='hidden' name='task' value='edit_config' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
