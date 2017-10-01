<?php

/**
 * @file
 * Contains refund_application.page.inc.
 *
 * Page callback for Refund application entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Refund application templates.
 *
 * Default template: refund_application.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_refund_application(array &$variables) {
  // Fetch RefundApplication Entity Object.
  $refund_application = $variables['elements']['#refund_application'];

  $data = unserialize($refund_application->refund_submission_data->value);
  $companyReasons = [
    'Technical',
    'Bad weather',
    'Influenced by other flights',
    'Issues with airport',
    'Strike',
    'No reason given',
    'Do not remember',
  ];

  $delayTime = [
    t('Less than 3 hours'),
    t('More than 3 hours'),
    t('Never arrived'),
  ];
  $deniedTypes = [
    t('Voluntary denial'),
    t('Forced denial'),
  ];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  $variables['content']['refund_data'] = [
    '#theme' => 'refund_data',
    '#first_name' => $data['first_name'],
    '#last_name' => $data['last_name'],
    '#refund_reason' => $data['refund_reason'],
    '#company_reason' => $companyReasons[$data['company_reason']],
    '#delay_time' => $delayTime[$data['delay_time']],
    '#offending_airline' => $data['airline'],
    '#route' => $data['route'],
    '#flight_number' => $data['flight_number'],
    '#optional_description' => $data['optional_description']['value'],
  ];
}
