<?php

namespace Drupal\Tests\dtc_sessions\Kernel;

use Drupal\dtc_sessions_test\Factory\SessionFactory;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;

class SessionSubmissionTest extends EntityKernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected $strictConfigSchema = FALSE;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'dtc_sessions',
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
  public function new_sessions_are_marked_as_submitted() {
    $session = (new SessionFactory())->save();

    $this->assertSame('submitted', $session->get('field_session_status')->getString());
  }

  /** @test */
  public function users_can_be_set_as_speakers() {
    $session = (new SessionFactory())->save();
    $speakers = $session->get('field_speakers')->getValue();

    $this->assertSame($session->getOwnerId(), $speakers[0]['target_id']);
  }

  /** @test */
  public function a_session_can_have_multiple_speakers() {
    $session = (new SessionFactory())
      ->addExtraSpeakers(2)
      ->save();

    $speakers = $session->get('field_speakers')->getValue();

    $this->assertCount(3, $speakers);
  }

  /** @test */
  public function a_session_has_a_type() {
    $session = (new SessionFactory())
      ->setType('full')
      ->save();

    $this->assertSame('full', $session->get('field_session_type')->getString());
  }

}
