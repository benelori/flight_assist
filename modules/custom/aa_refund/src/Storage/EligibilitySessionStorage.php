<?php

namespace Drupal\aa_refund\Storage;


use Drupal\aa_refund\Plugin\Step\RefundReasonStep;

class EligibilitySessionStorage {

  /**
   * @var string
   */
  protected $route = '';

  /**
   * @var string
   */
  protected $refundReason = '';

  /**
   * @var string
   */
  protected $airline = '';

  /**
   * @var string
   */
  protected $flightNumber = '';

  /**
   * @var \Drupal\Core\Datetime\DrupalDateTime
   */
  protected $departureTime;

  /**
   * @var \Drupal\Core\Datetime\DrupalDateTime
   */
  protected $arrivalTime;

  /**
   * @var \Drupal\aa_refund\Storage\RefundReasonInfo
   */
  protected $refundReasonInfo;

  /**
   * EligibilitySessionStorage constructor.
   *
   * @param string $route
   * @param string $refundReason
   * @param string $airline
   * @param string $flightNumber
   * @param \Drupal\Core\Datetime\DrupalDateTime $departureTime
   * @param \Drupal\Core\Datetime\DrupalDateTime $arrivalTime
   */
  public function __construct(
    $route,
    $refundReason,
    $airline,
    $flightNumber,
    \Drupal\Core\Datetime\DrupalDateTime $departureTime,
    \Drupal\Core\Datetime\DrupalDateTime $arrivalTime
  ) {
    $this->route = $route;
    $this->refundReason = $refundReason;
    $this->airline = $airline;
    $this->flightNumber = $flightNumber;
    $this->departureTime = $departureTime;
    $this->arrivalTime = $arrivalTime;

    switch ($this->refundReasonInfo) {
      case RefundReasonStep::DELAYED:
        $this->refundReasonInfo = new DelayedInfo();
        break;
      case RefundReasonStep::CANCELED:
        $this->refundReasonInfo = new CanceledInfo();
        break;
      case RefundReasonStep::DENIED:
        $this->refundReasonInfo = new DeniedInfo();
        break;
    }

//    $this->refundReasonInfo->build();
  }


}