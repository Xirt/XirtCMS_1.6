<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' name='x_name' value='' class='required' />

      <br />

      <label for='x_folder'>{$xLang->labels['folder']}</label>
      <input type='text' name='x_folder' value='' class='required validate-simple' />

      <br />

      <label for='plist'>{$xLang->labels['pages']}</label>
      {html_options options=$pagesList name=pages id=pages multiple=multiple size=14}
      <input type='hidden' name='x_pages' value=''/>

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_templates' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
