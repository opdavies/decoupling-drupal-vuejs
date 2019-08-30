<?php

namespace Drupal\dtc_sessions\Plugin\Action;

use Drupal\Core\Field\FieldUpdateActionBase;

/**
 * Accepts a session.
 *
 * @Action(
 *   id = "dtc_sessions_accept_session",
 *   label = @Translation("Accept session"),
 *   type = "node"
 * )
 */
class AcceptSession extends FieldUpdateActionBase {

  /**
   * {@inheritdoc}
   */
  protected function getFieldsToUpdate() {
    return ['field_session_status' => 'accepted'];
  }

}
