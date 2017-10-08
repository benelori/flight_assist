<?php

namespace Drupal\iata_codes_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class IataCodesApiKeyForm.
 *
 * @package Drupal\iata_codes_api\Form
 */
class IataCodesApiKeyForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'iata_codes_api.iatacodesapikey',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'iata_codes_api_key_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('iata_codes_api.iatacodesapikey');
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#description' => $this->t('Enter your API key, provided by iatacodes.org'),
      '#maxlength' => 255,
      '#size' => 64,
      '#default_value' => $config->get('api_key'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('iata_codes_api.iatacodesapikey')
      ->set('api_key', $form_state->getValue('api_key'))
      ->save();
  }

}
