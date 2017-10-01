<?php

namespace Drupal\aa_refund\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityFormBuilder;

/**
 * Class RefundPersonalInfoForm.
 *
 * @package Drupal\aa_refund\Form
 */
class RefundPersonalInfoForm extends FormBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * Drupal\Core\Entity\EntityFormBuilder definition.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entityFormBuilder;
  /**
   * Constructs a new RefundPersonalInfoForm object.
   */
  public function __construct(
    EntityTypeManager $entity_type_manager,
    EntityFormBuilder $entity_form_builder
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFormBuilder = $entity_form_builder;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity.form_builder')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'refund_personal_info_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['permission_assignment_document'] = [
      '#type' => 'markup',
      '#markup' => '<div class="contact_btn"><a href="/">Review the document</a></div><br>  ',
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
    $form_state->setRedirect('aa_refund.refund_register_form_register');
  }

}
