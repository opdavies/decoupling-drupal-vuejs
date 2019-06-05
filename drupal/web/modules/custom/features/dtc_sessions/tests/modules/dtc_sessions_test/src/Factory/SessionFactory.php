<?php

namespace Drupal\dtc_sessions_test\Factory;

use Drupal\Core\Entity\EntityInterface;
use Drupal\node\Entity\Node;
use Drupal\user\UserInterface;

/**
 * A factory class to create a new session.
 */
class SessionFactory implements FactoryInterface {

  /**
   * The node type to create.
   */
  const NODE_TYPE = 'session';

  /**
   * The session owner.
   *
   * @var \Drupal\user\UserInterface
   */
  private $owner;

  /**
   * Any additional speakers to add to the session.
   *
   * @var array
   */
  private $extraSpeakers = [];

  /**
   * The session title.
   *
   * @var string
   */
  private $sessionTitle = 'A submitted session';

  /**
   * The type of session.
   *
   * @var string
   */
  private $sessionType = 'full';

  /**
   * Set a user to be the owner of the session.
   *
   * @param \Drupal\user\UserInterface $owner
   *   The user.
   *
   * @return \Drupal\dtc_sessions_test\Factory\SessionFactory
   */
  public function setOwner(UserInterface $owner): self {
    $this->owner = $owner;

    return $this;
  }

  /**
   * Add additional speakers to the session.
   *
   * @param int $count
   *   The number of additional speakers.
   *
   * @return self
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function addExtraSpeakers(int $count): self {
    foreach (range(1, $count) as $i) {
      $this->extraSpeakers[] = (new UserFactory())
        ->setUsername("speaker_{$i}")
        ->save();
    }

    return $this;
  }

  /**
   * Update the session title.
   *
   * @param string $title
   *   The session title.
   *
   * @return $this
   */
  public function setTitle(string $title): self {
    $this->sessionTitle = $title;

    return $this;
  }

  /**
   * Set the event type.
   *
   * @param string $type
   *   The event type value.
   *
   * @return \Drupal\dtc_sessions_test\Factory\SessionFactory
   */
  public function setType(string $type): self {
    $this->sessionType = $type;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function save(): EntityInterface {
    $owner = $this->owner ?? (new UserFactory())->save();

    $session = Node::create([
      'title' => $this->sessionTitle,
      'type' => self::NODE_TYPE,
      'uid' => $owner,
    ]);
    $session->set('field_session_type', $this->sessionType);
    $session->set('field_speakers', array_merge([$owner], $this->extraSpeakers));
    $session->save();

    return $session;
  }

}
