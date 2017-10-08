<?php

namespace Drupal\aa_pages\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Provides a 'ContactFormBlock' block.
 *
 * @Block(
 *  id = "aa_contact_form_block",
 *  admin_label = @Translation("Contact form block"),
 * )
 */
class ContactFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::configFactory()->get('contact.settings');

    // Use the default form if no form has been passed.
    if (empty($contact_form)) {
      $contact_form = \Drupal::entityTypeManager()
        ->getStorage('contact_form')
        ->load($config->get('default_form'));
      // If there are no forms, do not display the form.
      if (empty($contact_form)) {
        if (\Drupal::currentUser()->hasPermission('administer contact forms')) {
          drupal_set_message($this->t('The contact form has not been configured. <a href=":add">Add one or more forms</a> .', [
            ':add' => \Drupal::urlGenerator()->generateFromRoute('contact.form_add')]), 'error');
          return [];
        }
        else {
          throw new NotFoundHttpException();
        }
      }
    }

    $message = \Drupal::entityTypeManager()
      ->getStorage('contact_message')
      ->create([
        'contact_form' => $contact_form->id(),
      ]);

    $form = \Drupal::service('entity.form_builder')->getForm($message);
    $form['#title'] = $contact_form->label();
    unset($form['actions']['preview']);
    $form['#cache']['contexts'][] = 'user.permissions';
    \Drupal::service('renderer')->addCacheableDependency($form, $config);

    return [
      '#theme' => 'contact_form',
      '#form' => $form,
    ];
  }

}
