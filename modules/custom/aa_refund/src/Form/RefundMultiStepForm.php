<?php

namespace Drupal\aa_refund\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\PrependCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\StatusMessages;
use Drupal\dcc_multistep\StepPluginManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RefundMultiStepForm.
 *
 * @package Drupal\aa_refund\Form
 */
class RefundMultiStepForm extends FormBase {

  public function __construct(
    StepPluginManagerInterface $stepPluginManager
  ) {
    $this->stepPluginManager = $stepPluginManager;
    $this->steps = $this->stepPluginManager->getSteps($this->getFormId());
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.dcc_multistep.steps')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'refund_multi_step_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#id'] = 'content-header-links-form';
    if (!$form_state->get('step')) {
      $form_state->set('step', 1);
    }
    // Switch values and steps.
    if (!empty($form_state->getTriggeringElement()['#value'])) {
      // Save current form_state.
      $values = $form_state->cleanValues()->getValues();
      $form_state->set('values_' . $form_state->get('step'), $values);
      // If next button is pushed, saves the values and increments the step.
      if ($form_state->getTriggeringElement()['#value'] == 'Next') {
        $form_state->set('step', $form_state->get('step') + 1);
      }
      elseif ($form_state->getTriggeringElement()['#value'] == 'Back') {
        $form_state->set('step', $form_state->get('step') - 1);
      }
      // Get current step form_state.
      $form_state->setValues($form_state->get('values_' . $form_state->get('step')) ?: []);
    }
    // Get current step.
    $step = $form_state->get('step');
    $form['container'] = array(
      '#type' => 'container',
      '#attributes' => array(
        'id' => 'ajaxcontainer',
      ),
    );
    $form['container'] = $form['container'] + $this->getStepFields($step, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $companyReasons = [
      'Technical',
      'Bad weather',
      'Influenced by other flights',
      'Issues with airport',
      'Strike',
      'No reason given',
      'Do not remember',
    ];

    $delay_times = [
      t('Less than 3 hours'),
      t('More than 3 hours'),
      t('Never arrived'),
    ];


    $values = $form_state->cleanValues()->getValues();

    $values['route'] = $form_state->get('values_2')['active'];

    $ser = serialize($values);
    $_SESSION['eligibility'] = $ser;

    if ($this->checkEligilibity()) {
      drupal_set_message('Your claim is valid, please continue');
      $form_state->setRedirect('aa_refund.refund_additional_information_form');
    }
  }

  private function checkEligilibity() {
    return TRUE;
  }

  /**
   * Ajax callback used for replacing the container with the form elements.
   *
   * @param array $form
   *   The form elements.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   The ajax response.
   */
  public function ajax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#ajaxcontainer', $form['container']));
    $response->addCommand(new PrependCommand('#ajaxcontainer', StatusMessages::renderMessages(NULL)));
    $form_state->setRebuild();
    return $response;
  }

  /**
   * Provides the fields for the current step.
   *
   * @param int $step
   *   The current step in the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state object.
   *
   * @return array
   *   The form array.
   */
  protected function getStepFields($step, FormStateInterface $form_state) {
    $stepPlugin = $this->steps->offsetGet($step);

    $fields = $stepPlugin->buildStep($form_state, $this);

    return $fields;
  }

}
