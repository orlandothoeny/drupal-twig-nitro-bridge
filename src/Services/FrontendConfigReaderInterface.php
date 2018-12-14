<?php

namespace Drupal\twig_nitro_bridge\Services;

/**
 * Reads configuration from the file config.json in the frontend directory.
 *
 * @package Drupal\twig_nitro_bridge\Services
 */
interface FrontendConfigReaderInterface {

  /**
   * Returns the frontend configuration from the config.json file as an array.
   *
   * @return array
   *   The frontend configuration.
   */
  public function getConfig();

  /**
   * Returns the path to the frontend directory.
   *
   * @return string
   *   Path.
   */
  public function getFrontendPath();

}
