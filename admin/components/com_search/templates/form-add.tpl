<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['addItem']}</h2>

   <fieldset class='box-form'>

      <label for='nx_term'>{$xLang->labels['term']}</label>
      <input type='text' name='nx_term' value='' class='required' />

      <br />

      <label for='nx_uri'>{$xLang->labels['uri']}</label>
      <input type='text' name='nx_uri' value='' class='required' />

      <br />

      <label for='nx_impressions'>{$xLang->labels['impressions']}</label>
      <input type='text' name='nx_impressions' value='' class='required validate-digits' />

      <br />

      <label for='nx_language'>{$xLang->labels['ISO']}</label>
      {html_options options=$languageList name=nx_language}

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='com_search' />
      <input type='hidden' name='task' value='add_item' />

      <button type='submit' class='create left green'>{$xLang->buttons['create']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
