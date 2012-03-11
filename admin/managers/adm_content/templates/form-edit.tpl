<div id='dvItem' style='display: none;'>

<form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editItem']}</h2>

   <div class='box-editor'>{$editor = XTools::showEditor('x_content')}</div>

   <div class='column-right' id='xOptions'>

      <h4 class='toggler'>
         <span class='arrow'></span>
         {$xLang->headers['optionsItem']}
      </h4>
      <div class='box-option'>

         <label for='x_title'>{$xLang->labels['title']}</label>
         <input
            type='text' name='x_title' value='' maxlength='128' class='required' />

         <br />

         <label for='x_category'>{$xLang->labels['category']}</label>
         <select name='x_category'>
            <optgroup label='{$xLang->misc['optDefault']}'>
               <option value='0'>{$xLang->misc['noCategory']}</option>
            </optgroup>
            <optgroup label='{$xLang->misc['optCategories']}' id='x_category'></optgroup>
         </select>

         <br />

         <label for='x_meta_title'>{$xLang->labels['meta_title']}</label>
         <input type='text' name='x_meta_title' value='' maxlength='128' />

      </div>

      <h4 class='toggler'>
         <span class='arrow'></span>
         {$xLang->headers['optionsSEO']}
      </h4>
      <div class='box-option meta'>

         <label for='x_meta_keywords'>{$xLang->labels['meta_keywords']}</label>
         <textarea name='x_meta_keywords' rows='3' cols='50' class='maxLength:256'></textarea>

         <br />

         <label for='x_meta_description'>{$xLang->labels['meta_description']}</label>
         <textarea name='x_meta_description' rows='3' cols='50' class='maxLength:256'></textarea>

      </div>

   </div>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_content' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right' id='xClose'>{$xLang->buttons['cancel']}</button>

   </div>

</form>

</div>