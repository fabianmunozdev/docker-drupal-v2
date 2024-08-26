<?php

namespace Drupal\test_module\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class TestApiController extends ControllerBase {

  public function getData() {
    $connection = Database::getConnection();
    $query = $connection->select('test_form_data', 't')
      ->fields('t', ['apellido', 'nombre', 'tipo_documento', 'numero_documento', 'correo_electronico', 'telefono', 'pais']);
    $results = $query->execute()->fetchAll();

    $data = [];
    foreach ($results as $row) {
      $data[] = (array) $row;
    }

    return new JsonResponse($data);
  }
}
