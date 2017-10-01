<?php

namespace Drupal\iata_codes_api\Service;

use Drupal\Core\Site\Settings;
use Drupal\iata_codes_api\Repository\ExampleApi;
use Drupal\iata_codes_api\Repository\IataCodesApi;

class IataCodesLoader {

  public function autocomplete($query) {
    $api = Settings::get('iata_codes_api_use_test') ? new ExampleApi() : new IataCodesApi();

    return $api->getAutoComplete($query);
  }

}
