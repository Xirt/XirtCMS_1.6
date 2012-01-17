<div class='xError'>

   {if !is_null($xConf) && $xConf->debugMode}

      <pre>
      Error {$data->error_no}: {$data->error_msg}
      {$data->error_src}:{$data->error_line}
      </pre>

   {elseif !is_null($xLang)}

      <h1>{$xLang->headers['error']}</h1>
      <span class='message'>{$xLang->bodies['error']}</span>

   {else}

      <h1>Fatal error</h1>
      <span class='message'>An unrecoverable error was detected. Please retry again in a few hours; an administrator has been alerted to review this problem.</span>

   {/if}

</div>
