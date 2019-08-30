<?php

namespace Drupal\dtc_sessions\Plugin\Action;

use Drupal\Core\Field\FieldUpdateActionBase;

/**
 * Rejects a session.
 *
 * @Action(
 *   id = "dtc_sessions_reject_session",
 *   label = @Translation("Reject session"),
 *   type = "node"
 * )
 */
class RejectSession extends FieldUpdateActionBase {

  /**
   * {@inheritdoc}
   */
  protected function getFieldsToUpdate() {
    return ['field_session_status' => 'rejected'];
  }

}
