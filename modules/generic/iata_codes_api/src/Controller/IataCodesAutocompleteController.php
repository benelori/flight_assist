<?php

namespace Drupal\iata_codes_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iata_codes_api\Service\IataCodesLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IataCodesAutocompleteController.
 *
 * @package Drupal\iata_codes_api\Controller
 */
class IataCodesAutocompleteController extends ControllerBase {

  /**
   * Drupal\iata_codes_api\Service\IataCodesLoader definition.
   *
   * @var \Drupal\iata_codes_api\Service\IataCodesLoader
   */
  protected $iataCodesApiCodesLoader;

  /**
   * Constructs a new IataCodesAutocompleteController object.
   */
  public function __construct(IataCodesLoader $iata_codes_api_codes_loader) {
    $this->iataCodesApiCodesLoader = $iata_codes_api_codes_loader;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('iata_codes_api.codes_loader')
    );
  }

  /**
   * Handleautocomplete.
   *
   * @return string
   *   Return Hello string.
   */
  public function handleAutocomplete(Request $request) {
    $data = [];
    // Get the typed string from the URL, if it exists.
    if ($input = $request->query->get('q')) {
      $data = $this->iataCodesApiCodesLoader->autocomplete($input);
    }

    return new JsonResponse($data);
  }

}
