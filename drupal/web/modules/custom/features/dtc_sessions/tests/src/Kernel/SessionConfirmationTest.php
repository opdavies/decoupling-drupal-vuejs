<?php

namespace Drupal\Tests\dtc_sessions\Kernel;

use Drupal\Core\Test\AssertMailTrait;
use Drupal\dtc_sessions_test\Factory\SessionFactory;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\user\Entity\User;

class SessionConfirmationTest extends EntityKernelTestBase {

  use AssertMailTrait;

  /**
   * {@inheritdoc}
   */
  protected $strictConfigSchema = FALSE;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'dtc_sessions',
    'hook_event_dispatcher',
    'node',
    'options',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installConfig([
      'node',
      'dtc_sessions',
    ]);
  }

  /** @test */
  public function a_confirmation_email_is_sent_to_the_owner_when_a_session_is_submitted() {
    $session = (new SessionFactory())->save();

    $mails = $this->getMails(['id' => 'dtc_sessions_session_confirmation']);
    $this->assertCount(1, $mails);

    $this->assertSame($session->getOwner()->getEmail(), $mails[0]['to']);
    $this->assertSame($session, $mails[0]['params']['session']);
  }

}
