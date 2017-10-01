<?php

namespace Drupal\iata_codes_api\Element;


use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an AJAX/progress aware widget for uploading and saving a file.
 *
 * @FormElement("iata_codes_autocomplete")
 */
class IataCodesAutocomplete extends EntityAutocomplete {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();
    $class = get_class($this);

    // Apply default form element properties.
    $info['#target_type'] = NULL;
    $info['#selection_handler'] = 'default';
    $info['#selection_settings'] = [];
    $info['#tags'] = FALSE;
    $info['#autocreate'] = NULL;
    // This should only be set to FALSE if proper validation by the selection
    // handler is performed at another level on the extracted form values.
    $info['#validate_reference'] = FALSE;
    // IMPORTANT! This should only be set to FALSE if the #default_value
    // property is processed at another level (e.g. by a Field API widget) and
    // it's value is properly checked for access.
    $info['#process_default_value'] = TRUE;

    unset($info['#element_validate']);
    array_unshift($info['#process'], [$class, 'processEntityAutocomplete']);

    return $info;
  }

  public static function processEntityAutocomplete(
    array &$element,
    FormStateInterface $form_state,
    array &$complete_form
  ) {
    $element = parent::processEntityAutocomplete(
      $element,
      $form_state,
      $complete_form
    );

    $element['#autocomplete_route_name'] = 'iata_codes_api.iata_codes_autocomplete_controller';

    return $element;

  }
}
