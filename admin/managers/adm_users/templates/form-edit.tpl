<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_rank'>{$xLang->labels['rank']}</label>
      {html_options name=x_rank options=$rankList}

      <br />

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' name='x_name' value='' class='required' />

      <br />

      <label for='x_mail'>{$xLang->labels['mail']}</label>
      <input type='text' name='x_mail' value='' class='required validate-email' />

      <br />

      <label for='x_editor'>{$xLang->labels['editor']}</label>
      {html_options name=x_editor options=$xLang->options['editors']}

      <br />

      <label for='x_yubikey'>{$xLang->labels['yubikey']}</label>
      <input type='text' name='x_yubikey' value='' class='validate-alphanum' maxlength='12' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_users' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
