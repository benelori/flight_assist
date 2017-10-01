<?php

namespace Drupal\aa_refund\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityFormBuilder;

/**
 * Class RefundRegisterForm.
 *
 * @package Drupal\aa_refund\Controller
 */
class RefundRegisterForm extends ControllerBase {

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
   * Constructs a new RefundRegisterForm object.
   */
  public function __construct(EntityTypeManager $entity_type_manager, EntityFormBuilder $entity_form_builder) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFormBuilder = $entity_form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity.form_builder')
    );
  }

  /**
   * Register.
   */
  public function register() {
    $entity = $this->entityTypeManager->getStorage('user')->create([]);
    return [
      '#theme' => 'refund_register',
      '#register' => $this->entityFormBuilder->getForm($entity, 'register'),
    ];
  }

}
