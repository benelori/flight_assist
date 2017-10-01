<?php

namespace Drupal\aa_refund\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RefundAdditionalInformationForm.
 *
 * @package Drupal\aa_refund\Form
 */
class RefundAdditionalInformationForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'refund_additional_information_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $eligibility = unserialize($_SESSION['eligibility']);

    $form['personal_info_first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
    ];

    $form['personal_info_last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#required' => TRUE,
    ];

    $form['passengers'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Were there other passengers?'),
    ];
    $form['booking_reference'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Booking Reference'),
      '#description' => $this->t('Upload booking reference'),
      '#required' => FALSE,
    ];
    $form['what_happened'] = [
      '#type' => 'text_format',
      '#title' => $this->t('What happened'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Next'),
    ];

    return $form;
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
    $eligibility = unserialize($_SESSION['eligibility']);
    $values = $form_state->cleanValues()->getValues();
    $eligibility += [
      'first_name' => $values['personal_info_first_name'],
      'last_name' => $values['personal_info_last_name'],
      'other_passengers' => $values['passengers'],
      'optional_description' => $values['what_happened'],
    ];
    $_SESSION['eligibility'] = serialize($eligibility);
    $form_state->setRedirect('aa_refund.refund_personal_info_form');
  }

}
