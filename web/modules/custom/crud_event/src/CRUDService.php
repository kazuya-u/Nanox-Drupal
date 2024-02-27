<?php

declare(strict_types=1);

namespace Drupal\crud_event;

use Drupal\Core\Entity\EntityInterface;
use Drupal\crud_event\Event\CRUDEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * CRUD Event service. Provides Helper method.
 */
final class CRUDService {

  /**
   * The event name - CREATE.
   *
   * @var string
   */
  const CREATE = 'event.create';

  /**
   * The event name - READ.
   *
   * @var string
   */
  const READ = 'event.read';

  /**
   * The event name - UPDATE.
   *
   * @var string
   */
  const UPDATE = 'event.update';

  /**
   * The event name - UPDATE.
   *
   * @var string
   */
  const DELETE = 'event.delete';

  /**
   * The event name - Presave.
   *
   * @var string
   */
  const PRESAVE = 'event.presave';

  /**
   * The Event Dispatcher.
   */
  protected EventDispatcherInterface $dispatcher;

  /**
   * Constructor.
   *
   * @param Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
   *   The event dispatcher.
   */
  public function __construct(
    EventDispatcherInterface $dispatcher
  ) {
    $this->dispatcher = $dispatcher;
  }

  /**
   * Dispatch event.
   *
   * @param string $event_type
   *   The event type which CRUD.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity to dispatch event.
   */
  public function dispatchEvent($event_type, EntityInterface $entity) {

    // The event.
    $event = new CRUDEvent($event_type, $entity);

    // Dispatch.
    $this->dispatcher->dispatch($event, $event_type);
  }

}
