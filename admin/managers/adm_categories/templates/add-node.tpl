<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['addItem']}</h2>

   <fieldset class='box-form'>

      <label for='nx_name'>{$xLang->labels['name']}</label>
      <input type='text' name='nx_name' value='' maxlength='64' class='required' />

      <br />

      <label for='nx_parent_id'>{$xLang->labels['parent']}</label>
      <select name='nx_parent_id' id='nx_parent_id'>
         <option value='0'>{$xLang->misc['root']}</option>
      </select>

      <br />

      <label for='nx_language'>{$xLang->labels['language']}</label>
      {html_options options=$languages name=nx_language}

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_categories' />
      <input type='hidden' name='task' value='add_item' />

      <button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
