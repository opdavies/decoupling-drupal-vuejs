<?php

namespace Drupal\dtc_sessions_test\Factory;

use Drupal\Core\Entity\EntityInterface;

/**
 * A base factory class.
 */
interface FactoryInterface {

  /**
   * Save and return the created entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The created entity.
   */
  public function save(): EntityInterface;

}
