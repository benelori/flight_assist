<?php

namespace Drupal\aa_refund\Plugin\Step;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dcc_multistep\StepPluginBase;

/**
 * Provides Location Step step.
 *
 * @Step(
 *   id = "bad_route_step",
 *   name = @Translation("Bad Route Step"),
 *   form_id= "refund_multi_step_form",
 *   step_number = 2,
 * )
 */
class BadRouteStep extends StepPluginBase {

  public function buildStep(
    FormStateInterface $form_state,
    FormInterface $form
  ) {
    $values = $form_state->get('values_1');

    $fields['settings']['active'] = [
      '#type' => 'radios',
      '#title' => $this->t('Where did the problem occur'),
      '#options' => $this->formatGroups($this->groupRoutes($values)),
    ];

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

  private function formatGroups($groups) {
    $output = [];
    foreach ($groups as $group) {
      $output[$group['departure'] . ' - ' . $group['arrival']] = $group['departure'] . ' - ' . $group['arrival'];
    }

    return $output;
  }
  private function groupRoutes(array $values) {
    $stopOvers = [];
    foreach ($values as $key => $value) {
      if (preg_match('/stop_over_/', $key, $matches) && $value) {
        $stopOvers[] = $value;
      }
    }

    switch (count($stopOvers)) {
      case 0:
        $group[0] = [
          'departure' => $values['departure'],
          'arrival' => $values['arrival'],
        ];
        break;
      case 1:
        $group[0] = [
          'departure' => $values['departure'],
          'arrival' => $stopOvers[0],
        ];
        $group[1] = [
          'departure' => $stopOvers[0],
          'arrival' => $values['arrival'],
        ];
        break;
      default:
        $group[0] = [
          'departure' => $values['departure'],
          'arrival' => $stopOvers[0],
        ];

        for($i = 1; $i < count($stopOvers) - 1; $i++) {
          $group[] = [
            'departure' => $stopOvers[$i],
            'arrival' => $stopOvers[$i + 1],
          ];
        }

        $group[] = [
          'departure' => $stopOvers[$i],
          'arrival' => $values['arrival'],
        ];
        break;
    }

    return $group;
  }

}