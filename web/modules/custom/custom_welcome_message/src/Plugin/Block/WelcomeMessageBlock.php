<?php
 
namespace Drupal\custom_welcome_message\Plugin\Block;
 
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
 
/**
* Provides a 'Welcome Message' Block.
*
* @Block(
*   id = "welcome_message_block",
*   admin_label = @Translation("Welcome Message Block"),
* )
*/
class WelcomeMessageBlock extends BlockBase {
 
  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get the current user.
    $user = \Drupal::currentUser();
 
   
    if ($user->isAuthenticated()) {
   
      $username = $user->getDisplayName();
 
     
      $message = $this->t('Welcome @username.', ['@username' => $username]);
    } else {
   
      $message = $this->t('Hey user! Please log in to get some Expert advice.');
    }
 
   
    return [
      '#markup' => $message,
    ];
  }
}
