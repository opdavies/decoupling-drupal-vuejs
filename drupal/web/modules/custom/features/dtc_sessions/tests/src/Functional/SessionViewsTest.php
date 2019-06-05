<?php

namespace Drupal\Tests\dtc_sessions\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for submitting sessions.
 */
class SessionViewsTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'block',
    'dtc_sessions',
    'dtc_sessions_test',
    'views',
  ];

  /**
   * The session owner.
   *
   * @var \Drupal\user\UserInterface
   */
  private $sessionOwner;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->sessionOwner = $this->createUser([
      'create session content',
      'edit own session content',
    ]);
  }

  /** @test */
  public function a_link_to_their_sessions_is_on_the_user_page() {
    $this->placeBlock('local_tasks_block');

    $this->drupalLogin($this->sessionOwner);

    $this->assertSession()->linkByHrefExists("user/{$this->sessionOwner->id()}/sessions");
  }

  /** @test */
  public function users_can_view_a_list_of_their_submitted_sessions() {
    $this->drupalLogin($this->sessionOwner);

    $this->drupalGet(Url::fromRoute('view.user_sessions.page_1', ['user' => $this->sessionOwner->id()]));

    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

  /** @test */
  public function users_cannot_view_a_list_of_other_users_submitted_sessions() {
    $this->drupalLogin($this->drupalCreateUser());

    $this->drupalGet(Url::fromRoute('view.user_sessions.page_1', ['user' => $this->sessionOwner->id()]));

    $this->assertSession()->statusCodeEquals(Response::HTTP_FORBIDDEN);
  }

}
