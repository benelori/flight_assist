<?php

namespace Drupal\aa_my_account;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Refund application entities.
 *
 * @ingroup aa_my_account
 */
class RefundApplicationListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Refund application ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\aa_my_account\Entity\RefundApplication */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.refund_application.edit_form',
      ['refund_application' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
