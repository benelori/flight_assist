<?php

namespace Drupal\aa_pages\Theme;


use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

class ThemeNegotiator implements ThemeNegotiatorInterface {

  public function applies(RouteMatchInterface $route_match) {
    return TRUE;
  }

  public function determineActiveTheme(RouteMatchInterface $route_match) {
    $test = $route_match->getRouteName();

    if (in_array($test, ['entity.node.canonical', 'view.frontpage.page_1'])) {
      return 'aa_theme';
    }

    return 'bartik';
  }


}