<?php

/**
 * Utility Class for creating SEF links in content / template
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XSEF {

   /**
    * @var Array containing replaceable (special) characters
    */
   static $conversions = array (
      'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z',
      'Č' => 'C', 'č' => 'c', 'Ć' => 'C',  'ć' => 'c',  'À' => 'A', 'Á' => 'A',
      'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',  'Å' => 'A',  'Æ' => 'A', 'Ç' => 'C',
      'È' => 'E', 'É' => 'E', 'Ê' => 'E',  'Ë' => 'E',  'Ì' => 'I', 'Í' => 'I',
      'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N',  'Ò' => 'O',  'Ó' => 'O', 'Ô' => 'O',
      'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',  'Ù' => 'U',  'Ú' => 'U', 'Û' => 'U',
      'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B',  'ß' => 'Ss', 'à' => 'a', 'á' => 'a',
      'â' => 'a', 'ã' => 'a', 'ä' => 'a',  'å' => 'a',  'æ' => 'a', 'ç' => 'c',
      'è' => 'e', 'é' => 'e', 'ê' => 'e',  'ë' => 'e',  'ì' => 'i', 'í' => 'i',
      'î' => 'i', 'ï' => 'i', 'ð' => 'o',  'ñ' => 'n',  'ò' => 'o', 'ó' => 'o',
      'ô' => 'o', 'õ' => 'o', 'ö' => 'o',  'ø' => 'o',  'ù' => 'u', 'ú' => 'u',
      'û' => 'u', 'ý' => 'y', 'ý' => 'y',  'þ' => 'b',  'ÿ' => 'y', 'Ŕ' => 'R',
      'ŕ' => 'r', ' ' => '-'
      );


      /**
       * Returns input with replaced links
       *
       * @param String $str The input text
       * @return String The output text with replaced links
       */
      public static function parse($str) {
         global $xConf;

         if (!$xConf->sefUrls) {
            return $str;
         }

         // Find all links, replace if possible
         if (preg_match_all("/<a(.*)>/U", $str, $matches)) {

            $originals = array();
            $links = array();

            $list = $matches[1];
            foreach ($list as $link) {

               $regex = '#([^\s=]+)\s*=\s*(\'[^<\']*\'|"[^<"]*")#';
               if (!preg_match_all($regex, $link, $matches, PREG_SET_ORDER)) {
                  continue;
               }

               $attribs = (Object)array();
               foreach ($matches as $attr) {
                  $attribs->$attr[1] = $attr[2];
               }

               if (!isset($attribs->href) || !isset($attribs->title)) {
                  continue;
               }

               $name = strtolower($attribs->title);
               $name = html_entity_decode($name, ENT_QUOTES, "UTF-8");
               $name = str_replace(' ', '-', $name);
               $name = preg_replace('/[^a-zA-Z0-9_-]/', '', $name);

               $link      = preg_replace('/["\']/', '', $attribs->href);
               $candidate = html_entity_decode($urlLink, ENT_QUOTES, "UTF-8");

               // Relative internal link
               if (strpos($candidate, 'index.php') === 0) {

                  $links[] = XSEF::makeSEFLink($candidate, 0, $name);
                  $originals[] = $link;
                  continue;

               }

               // Absolute internal link
               if (strpos($candidate, $xConf->baseURL) === 0) {

                  $links[] = XSEF::makeSEFLink($candidate, 0, $name);
                  $originals[] = $link;
                  continue;

               }

            }

            $str = str_replace($originals, $links, $str);

         }

         return $str;
      }


      /**
       * Returns a link according to SEF settings
       *
       * @param $original The original link
       * @param $cId The cId of the original link
       * @param $name The SEF term to use (optional, defaults 'index')
       * @return String The URL according to SEF settings
       */
      public static function get($original, $cId = 0, $name = "index") {
         global $xConf, $xLinks;

         // Remove cId from original link
         if (!$uri = parse_url($original)) {
            return $original;
         }

         if (array_key_exists('query', $uri)) {

            parse_str($uri['query'], $args);
            if (!$cId && isset($args['cid'])) {

               $cId = intval($args['cid']);
               unset($args['cid']);

            }

            if (isset($args['lang'])) {
               unset($args['lang']);
            }

            ksort($args);
            $original = http_build_query($args);
         }

         // Create new SEF entry
         $xLinks = $xLinks ? $xLinks : new XLinkList();
         $xLinks->add($cId, $xConf->language, $original, $name);

         // Attempt to load new SEF entry
         if ($link = $xLinks->returnLinkByLink($original, $xConf->language)) {
            return $link->uri_sef;
         }

         return $original;
      }

}
?>