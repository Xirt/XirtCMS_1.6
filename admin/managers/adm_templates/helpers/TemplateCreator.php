<?php

/**
 * Class to create a new empty template
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TemplateCreator {

   /**
    * @var The default location of templates
    */
   const PATH_TEMPLATES = '%stemplates/%s/';


   /**
    * @var The folder to use for this template
	 *
	 * @access private
    */
   private $_folder = null;


   /**
    * Creates a new empty template
    *
    * @param String $folder The name of the new template folder
    */
   function __construct($folder) {
      global $xConf;

      $this->_folder = $folder;
      $this->_path = sprintf(self::PATH_TEMPLATES, $xConf->baseDir, $folder);

   }

   /**
    * Creates the actual template structure
    */
   public function execute() {

      // Create template structure
      $template = array();
      $template[] = new XDir($this->_path);
      $template[] = new XDir($this->_path . 'css/');
      $template[] = new XDir($this->_path . 'images/');
      $template[] = new XFile($this->_path, 'index.tpl.php');

      foreach ($template as $element) {

         if (!$element->create()) {

            $template[0]->delete();
            die($xCom->xLang->messages['creationFailure']);

         }

      }

   }

}
?>