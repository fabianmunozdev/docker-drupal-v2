<?php 

namespace Drupal\test_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class TestDataController extends ControllerBase {

  public function viewData() {
    $connection = Database::getConnection();
    $query = $connection->select('test_form_data', 't')
      ->fields('t', ['apellido', 'nombre', 'tipo_documento', 'numero_documento', 'correo_electronico', 'telefono', 'pais']);
    $results = $query->execute()->fetchAll();

    $rows = [];
    foreach ($results as $row) {
      $rows[] = [
        'data' => (array) $row,
      ];
    }

    $header = [
      'Apellido', 'Nombre', 'Tipo de Documento', 'Número de Documento', 'Correo Electrónico', 'Teléfono', 'País',
    ];

    $build = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }
}
