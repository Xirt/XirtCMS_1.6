<?php

/**
 * Object containing details about a XirtCMS template
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Template extends XItem {

   const LOCATION = "%stemplates/%s/";


   /**
    * @var Default selected pages
    */
   var $pages = '|all|';


   /**
    * @var Default template locations
    */
   var $positions = '||';


   /**
    * Create template structure in the file system for this template
    *
    * @return boolean True on success, false on failure
    */
   public function create() {
      global $xCom;

      $path = self::_getPath($this->folder);

      // Check file system / path
      if (!$path || !self::_isAvailable($path)) {
         return !print($xCom->xLang->messages['creationFailure']);
      }

      // Create template structure
      $template = array();
      $template[] = new XDir($path);
      $template[] = new XDir($path . 'css/');
      $template[] = new XDir($path . 'images/');
      $template[] = new XFile($path, 'index.tpl.php');

      foreach ($template as $element) {

         if (!$element->create()) {

            $template[0]->delete();
            return !print($xCom->xLang->messages['creationFailure']);

         }

      }

      return true;
   }

   /**
    * Relocates the current template in the file system
    *
    * @return boolean True on success, false on failure
    */
   public function relocate($folder) {
      global $xCom;

      // Check path
      $newDir = self::_getPath($folder);
      if ($this->folder != $folder && !self::_isAvailable($newDir)) {
         return !print($xCom->xLang->messages['renameFailure']);
      }

      // Check rename
      $oldDir = new XDir(self::_getPath($this->folder));
      if ($this->folder != $folder && !$oldDir->rename($newDir)) {
         return !print($xCom->xLang->messages['renameFailure']);
      }

      return true;
   }


   /**
    * Loads item information from the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__templates', $id);

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      parent::saveToDatabase('#__templates');

   }


   /**
    * Removes item from the database
    */
   public function remove() {
      global $xCom;

      if ($this->active) {
         return !print($xCom->xLang->messages['noActiveRemoval']);
      }

      $template = new XDir(self::_getPath($this->folder));
      if ($template->exists() && !$template->delete()) {
         return !print($xCom->xLang->messages['removalFailure']);
      }

      parent::removeFromDatabase('#__templates');

   }


   /**
    * Toggles publication status
    */
   public function toggleStatus() {

      if (!$this->active) {

         $this->set('published', intval(!$this->published));
         $this->save();

      }

   }


   /**
    * Toggles activate status of item
    */
   public function toggleActive() {
      global $xDb;

      $query = "UPDATE #__templates
                SET published = 1,
                    active = 1
                WHERE id = {$this->id}";
      $xDb->setQuery($query);
      $xDb->query();

      if ($xDb->rowCount()) {

         $query = "UPDATE #__templates
                   SET active = 0
                   WHERE id != {$this->id}";
         $xDb->setQuery($query);
         $xDb->query();

      }

   }


   /**
    * Returns the path of the given template
    *
    * @access private
    * @param $folder Directory defined by the template settings (optional)
    * @return String containing the absolute location of the template directory
    */
   private function _getPath($folder = null) {
      global $xConf;

      $folder ? $folder : $this->folder;

      return sprintf(self::LOCATION, $xConf->baseDir, $folder);
   }


   /**
    * Checks the availability and validity of template path names
    *
    * @access private
    * @param $path Template directory to check
    * @return True when valid and available, false otherwhise
    */
   private static function _isAvailable($path) {
      global $xConf;

      $topDir = substr($path, strlen($xConf->baseDir) + 10, -1);
      if (XValidate::isSimpleChars($topDir)) {
         return !file_exists($path);
      }

      return false;
   }

}
?>