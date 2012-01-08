<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['addItem']}</h2>

   <fieldset class='box-form'>

      <label for='nx_name'>{$xLang->labels['name']}</label>
      <input type='text' name='nx_name' value='' class='required' />

      <br />

      <label for='nx_folder'>{$xLang->labels['folder']}</label>
      <input type='text' name='nx_folder' value='' class='required validate-simple' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_templates' />
      <input type='hidden' name='task' value='add_item' />

      <button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
