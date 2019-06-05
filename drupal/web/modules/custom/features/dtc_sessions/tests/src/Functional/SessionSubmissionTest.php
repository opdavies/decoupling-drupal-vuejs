<?php

namespace Drupal\Tests\dtc_sessions\Functional;

use Drupal\Core\Url;
use Drupal\dtc_sessions_test\Factory\SessionFactory;
use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for submitting sessions.
 */
class SessionSubmissionTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'dtc_sessions',
    'dtc_sessions_test',
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
  public function anonymous_users_cannot_submit_sessions() {
    $this->drupalGet(Url::fromRoute('node.add', ['node_type' => SessionFactory::NODE_TYPE]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_FORBIDDEN);
  }

  /** @test */
  public function authenticated_users_can_submit_sessions() {
    $this->drupalLogin($this->sessionOwner);

    $this->drupalGet(Url::fromRoute('node.add', ['node_type' => SessionFactory::NODE_TYPE]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

  /** @test */
  public function authenticated_users_can_edit_their_submitted_sessions() {
    $session = (new SessionFactory())
      ->setOwner($this->sessionOwner)
      ->save();

    $this->drupalLogin($session->getOwner());
    $this->drupalGet(Url::fromRoute('entity.node.edit_form', ['node' => $session->id()]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

  /** @test */
  public function authenticated_users_cannot_edit_their_users_sessions() {
    $session = (new SessionFactory())
      ->setOwner($this->sessionOwner)
      ->save();

    $this->drupalLogin($this->createUser());
    $this->drupalGet(Url::fromRoute('entity.node.edit_form', ['node' => $session->id()]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_FORBIDDEN);
  }

  /** @test */
  public function authenticated_users_cannot_delete_their_own_sessions() {
    $session = (new SessionFactory())
      ->setOwner($this->sessionOwner)
      ->save();

    $this->drupalLogin($session->getOwner());
    $this->drupalGet(Url::fromRoute('entity.node.delete_form', ['node' => $session->id()]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_FORBIDDEN);

    // Ensure that the node has not been deleted.
    $this->drupalGet(Url::fromRoute('entity.node.edit_form', ['node' => $session->id()]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

  /** @test */
  public function users_can_view_their_own_session_nodes() {
    /** @var \Drupal\node\NodeInterface $session */
    $session = (new SessionFactory())->save();

    /** @var \Drupal\Core\Session\AccountSwitcherInterface $account_switcher */
    $account_switcher = $this->container->get('account_switcher');
    $account_switcher->switchTo($session->getOwner());

    $this->drupalGet(Url::fromRoute('entity.node.canonical', ['node' => $session->id()]));
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

}
