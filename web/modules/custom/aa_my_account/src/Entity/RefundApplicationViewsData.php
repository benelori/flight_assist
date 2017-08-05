<?php

namespace Drupal\aa_my_account\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Refund application entities.
 */
class RefundApplicationViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
