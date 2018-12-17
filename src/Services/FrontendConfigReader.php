<?php

namespace Drupal\twig_nitro_bridge\Services;

use Deniaz\Terrific\Config\ConfigReader;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\File\FileSystemInterface;

/**
 * Reads configuration from the file config.json in the frontend directory.
 *
 * @package Drupal\twig_nitro_bridge\Services
 */
class FrontendConfigReader implements FrontendConfigReaderInterface {

  /**
   * The path to the frontend directory.
   *
   * @var string
   */
  private $frontendPath;

  /**
   * The frontend configuration array.
   *
   * @var array
   */
  private $frontendConfig;

  /**
   * FrontendConfigReader constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory service.
   * @param string $drupalRoot
   *   The path to the Drupal root directory.
   * @param \Drupal\Core\File\FileSystemInterface $fileSystem
   *   The file system service.
   */
  public function __construct(ConfigFactoryInterface $configFactory, string $drupalRoot, FileSystemInterface $fileSystem) {
    $this->frontendPath = $fileSystem
      ->realpath(
        $drupalRoot . $configFactory->get('twig_nitro_bridge.settings')->get('frontend_dir')
      );

    $terrificConfigReader = new ConfigReader($this->frontendPath);
    $this->frontendConfig = $terrificConfigReader->read();
  }

  /**
   * Returns the frontend configuration from the config.json file as an array.
   *
   * @return array
   *   The frontend configuration.
   */
  public function getConfig() {
    return $this->frontendConfig;
  }

  /**
   * Returns the path to the frontend directory.
   *
   * @return string
   *   Path.
   */
  public function getFrontendPath() {
    return $this->frontendPath;
  }

}
