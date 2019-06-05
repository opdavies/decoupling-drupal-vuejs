<?php

use Drupal\dtc_sessions_test\Factory\UserFactory;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\user\Entity\User;

class UserRolesTest extends EntityKernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'dtc_user_roles',
    'dtc_sessions',
    'dtc_sessions_test',
    'hook_event_dispatcher',
  ];

  /** @test */
  public function new_users_are_given_the_session_submitter_role() {
    /** @var \Drupal\user\UserInterface $user */
    $user = (new UserFactory())->save();

    $this->assertTrue($user->hasRole('session_submitter'));
  }

}
