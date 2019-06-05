<?php


namespace Drupal\dtc_import\Service\Importer;

use Tightenco\Collect\Support\Collection;

abstract class CsvImporter implements ImporterInterface {

  abstract protected function headings(): array;

  protected function getCsv(string $path): string {
    return file_get_contents($path);
  }

  protected function splitRows(string $rows): Collection {
    return collect(explode(PHP_EOL, $rows));
  }

  protected function splitRow(string $row): Collection {
    return collect(explode(',', $row));
  }

  protected function mapFieldsToHeadings(Collection $session): Collection {
    return $session->zip($this->headings())
      ->mapWithKeys(function ($session): array {
        list($value, $key) = $session;
        return [$key => $value];
      });
  }

}