<?php

namespace Drupal\dtc_import\Service\Importer;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user\UserInterface;
use Tightenco\Collect\Support\Collection;

class CsvSpeakerImporter extends CsvImporter {

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $userStorage;

  public function __construct(
    EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->userStorage = $entityTypeManager->getStorage('user');
  }

  public function import(): void {
    $csv = $this->getCsv(__DIR__ . '/../../../speakers.csv');

    $this->splitRows($csv)->filter()->map(function (string $row): Collection {
      return $this->splitRow($row);
    })->map(function (Collection $session): Collection {
      return $this->mapFieldsToHeadings($session);
    })->map(function (Collection $values): array {
      return $this->findUser($values);
    })->filter(function (array $speakerArray): bool {
      return !$speakerArray['user'];
    })->map(function (array $speakerArray): UserInterface {
      list($values, $user) = $speakerArray;

      return $this->createUser($values);
    });
  }

  protected function headings(): array {
    return ['name'];
  }

  private function findUser(Collection $values) {
    $user = collect($this->userStorage->loadByProperties([
      'name' => $values->get('name'),
    ]))->first();

    return [$values, $user];
  }

  private function createUser(Collection $values) {
    $values = $values->merge([
      'status' => TRUE,
    ]);

    return tap($this->userStorage->create($values->toArray()), function (UserInterface $user) {
      $user->save();
    });
  }

}