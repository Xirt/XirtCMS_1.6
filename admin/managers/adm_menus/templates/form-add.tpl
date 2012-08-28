<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['addItem']}</h2>

   <fieldset class='box-form'>

      <label for='nx_title'>{$xLang->labels['title']}</label>
      <input type='text' name='nx_title' id='nx_title' value='' maxlength='128' class='required' />

      <br />

      <label for='nx_language'>{$xLang->labels['language']}</label>
      {html_options options=$languages name=nx_language id=nx_language}

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_menus' />
      <input type='hidden' name='task' value='add_item' />

      <button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
