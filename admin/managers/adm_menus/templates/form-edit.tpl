<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_title'>{$xLang->labels['title']}</label>
      <input type='text' name='x_title' id='x_title' value='' maxlength='128' class='required' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_menus' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
