<?php

namespace Drupal\aa_pages\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Air Assist Page Type entity.
 *
 * @ConfigEntityType(
 *   id = "aa_page_type",
 *   label = @Translation("Air Assist Page Type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\aa_pages\PageTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\aa_pages\Form\PageTypeForm",
 *       "edit" = "Drupal\aa_pages\Form\PageTypeForm",
 *       "delete" = "Drupal\aa_pages\Form\PageTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\aa_pages\PageTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "aa_page_type",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/aa_page_type/{aa_page_type}",
 *     "add-form" = "/admin/structure/aa_page_type/add",
 *     "edit-form" = "/admin/structure/aa_page_type/{aa_page_type}/edit",
 *     "delete-form" = "/admin/structure/aa_page_type/{aa_page_type}/delete",
 *     "collection" = "/admin/structure/aa_page_type"
 *   }
 * )
 */
class PageType extends ConfigEntityBase implements PageTypeInterface {

  /**
   * The Air Assist Page Type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Air Assist Page Type label.
   *
   * @var string
   */
  protected $label;

}
