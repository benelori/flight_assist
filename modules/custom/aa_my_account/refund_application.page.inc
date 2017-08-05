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

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
