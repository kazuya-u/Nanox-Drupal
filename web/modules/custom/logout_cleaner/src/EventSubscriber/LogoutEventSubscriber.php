<?php

namespace Drupal\logout_cleaner\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * The LogoutEventSubscriber Class.
 */
class LogoutEventSubscriber implements EventSubscriberInterface {

  /**
   * The drupal account proxy.
   */
  protected AccountProxyInterface $currentUser;

  /**
   * The drupal messenger.
   */
  protected MessengerInterface $messenger;

  /**
   * The session.
   */
  protected SessionInterface $session;

  /**
   * Constructor.
   */
  public function __construct(
    AccountProxyInterface $current_user,
    MessengerInterface $messenger,
    SessionInterface $session,
  ) {
    $this->currentUser = $current_user;
    $this->messenger = $messenger;
    $this->session = $session;
  }

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents() {
    // Initialized.
    $events = [];

    // Register onLogout event.
    $events[KernelEvents::RESPONSE][] = ['onLogout', 0];
    return $events;
  }

  /**
   * Purge session data.
   */
  public function onLogout(ResponseEvent $event) {
    if (($request = $event->getRequest())
      && $request instanceof Request
      && '/user/logout' === $request->getPathInfo()
      && ($response = $event->getResponse())
      && $response instanceof Response
    ) {
      $this->session->remove('uid');
      // Set redirect.
      $response->headers->set('X-Clear-SessionStorage', 'true');
      $this->messenger->addMessage('ログアウトしました。');
    }
  }

}
