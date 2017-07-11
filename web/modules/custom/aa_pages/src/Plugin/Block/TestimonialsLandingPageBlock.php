<?php

namespace Drupal\aa_pages\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Provides a 'AboutUsFooterBlock' block.
 *
 * @Block(
 *  id = "testimonials_landing_page_block",
 *  admin_label = @Translation("Testimonials landing page block"),
 * )
 */
class TestimonialsLandingPageBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
    $build = [
      '#theme' => 'testimonials',
      '#items' => $this->buildTestimonialsRenderArray($this->getTestimonials()),
    ];

    return $build;
  }

  private function getTestimonials() {
    $entities = [];

    try {
      $subqueue = $this->entityTypeManager
        ->getStorage('entity_subqueue')
        ->load('testimonials');
      $entities = $subqueue->get('items')->referencedEntities();
    }
    catch (\Exception $exception) {
      watchdog_exception('Testimonials', $exception);
    }

    return $entities;
  }

  private function buildTestimonialsRenderArray(array $entities) {
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
