<?php

namespace Drupal\Tests\dtc_sessions\Kernel;

use Drupal\dtc_sessions_test\Factory\SessionFactory;
use Drupal\dtc_sessions_test\Factory\UserFactory;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\views\ResultRow;

class SessionViewsTest extends EntityKernelTestBase {

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
    'views',
  ];

  /**
   * @var \Drupal\Core\Session\AccountSwitcherInterface
   */
  private $accountSwitcher;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installConfig([
      'node',
      'dtc_sessions',
    ]);

    $this->accountSwitcher = $this->container->get('account_switcher');
  }

  /** @test */
  public function a_user_can_view_a_list_of_their_submitted_sessions() {
    $user1 = (new UserFactory())->setUsername('user1')->save();
    $user2 = (new UserFactory())->setUsername('user2')->save();

    $session1 = (new SessionFactory())->setTitle('User 1 session')->setOwner($user1)->save();
    $session2 = (new SessionFactory())->setTitle('User 2 session')->setOwner($user2)->save();

    $this->accountSwitcher->switchTo($user2);

    $sessions = views_get_view_result('user_sessions', 'page_1', $user2->id());

    $this->assertCount(1, $sessions);
    $this->assertSame($session2->uuid(), $sessions[0]->_entity->uuid());
  }

  /** @test */
  public function sessions_are_listed_alphabetically() {
    $owner = $this->createUser([], ['create session content']);

    (new SessionFactory())->setOwner($owner)->setTitle('Session B')->save();
    (new SessionFactory())->setOwner($owner)->setTitle('Session A')->save();
    (new SessionFactory())->setOwner($owner)->setTitle('Session D')->save();
    (new SessionFactory())->setOwner($owner)->setTitle('Session C')->save();

    $this->accountSwitcher->switchTo($owner);

    $nids = array_map(function (ResultRow $row) {
      return $row->_entity->id();
    }, views_get_view_result('user_sessions', 'page_1', $owner->id()));

    $this->assertEquals([2, 1, 4, 3], $nids);
  }

}
