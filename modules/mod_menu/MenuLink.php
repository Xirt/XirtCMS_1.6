<?php

/**
 * Class that shows a link in a menu
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class MenuLink {

   /**
    * @var The attributes for this link
    */
   private $_attribs = array();


   /**
    * Initializes the object
    *
    * @param $item Object with details about the link
    * @param $item Object with configuration for the module
    */
   function __construct($item, $config) {

      $this->config = $config;
      $this->label  = $item->name;
      $this->type   = $item->link_type;

      if ($item->active) {
         $this->setActive();
      }

      $this->_setClass($item);
      $this->_setTitle($item);
      $this->_setLink($item);

   }


   /**
    * Sets the correct link _attribsibutes for this link
    *
    * @access private
    * @param $item Object with details about the link
    */
   private function _setLink($item) {

      switch ($item->link_type) {

         default:
            $uri = XTools::createLink($item->link, $item->xid, $item->name);
            break;

         case 3:
            $uri = $item->link;
            $this->_attribs['rel'] = 'external';
            break;

         case 5:
         case 4:
            $uri = 'index.php?content=com_handler&amp;task=no_javascript';
            $this->_attribs['onclick'] = $item->link;
            break;

         case 6:
            $uri = '#';
            break;
      }

      $this->_attribs['href'] = $uri;

   }


   /**
    * Sets the class-_attribsibute for this link
    *
    * @access private
    * @param $item Object with details about the link
    */
   private function _setClass($item) {
      $this->_attribs['class'] = 'menuitem' . $item->css_name;
   }


   /**
    * Sets the id-_attribsibute for this link (active only)
    *
    * @access private
    */
   private function setActive() {
      $this->_attribs['id'] = 'active_menu' . $this->config->css_name;
   }


   /**
    * Sets the title-_attribsibute for the link
    *
    * @access private
    * @param $item Object with details about the link
    */
   private function _setTitle($item) {
      $this->_attribs['title'] = $item->name;
   }


   /**
    * Shows the link
    */
   public function show() {

      // Fake link
      if ($this->type == 7) {
         return print($this->label);
      }

      // Normal link
      $attribs = array();
      foreach ($this->_attribs as $attrib => $value) {
         $attribs[] = sprintf('%s="%s"', $attrib, $value);
      }

      printf("<a %s>%s</a>", implode(' ', $attribs), $this->label);

   }

}
?>