<?php

namespace Drupal\test_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;

class TestForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'test_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['apellido'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Apellido'),
      '#required' => TRUE,
    ];

    $form['nombre'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nombre'),
      '#required' => TRUE,
    ];

    // Fetch options for Tipo de Documento from the vocabulary
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('tipo_documento');
    $options_tipo_documento = [];
    foreach ($terms as $term) {
      $options_tipo_documento[$term->tid] = $term->name;
    }

    $form['tipo_documento'] = [
      '#type' => 'select',
      '#title' => $this->t('Tipo de Documento'),
      '#options' => $options_tipo_documento,
      '#required' => TRUE,
    ];

    $form['numero_documento'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Numero de Documento'),
      '#required' => TRUE,
    ];

    $form['correo_electronico'] = [
      '#type' => 'email',
      '#title' => $this->t('Correo electronico'),
      '#required' => TRUE,
    ];

    $form['telefono'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Telefono'),
      '#required' => TRUE,
    ];

    // Fetch options for País from the vocabulary
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('pais');
    $options_pais = [];
    foreach ($terms as $term) {
      $options_pais[$term->tid] = $term->name;
    }

    $form['pais'] = [
      '#type' => 'select',
      '#title' => $this->t('Pais'),
      '#options' => $options_pais,
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enviar'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate the email field
    if (!\Drupal::service('email.validator')->isValid($form_state->getValue('correo_electronico'))) {
      $form_state->setErrorByName('correo_electronico', $this->t('El correo electrónico no es válido.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //almacenamiento de los datos.
     $connection = \Drupal::database();

  // Insert form data into the custom table.
  $connection->insert('test_form_data')
    ->fields([
      'apellido' => $form_state->getValue('apellido'),
      'nombre' => $form_state->getValue('nombre'),
      'tipo_documento' => $form_state->getValue('tipo_documento'),
      'numero_documento' => $form_state->getValue('numero_documento'),
      'correo_electronico' => $form_state->getValue('correo_electronico'),
      'telefono' => $form_state->getValue('telefono'),
      'pais' => $form_state->getValue('pais'),
    ])
    ->execute();

    \Drupal::messenger()->addMessage($this->t('Formulario enviado exitosamente.'));
  }
}
