<?php

/**
 * Manager for XirtCMS users
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * Adds a user
    */
   public static function addItem() {
      global $xCom, $xConf, $xUser;

      $password = XTools::generatePassword();
      $content  = (object) $xCom->xLang->mailCreate;

      $user = new User();
      $user->set('rank',     XTools::getParam('nx_rank', 0, _INT));
      $user->set('rank',     min($xUser->rank, $user->rank));
      $user->set('name',     XTools::getParam('nx_name'));
      $user->set('mail',     XTools::getParam('nx_mail'));
      $user->set('editor',   XTools::getParam('nx_editor', 0, _INT));
      $user->set('username', XTools::getParam('nx_username'));
      $user->set('password', hash($xConf->hashAlgorithm, $password));

      $list = new UserList();
      $list->load();

      if ($list->add($user)) {

      	// Generate mail content
	      $body = new XAdminTemplate('adm_users');
	      $body->assign('xUser', $user);
	      $body->assign('xConf', $xConf);
	      $body->assign('password', $password);
	      $body->assign('xLang', $content);
	      $body = $body->fetch('mails/mail-create.tpl');

	      // Sent mail
	      $mail = new XMail($user->mail, $content->subject, $body);
	      $mail->setType('html');
	      $mail->send();

      }

   }


   /**
    * Edits a user
    */
   public static function editItem() {
      global $xCom, $xUser;

      $user  = new User();
      $user->load(XTools::getParam('id', 0, _INT));

      $list = new UserList();
      $list->load();

      // Check mail (no duplicates allowed)
      $newMail = XTools::getParam('x_mail');
      if ($match = $list->getItemByAttribute('mail', $newMail)) {

         if ($match->id != $user->id) {
            return !print($xCom->xLang->messages['mailExists']);
         }

      }

      // Correct ranks (limit upgrading / protect owner)
      if (intval($user->id) !== 1) {
         $user->set('rank', XTools::getParam('x_rank', 0, _INT));
         $user->set('rank', min($xUser->rank, $user->rank));
      }

      $user->set('mail',   $newMail);
      $user->set('name',   XTools::getParam('x_name'));
      $user->set('editor', XTools::getParam('x_editor', 0, _INT));
      $user->save();

   }


   /**
    * Reset password
    */
   public static function resetPassword() {
      global $xCom, $xConf;

      $password = XTools::generatePassword();
      $content  = (object) $xCom->xLang->mailReset;

      // Reset password
      $user  = new User();
      $user->load(XTools::getParam('id', 0, _INT));
      $user->set('password', hash($xConf->hashAlgorithm, $password));
      $user->save();

      // Generate mail content
      $body = new XAdminTemplate('adm_users');
      $body->assign('xUser', $user);
      $body->assign('xConf', $xConf);
      $body->assign('password', $password);
      $body->assign('xLang', $content);
      $body = $body->fetch('mails/mail-reset.tpl');

      // Sent mail
      $mail = new XMail($user->mail, $content->subject, $body);
      $mail->setType('html');
      $mail->send();

      // Notification text
      die($xCom->xLang->messages['resetPassword']);

   }


   /**
    * Removes a user
    */
   public static function removeItem() {
      global $xCom, $xUser;

      $user = new User();
      $user->load(XTools::getParam('id', 0));

      if ($user->id && intval($user->id) === 1) {
         return !print($xCom->xLang->messages['noRemoveAdmin']);
      }

      if ($user->id && $xUser->id == $user->id) {
         return !print($xCom->xLang->messages['noRemoveSelf']);
      }

      if ($user->id && $xUser->rank < $user->rank) {
         return !print($xCom->xLang->messages['noHighRank']);
      }

      $user->remove();

   }

}
?>