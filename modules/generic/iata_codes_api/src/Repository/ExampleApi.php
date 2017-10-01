<?php

namespace Drupal\iata_codes_api\Repository;


class ExampleApi implements IataApiInterface {

  public function getAutoComplete($query) {
    $path = drupal_get_path('module', 'iata_codes_api');
    $path .= '/tests/fixtures/autocomplete.json';
    $file = file_get_contents($path);
    $data = json_decode($file, TRUE);
    $output = [];
    foreach ($data['response']['airports'] as $key => $airport) {
      $output[$key]['value'] = $airport['name'] . ', ' . $airport['code'];
      $output[$key]['label'] = $airport['name'] . ', ' . $airport['code'];
    }

    return $output;
  }

}
