<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' name='x_name' maxlength='128' class='required' />

      <hr />

      <div id='configuration'></div>

      <div class='box-affect'>

         <input type='checkbox' name='affect_all' value='1' />
         {$xLang->options['affectAll']}

      </div>

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_modules' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='xid' value='' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
