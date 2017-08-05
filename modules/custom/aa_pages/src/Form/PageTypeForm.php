<?php

namespace Drupal\aa_pages\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PageTypeForm.
 *
 * @package Drupal\aa_pages\Form
 */
class PageTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $aa_page_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $aa_page_type->label(),
      '#description' => $this->t("Label for the Air Assist Page Type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $aa_page_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\aa_pages\Entity\PageType::load',
      ],
      '#disabled' => !$aa_page_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $aa_page_type = $this->entity;
    $status = $aa_page_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Air Assist Page Type.', [
          '%label' => $aa_page_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Air Assist Page Type.', [
          '%label' => $aa_page_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($aa_page_type->toUrl('collection'));
  }

}
