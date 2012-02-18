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

      if (!$xConf->alternativeLinks) {
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

            // Only parse links with complete information
            if (!isset($attribs->href) || !isset($attribs->title)) {
               continue;
            }

            // Prepare parameters
            $name = trim($attribs->title);
            $href = preg_replace('/["\']/', '', $attribs->href);
            $link = html_entity_decode($href, ENT_QUOTES, "UTF-8");

            // Relative internal link
            if (strpos($link, 'index.php') === 0) {

               $links[] = XSEF::convert($link, 0, $name);
               $originals[] = $href;
               continue;

            }

            // Absolute internal link
            if (strpos($link, $xConf->baseURL) === 0) {

               $links[] = XSEF::convert($link, 0, $name);
               $originals[] = $href;
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
    * @param $cId The cId of the original link (optional, defaults '0')
    * @param $name The SEF term to use (optional, defaults 'index')
    * @return String The URL according to SEF settings
    */
   public static function convert($original, $cId = 0, $name = "index") {
      global $xConf, $xLinks;

      // Prepare original link
      if (!$query = self::_originalToQuery($original, $cId)) {
         return $original;
      }

      // Retrieve SEF alternative
      if (!$link = $xLinks->returnLinkByQuery($query, $xConf->language)) {

         $link = new XLink();
         $link = $link->create($query, $name, $cId, $xConf->language);
         $xLinks->add($link);

      }

      return $link->alternative;
   }


   /**
    * Parses original link and returns formatted query
    *
    * @access private
    * @param $original The original link
    * @param $cId The cId of the original link (optional)
    * @return The formatted query (without iso/cid and alphabetically sorted)
    */
   private static function _originalToQuery($original, $cId) {

      if (!($uri = parse_url($original)) || !array_key_exists('query', $uri)) {
         return false;
      }

      parse_str($uri['query'], $args);

      // Strip / retrieve cId
      if (isset($args['cid'])) {

         $cId = $cId ? $cId : intval($args['cid']);
         unset($args['cid']);

      }

      // Strip language
      if (isset($args['lang'])) {
         unset($args['lang']);
      }

      ksort($args);
      return http_build_query($args);
   }

}
?>