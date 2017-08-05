<?php

namespace Drupal\aa_my_account\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RefundApplicationTypeForm.
 *
 * @package Drupal\aa_my_account\Form
 */
class RefundApplicationTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $refund_application_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $refund_application_type->label(),
      '#description' => $this->t("Label for the Refund application type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $refund_application_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\aa_my_account\Entity\RefundApplicationType::load',
      ],
      '#disabled' => !$refund_application_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $refund_application_type = $this->entity;
    $status = $refund_application_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Refund application type.', [
          '%label' => $refund_application_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Refund application type.', [
          '%label' => $refund_application_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($refund_application_type->toUrl('collection'));
  }

}
