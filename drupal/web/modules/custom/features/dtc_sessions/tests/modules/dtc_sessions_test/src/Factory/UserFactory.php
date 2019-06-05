<?php

namespace Drupal\dtc_sessions_test\Factory;

use Drupal\Core\Entity\EntityInterface;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;

/**
 * A factory class to create a new user.
 */
class UserFactory implements FactoryInterface {

  /**
   * The user's username.
   *
   * @var string
   */
  private $username = 'test';

  /**
   * The user's email address.
   *
   * @var string
   */
  private $mail = 'test@example.com';

  /**
   * Set the username.
   *
   * @param string $name
   *   The username.
   *
   * @return \Drupal\dtc_sessions_test\Factory\UserFactory
   */
  public function setUsername(string $name): self {
    $this->username = $name;

    return $this;
  }

  /**
   * Set the email address.
   *
   * @param string $mail
   *   The email address.
   *
   * @return \Drupal\dtc_sessions_test\Factory\UserFactory
   */
  public function setEmail(string $mail): self {
    $this->mail = $mail;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function save(): EntityInterface {
    $user = User::create([
      'name' => $this->username,
      'mail' => $this->mail,
    ]);

    $user->enforceIsNew();
    $user->save();

    return $user;
  }

}
