<!-- xGoogleAnalytics [Start] //-->
<script type="text/plain" class="cc-onconsent-analytics">

   var _gaq = _gaq || [];
   _gaq.push(['_setAccount', '{$xConf->id}']);
   _gaq.push(['_setDomainName', '{$xConf->domain}']);
   _gaq.push(['_trackPageview']);

   {literal}
   (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
   })();
   {/literal}

</script>
<!-- xGoogleAnalytics [End] //-->
