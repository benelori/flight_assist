<?php

namespace Drupal\aa_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\user\Form\UserLoginForm;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Entity\EntityFormBuilder;

/**
 * Class JoinUsController.
 *
 * @package Drupal\aa_user\Controller
 */
class JoinUsController extends ControllerBase {

  /**
   * Drupal\Core\Form\FormBuilder definition.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;
  /**
   * Drupal\Core\Entity\EntityFormBuilder definition.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entityFormBuilder;

  /**
   * Constructs a new JoinUsController object.
   */
  public function __construct(FormBuilder $form_builder, EntityFormBuilder $entity_form_builder) {
    $this->formBuilder = $form_builder;
    $this->entityFormBuilder = $entity_form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('entity.form_builder')
    );
  }

  public function build() {
    $form_object = \Drupal::entityTypeManager()->getFormObject('user', 'register');

    $entity = $form_object->getEntityFromRouteMatch(\Drupal::routeMatch(), 'user');
    return [
      '#theme' => 'join_us',
      '#login_form' => $this->formBuilder->getForm(UserLoginForm::class),
      '#register_form' => $this->entityFormBuilder->getForm($entity, 'register'),
    ];
  }

}
