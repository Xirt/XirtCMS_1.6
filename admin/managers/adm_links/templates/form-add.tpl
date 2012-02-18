<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['addItem']}</h2>

   <fieldset class='box-form'>

      <label for='nx_alternative'>{$xLang->labels['alternative']}</label>
      <input type='text' name='nx_alternative' id='nx_alternative' value='' class='required' />

      <br />

      <label for='nx_query'>{$xLang->labels['query']}</label>
      <input type='text' name='nx_query' id='nx_query' value='' class='required' />

      <br />

      <label for='nx_cid'>{$xLang->labels['cid']}</label>
      <input type='text' name='nx_cid' id='nx_cid' value='' class='required validate-integer' />

      <br />

      <label for='nx_language'>{$xLang->labels['ISO']}</label>
      {html_options options=$languageList name=nx_language id=nx_language}

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_links' />
      <input type='hidden' name='task' value='add_item' />

      <button type='submit' class='create green left'>{$xLang->buttons['create']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
