<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <fieldset class='box-form'>

      <label for='x_term'>{$xLang->labels['term']}</label>
      <input type='text' name='x_term' value='' class='required' />

      <br />

      <label for='x_uri'>{$xLang->labels['uri']}</label>
      <input type='text' name='x_uri' value='' class='required' />

      <br />

      <label for='x_impressions'>{$xLang->labels['impressions']}</label>
      <input type='text' name='x_impressions' value='' class='required validate-digits' />

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='com_search' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='iso' value='' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
