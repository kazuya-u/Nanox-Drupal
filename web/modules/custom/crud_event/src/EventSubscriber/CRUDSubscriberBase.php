<?php

declare(strict_types=1);

namespace Drupal\crud_event\EventSubscriber;

use Drupal\crud_event\CRUDService;
use Drupal\crud_event\Event\CRUDEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Provides a base class to CRUD EventSubscriber.
 */
abstract class CRUDSubscriberBase implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[CRUDService::CREATE][] = ['onEntityOperate', 800];
    $events[CRUDService::READ][] = ['onEntityOperate', 800];
    $events[CRUDService::UPDATE][] = ['onEntityOperate', 800];
    $events[CRUDService::DELETE][] = ['onEntityOperate', 800];
    $events[CRUDService::PRESAVE][] = ['onEntityOperate', 800];
    return $events;
  }

  /**
   * Method called when entity CRUD.
   *
   * @param \Drupal\crud_event\Event\CRUDEvent $crud_event
   *   The event.
   */
  abstract public function onEntityOperate(CRUDEvent $crud_event);

  /**
   * Method called when entity is created.
   *
   * @param \Drupal\crud_event\Event\CRUDEvent $crud_event
   *   The event.
   */
  protected function onEntityCreate(CRUDEvent $crud_event) {}

  /**
   * Method called when entity is updated.
   *
   * @param \Drupal\crud_event\Event\CRUDEvent $crud_event
   *   The event.
   */
  protected function onEntityRead(CRUDEvent $crud_event) {}

  /**
   * Method called when entity is updated.
   *
   * @param \Drupal\crud_event\Event\CRUDEvent $crud_event
   *   The event.
   */
  protected function onEntityUpdate(CRUDEvent $crud_event) {}

  /**
   * Method called when entity is deleted.
   *
   * @param \Drupal\crud_event\Event\CRUDEvent $crud_event
   *   The event.
   */
  protected function onEntityDelete(CRUDEvent $crud_event) {}

  /**
   * Method called when entity is presave.
   *
   * @param \Drupal\crud_event\Event\CRUDEvent $crud_event
   *   The event.
   */
  protected function onEntityPresave(CRUDEvent $crud_event) {}

}
