<?php

namespace Drupal\logout_cleaner\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * The LogoutEventSubscriber Class.
 */
class LogoutEventSubscriber implements EventSubscriberInterface {


  /**
   * The drupal messenger.
   */
  protected MessengerInterface $messenger;

  /**
   * The drupal account proxy.
   */
  protected AccountProxyInterface $currentUser;

  /**
   * Constructor.
   */
  public function __construct(
    AccountProxyInterface $current_user,
    MessengerInterface $messenger
  ) {
    $this->currentUser = $current_user;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onLogout', 0];
    return $events;
  }

  /**
   * Purge session data.
   */
  public function onLogout(RequestEvent $event) {
    if (($request = $event->getRequest())
      && $request instanceof Request
      && '/user/logout' === $request->getPathInfo()
    ) {
      $this->messenger->addMessage('ログアウト成功。');
    }
  }

}
