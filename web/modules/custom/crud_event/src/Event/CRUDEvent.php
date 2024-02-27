<?php

namespace Drupal\crud_event\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\Core\Entity\EntityInterface;
use Drupal\crud_event\CRUDService;

/**
 * Define the entity CRUD event.
 */
class CRUDEvent extends Event {

  /**
   * The Entity.
   */
  protected EntityInterface $entity;

  /**
   * The event type.
   */
  protected CRUDService $eventType;

  /**
   * Construct the CRUD event for target entity.
   *
   * @param string $event_type
   *   The event type.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity during the occurrence of an event.
   */
  public function __construct(
    string $event_type,
    EntityInterface $entity
  ) {
    $this->entity = $entity;
    $this->eventType = $event_type;
  }

  /**
   * Method to get the entity from the event.
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Method to get the event type.
   */
  public function getEventType() {
    return $this->eventType;
  }

}
