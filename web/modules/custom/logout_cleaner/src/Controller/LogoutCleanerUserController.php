<?php

namespace Drupal\logout_cleaner\Controller;

use Drupal\user\Controller\UserController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Override Drupal\user\Controller\UserController.
 */
final class LogoutCleanerUserController extends UserController {

  /**
   * The session.
   */
  protected SessionInterface $session;

  /**
   * Constructor.
   */
  public function __construct(
    SessionInterface $session,
  ) {
    $this->session = $session;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('session'),
    );
  }

  /**
   * {@inheritDoc}
   */
  public function logout() {
    if ($this->currentUser()->isAuthenticated()) {
      user_logout();

      // Set status message.
      $this->messenger()->addMessage('Success logout.');
    }

    // Remove session-data.
    foreach ($this->session->all() as $i => $o) {
      $this->session->remove($i);
    }
    return $this->redirect('<front>');
  }

}
