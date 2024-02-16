<?php

namespace Drupal\logout_cleaner\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * The routing.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritDoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if (($route = $collection->get('user.logout'))
      && $route instanceof Route
    ) {
      $route->setDefault('_controller', '\\Drupal\\logout_cleaner\\Controller\\LogoutCleanerUserController::logout');
    }
  }

}
