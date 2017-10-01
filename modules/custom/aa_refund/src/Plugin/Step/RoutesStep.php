<?php

namespace Drupal\aa_refund\Plugin\Step;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\dcc_multistep\StepPluginBase;

/**
 * Provides Location Step step.
 *
 * @Step(
 *   id = "routes_step",
 *   name = @Translation("Routes Step"),
 *   form_id= "refund_multi_step_form",
 *   step_number = 1,
 * )
 */
class RoutesStep extends StepPluginBase {

  /**
   * {@inheritdoc}
   */
  public function buildStep(
    FormStateInterface $form_state,
    FormInterface $form
  ) {
    $fields['departure'] = [
      '#type' => 'iata_codes_autocomplete',
      '#title' => $this->t('Departure'),
      '#target_type' => 'iata_codes',
      '#required' => TRUE,
    ];

    $fields['arrival'] = [
      '#type' => 'iata_codes_autocomplete',
      '#title' => $this->t('Arrival'),
      '#required' => TRUE,
      '#target_type' => 'iata_codes',
    ];


    $fields['tab'] = [
      '#title' => $this->t('Stop Overs'),
      '#type' => 'fieldset',
    ];
    $values = [];
    $linkNumber = $form_state->get('link_number');
    $triggeringElement = $this->whichTriggeringElement($form_state);

    // If the triggering element is null, then the form building is on page
    // load or the first building on a button press, which doesn't concern us.
    if (is_null($triggeringElement)) {
      if ($values && is_array($values)) {
        $linkNumber = count($values);
      }
      else {
        $linkNumber = 1;
      }
    }
    elseif ($triggeringElement == 'Add more') {
      $linkNumber++;
    }
    $this->buildElements($fields, $form_state, $linkNumber, $values);
    if ($triggeringElement == 'Remove') {
      $linkNumber--;
      $this->removeElements($fields, $form_state);
    }

    $form_state->set('link_number', $linkNumber);

    $fields['next'] = array(
      '#type' => 'button',
      '#value' => 'Next',
      '#ajax' => array(
        'callback' => array($form, 'ajax'),
        'event' => 'click',
        'progress' => array(
          'type' => 'throbber',
          'message' => NULL,
        ),
      ),
    );

    return $fields;
  }

  /**
   * Builds the form.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   * @param int $linkNumber
   *   The number of elements.
   * @param array $configValues
   *   The config values.
   */
  private function buildElements(array &$form, FormStateInterface $form_state, $linkNumber, array $configValues) {
    for ($i = 0; $i < $linkNumber; $i++) {

      $form['tab']['stop_over_' . $i] = [
        '#type' => 'iata_codes_autocomplete',
        '#title' => $this->t('Stop Over %number', [
          '%number' => $i,
        ]),
        '#target_type' => 'iata_codes',
      ];

      if ($linkNumber > 1) {
        $form['tab']['remove_button_' . $i] = [
          '#type' => 'button',
          '#value' => $this->t('Remove'),
          '#name' => 'remove_button_' . $i,
          '#ajax' => [
            'callback' => [$this, 'remove'],
            'wrapper' => 'content-header-links-form',
          ],
        ];
      }
    }
    $form['add_more_stopovers'] = [
      '#type' => 'button',
      '#value' => $this->t('Add more'),
      '#ajax' => [
        'callback' => [$this, 'addMore'],
        'wrapper' => 'content-header-links-form',
      ],
    ];
  }

  /**
   * Ajax callback for adding an additional element.
   *
   * @param array $form
   *   The form render array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form render array.
   */
  public function addMore(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * Ajax callback for removing elements.
   *
   * @param array $form
   *   The form render array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form render array.
   */
  public function remove(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * Removes an element.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  private function removeElements(array &$form, FormStateInterface $form_state) {
    $triggeringElementName = $form_state->getTriggeringElement()['#name'];
    $number = $this->getRemoveButtonNumber($triggeringElementName);

    if (isset($number)) {
      $number = (int) $number;
      unset($form['tab'][$number]);
    }
  }

  /**
   * Gets the number of the remove button.
   *
   * @param string $triggeringElementName
   *   The name of the button.
   *
   * @return int|null
   *   Returns a number or null.
   */
  private function getRemoveButtonNumber(string $triggeringElementName) {
    $number = array_pop(explode('_', $triggeringElementName));

    return ctype_digit($number) ? (int) $number : NULL;
  }

  /**
   * Determines the triggering element.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return null|string
   *   The value of the triggering element.
   */
  private function whichTriggeringElement(FormStateInterface $form_state) {
    /** @var \Drupal\Core\StringTranslation\TranslatableMarkup $element */
    $element = $form_state->getTriggeringElement()['#value'];

    if ($element instanceof TranslatableMarkup) {
      return $element->getUntranslatedString();
    }

    return NULL;
  }



}