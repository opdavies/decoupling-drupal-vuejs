<?php

namespace Drupal\dtc_import\Service\Importer;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Tightenco\Collect\Support\Collection;

class CsvSessionImporter extends CsvImporter {

  const NODE_TYPE_SESSION = 'session';

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $sessionStorage;

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $userStorage;

  /**
   * CsvImporter constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->sessionStorage = $entityTypeManager->getStorage('node');
    $this->userStorage = $entityTypeManager->getStorage('user');
  }

  public function import(): void {
    $csv = $this->getCsv(__DIR__ . '/../../../sessions.csv');

    $this->splitRows($csv)->filter()->map(function (string $row): Collection {
      return $this->splitRow($row);
    })->map(function (Collection $session): Collection {
      return $this->mapFieldsToHeadings($session);
    })->map(function (Collection $values): array {
      return $this->findSessionNode($values);
    })->filter(function (array $sessionArray): bool {
      return !$sessionArray['node'];
    })->map(function (array $sessionItem) {
      list($values, $node) = $sessionItem;

      return $this->createSessionNode($values);
    });
  }

  protected function headings(): array {
    return ['title', 'field_speakers'];
  }

  private function findSessionNode(Collection $values): array {
    $node = collect($this->sessionStorage->loadByProperties([
      'title' => $values->get('title'),
      'type' => self::NODE_TYPE_SESSION,
    ]))->first();

    return [$values, $node];
  }

  private function createSessionNode(Collection $values): NodeInterface {
    $values = $values->merge([
      'field_speakers' => $this->findSpeakers($values->get('field_speakers')),
      'type' => self::NODE_TYPE_SESSION,
    ]);

    return tap($this->sessionStorage->create($values->toArray()), function (NodeInterface $session) {
      $session->setOwnerId(1);
      $session->setPublished();
      $session->save();
    });
  }

  private function findSpeakers(string $speakers): array {
    return $this->userStorage->loadByProperties([
      'name' => explode(',', $speakers),
    ]);
  }

}
