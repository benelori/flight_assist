<?php

namespace Drupal\aa_my_account\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Refund application edit forms.
 *
 * @ingroup aa_my_account
 */
class RefundApplicationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\aa_my_account\Entity\RefundApplication */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Refund application.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Refund application.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.refund_application.canonical', ['refund_application' => $entity->id()]);
  }

}
