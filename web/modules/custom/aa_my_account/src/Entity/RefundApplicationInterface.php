<?php

namespace Drupal\aa_my_account\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Refund application entities.
 *
 * @ingroup aa_my_account
 */
interface RefundApplicationInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Refund application name.
   *
   * @return string
   *   Name of the Refund application.
   */
  public function getName();

  /**
   * Sets the Refund application name.
   *
   * @param string $name
   *   The Refund application name.
   *
   * @return \Drupal\aa_my_account\Entity\RefundApplicationInterface
   *   The called Refund application entity.
   */
  public function setName($name);

  /**
   * Gets the Refund application creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Refund application.
   */
  public function getCreatedTime();

  /**
   * Sets the Refund application creation timestamp.
   *
   * @param int $timestamp
   *   The Refund application creation timestamp.
   *
   * @return \Drupal\aa_my_account\Entity\RefundApplicationInterface
   *   The called Refund application entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Refund application published status indicator.
   *
   * Unpublished Refund application are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Refund application is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Refund application.
   *
   * @param bool $published
   *   TRUE to set this Refund application to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\aa_my_account\Entity\RefundApplicationInterface
   *   The called Refund application entity.
   */
  public function setPublished($published);

}
