<?php

namespace Drupal\aa_my_account;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Refund application entity.
 *
 * @see \Drupal\aa_my_account\Entity\RefundApplication.
 */
class RefundApplicationAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\aa_my_account\Entity\RefundApplicationInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished refund application entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published refund application entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit refund application entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete refund application entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add refund application entities');
  }

}
