<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_uri_sef'>{$xLang->labels['uri_sef']}</label>
      <input type='text' name='x_uri_sef' id='x_uri_sef' value='' class='required' />

      <br />

      <label for='x_uri_ori'>{$xLang->labels['uri_ori']}</label>
      <input type='text' name='x_uri_ori' id='x_uri_ori' value='' class='required' />

      <br />

      <label for='x_cid'>{$xLang->labels['cid']}</label>
      <input type='text' name='x_cid' id='x_cid' value='' class='required validate-integer' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_links' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='iso' value='' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
