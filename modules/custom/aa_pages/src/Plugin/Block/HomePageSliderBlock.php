<?php

namespace Drupal\aa_pages\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Link;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Provides a 'HomePageSliderBlock' block.
 *
 * @Block(
 *  id = "aa_home_page_slider_block",
 *  admin_label = @Translation("Home page slider block"),
 * )
 */
class HomePageSliderBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * An array of nodes loaded from the nodequeue.
   *
   * @var \Drupal\node\Entity\Node[]
   */
  private $entities;

  /**
   * Constructs a new HomePageSliderBlock object.
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
      '#theme' => 'slider',
      '#items' => $this->buildSliderRenderArray($this->getSlides()),
    ];

    return $build;
  }

  private function getSlides() {
    $entities = [];

    try {
      $entities = $this->getEntities();
    }
    catch (\Exception $exception) {
      watchdog_exception('Slider', $exception);
    }

    return $entities;
  }

  private function getEntities() {
    if (empty($this->entities)) {
      $subqueue = $this->entityTypeManager
        ->getStorage('entity_subqueue')
        ->load('slider');
      $this->entities = $subqueue->get('items')->referencedEntities();
    }
    return $this->entities;
  }

  private function buildSliderRenderArray(array $entities) {
    $output = [];
    if ($entities) {
      $viewBuilder = $this->entityTypeManager->getViewBuilder('node');
      foreach ($entities as $key => $entity) {
        /** @var \Drupal\file\Entity\File $image */
        $image = $entity->field_image->entity;
        /** @var NodeInterface $entity */
        $output[$key+1] = [
          'node' => $viewBuilder->view($entity, 'teaser'),
          'read_more' => $this->getReadMoreLink($entity),
          'image' => $image ? $image->url() : '',
        ];
      }
    }

    return $output;
  }

  private function getReadMoreLink(NodeInterface $node) {
    /** @var NodeInterface $reference */
    $reference = $node->field_link->entity;

    if (!$reference) {
      return NULL;
    }
    /** @var \Drupal\Core\Path\AliasManagerInterface $aliasManager */
    $aliasManager = \Drupal::service('path.alias_manager');
    $url = Url::fromUserInput($aliasManager->getAliasByPath('/node/' . $reference->id()), [
      'attributes' => [
        'class' => [
          'slide_btn',
          'FromRight',
        ],
      ],
    ])->setAbsolute();
    $link = Link::fromTextAndUrl($this->t('Read More'), $url);
    return $link->toRenderable();
  }

  public function getCacheTags() {
    $tags = ['slider'];

    return Cache::mergeTags($tags, parent::getCacheTags());
  }

}
