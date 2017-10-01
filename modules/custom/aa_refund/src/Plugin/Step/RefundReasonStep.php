<?php

namespace Drupal\aa_refund\Plugin\Step;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dcc_multistep\StepPluginBase;

/**
 * Provides Location Step step.
 *
 * @Step(
 *   id = "refund_reason_step",
 *   name = @Translation("Refund Reason Step"),
 *   form_id= "refund_multi_step_form",
 *   step_number = 3,
 * )
 */
class RefundReasonStep extends StepPluginBase {

  const DELAYED = 'Delayed';
  const CANCELED = 'Canceled';
  const DENIED = 'Denied';

  public function buildStep(
    FormStateInterface $form_state,
    FormInterface $form
  ) {
    $fields['refund_reason'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => $this->getRefundReasons(),
      '#ajax' => [
        'callback' => [$this, 'additionalInfo'],
        'wrapper' => 'refund_reason_additional_info',
        'event' => 'change',
        'method' => 'replace',
      ],
    ];

    $fields['refund_reason_additional_info'] = [
      '#prefix' => '<div id="refund_reason_additional_info">',
      '#suffix' => '</div>',
    ];

    $triggeringElement = $form_state->getTriggeringElement();
    if ($triggeringElement['#type'] == 'select' && $triggeringElement['#value'] == 'select_reason') {
      $fields['additional_info'] = [
        '#prefix' => '<div id="refund_reason_additional_info">',
        '#suffix' => '</div>',
        '#limit_validation_errors' => [],
      ];
    }
    if ($triggeringElement['#type'] == 'select' && $triggeringElement['#value'] == self::DELAYED) {
      $fields = $this->buildAdditionInfoElement($fields);
    }
    if ($triggeringElement['#type'] == 'select' && $triggeringElement['#value'] == self::CANCELED) {
      $fields = $this->buildAdditionInfoCancelElement($fields);
    }
    if ($triggeringElement['#type'] == 'select' && $triggeringElement['#value'] == self::DENIED) {
      $fields = $this->buildAdditionInfoDeniedElement($fields);
    }

    $fields['airline'] = [
      '#type' => 'iata_codes_autocomplete',
      '#title' => $this->t('Airline'),
      '#target_type' => 'iata_codes',
      '#required' => TRUE,
    ];

    $fields['flight_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Flight Number'),
      '#required' => TRUE,
    ];

    $fields['departure_time'] = [
      '#type' => 'datetime',
      '#default_value' => new DrupalDateTime('2000-01-01 00:00:00'),
      '#date_date_element' => 'date',
      '#date_time_element' => 'time',
      '#date_year_range' => '2010:+3',
      '#required' => TRUE,
    ];

    $fields['arrival_time'] = [
      '#type' => 'datetime',
      '#default_value' => new DrupalDateTime('2000-01-01 00:00:00'),
      '#date_date_element' => 'date',
      '#date_time_element' => 'time',
      '#date_year_range' => '2010:+3',
      '#required' => TRUE,
    ];

    $fields['eligibility_check'] = array(
      '#type' => 'submit',
      '#value' => t('Check eligility'),
    );
    return $fields;
  }

  private function buildAdditionInfoElement($fields) {
    $companyReasons = [
      'Technical',
      'Bad weather',
      'Influenced by other flights',
      'Issues with airport',
      'Strike',
      'No reason given',
      'Do not remember',
    ];
    $fields['additional_info'] = [
      '#prefix' => '<div id="refund_reason_additional_info">',
      '#suffix' => '</div>',
    ];
    $fields['additional_info']['delay_time'] = [
      '#type' => 'select',
      '#title' => $this->t('Delay Time'),
      '#options' => [
        t('Less than 3 hours'),
        t('More than 3 hours'),
        t('Never arrived'),
      ],
      '#limit_validation_errors' => [],
    ];
    $fields['additional_info']['company_reason'] = [
      '#type' => 'select',
      '#title' => $this->t('Company Reason'),
      '#options' => $companyReasons,
      '#limit_validation_errors' => [],
    ];

    return $fields;
  }

  private function buildAdditionInfoCancelElement($fields) {
    $fields['additional_info'] = [
      '#prefix' => '<div id="refund_reason_additional_info">',
      '#suffix' => '</div>',
    ];

    $fields['additional_info']['airline_statement_period'] = [
      '#limit_validation_errors' => [],
      '#type' => 'number',
      '#title' => t('Airline Statement'),
      '#description' => t('Please enter the number of hours between the airline notice and departure'),
    ];

    return $fields;
  }

  private function buildAdditionInfoDeniedElement($fields) {
    $options = [
      t('Voluntary denial'),
      t('Forced denial'),
    ];
    $fields['additional_info'] = [
      '#prefix' => '<div id="refund_reason_additional_info">',
      '#suffix' => '</div>',
    ];

    $fields['additional_info']['denial_type'] = [
      '#prefix' => '<div id="refund_reason_additional_info">',
      '#suffix' => '</div>',
      '#type' => 'select',
      '#title' => $this->t('Denied Reason'),
      '#options' => $options,
      '#limit_validation_errors' => [],
    ];

    return $fields;
  }

  private function getRefundReasons() {
    return [
      'select_reason' => t('Select a reason'),
      self::DELAYED => t(self::DELAYED),
      self::CANCELED => t(self::CANCELED),
      self::DENIED => t(self::DENIED),
    ];
  }

  public function additionalInfo($form, FormStateInterface $formState) {
    return $form['container']['additional_info'];
  }

}