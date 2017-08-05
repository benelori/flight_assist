<?php

namespace Drupal\aa_my_account\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Refund application type entity.
 *
 * @ConfigEntityType(
 *   id = "refund_application_type",
 *   label = @Translation("Refund application type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\aa_my_account\RefundApplicationTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\aa_my_account\Form\RefundApplicationTypeForm",
 *       "edit" = "Drupal\aa_my_account\Form\RefundApplicationTypeForm",
 *       "delete" = "Drupal\aa_my_account\Form\RefundApplicationTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\aa_my_account\RefundApplicationTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "refund_application_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "refund_application",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/refund_application_type/{refund_application_type}",
 *     "add-form" = "/admin/structure/refund_application_type/add",
 *     "edit-form" = "/admin/structure/refund_application_type/{refund_application_type}/edit",
 *     "delete-form" = "/admin/structure/refund_application_type/{refund_application_type}/delete",
 *     "collection" = "/admin/structure/refund_application_type"
 *   }
 * )
 */
class RefundApplicationType extends ConfigEntityBundleBase implements RefundApplicationTypeInterface {

  /**
   * The Refund application type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Refund application type label.
   *
   * @var string
   */
  protected $label;

}
