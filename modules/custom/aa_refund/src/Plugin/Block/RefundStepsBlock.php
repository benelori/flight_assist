<?php

namespace Drupal\aa_refund\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Template\Attribute;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'RefundReasonsBlock' block.
 *
 * @Block(
 *  id = "refund_steps_block",
 *  admin_label = @Translation("Refund steps block"),
 * )
 */
class RefundStepsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * Constructs a new AboutUsFooterBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManager $entity_type_manager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $steps = $this->getRefundSteps();
    $build = [
      '#theme' => 'refund_steps',
      '#items' => $this->buildRefundStepsRenderArray($steps),
      '#titles' => $this->getTitles($steps),
    ];

    return $build;
  }

  private function getTitles(array $entities) {
    $titles = [];

    if ($entities) {
      foreach ($entities as $key => $entity) {
        /** @var NodeInterface $entity */
        $titles[$key+1] = $entity->label();
      }
    }

    return $titles;
  }

  private function getRefundSteps() {
    $entities = [];

    try {
      $subqueue = $this->entityTypeManager
        ->getStorage('entity_subqueue')
        ->load('refund_steps');
      $entities = $subqueue->get('items')->referencedEntities();
    }
    catch (\Exception $exception) {
      watchdog_exception('Refunds', $exception);
    }

    return $entities;
  }

  private function buildRefundStepsRenderArray(array $entities) {
    $output = [];
    if ($entities) {
      $viewBuilder = $this->entityTypeManager->getViewBuilder('node');
      foreach ($entities as $key => $entity) {
        /** @var NodeInterface $entity */
        $output[$key+1] = $viewBuilder->view($entity, 'teaser');
      }
    }

    return $output;
  }

}
