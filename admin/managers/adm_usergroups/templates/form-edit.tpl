<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_rank'>{$xLang->labels['rank']} *</label>
      {html_options options=$rankList name=x_rank id=x_rank}

      <br />

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' name='x_name' id='x_name' value='' maxlength='128' class='required' />

      <div class='box-affect'>

         * {$xLang->misc['affectAll']}

      </div>

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_usergroups' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
