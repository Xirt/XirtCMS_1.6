<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['addItem']}</h2>

   <fieldset class='box-form'>

      <label for='nx_rank'>{$xLang->labels['rank']}</label>
      {html_options name=nx_rank options=$ranks}

      <br />

      <label for='nx_username'>{$xLang->labels['username']}</label>
      <input type='text' name='nx_username' value='' class='required validate-simple' />

      <br />

      <label for='nx_name'>{$xLang->labels['name']}</label>
      <input type='text' name='nx_name' value='' class='required' />

      <br />

      <label for='nx_mail'>{$xLang->labels['mail']}</label>
      <input type='text' name='nx_mail' value='' class='required validate-email' />

      <br />

      <label for='nx_editor'>{$xLang->labels['editor']}</label>
      {html_options name=nx_editor options=$xLang->options['editors']}

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_users' />
      <input type='hidden' name='task' value='add_item' />

      <button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
