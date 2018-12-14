<?php

namespace Drupal\twig_nitro_bridge\Adapter;

use Deniaz\Terrific\Provider\TemplateInformationProviderInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\twig_nitro_bridge\Services\FrontendConfigReader;

/**
 * Class TemplateInformationProvider.
 *
 * @package Drupal\twig_nitro_bridge\Adapter
 */
class TemplateInformationProvider implements TemplateInformationProviderInterface {
  /**
   * List of paths where templates are stored.
   *
   * @var array
   */
  private $paths = [];

  /**
   * Path to Frontend Directory.
   *
   * @var string
   */
  private $frontendPath = '';

  /**
   * Terrific's config.json Content.
   *
   * @var array
   */
  private $terrificConfig = [];

  /**
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * TemplateLocator constructor.
   *
   * @param \Drupal\twig_nitro_bridge\Services\FrontendConfigReader $frontendConfigReader
   *   The frontend config reader service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   The logger factory service.
   */
  public function __construct(FrontendConfigReader $frontendConfigReader, LoggerChannelFactoryInterface $loggerFactory) {
    $this->terrificConfig = $frontendConfigReader->getConfig();
    $this->frontendPath = $frontendConfigReader->getFrontendPath();
    $this->logger = $loggerFactory->get('twig_nitro_bridge');
  }

  /**
   * Returns a list of paths where templates can be found.
   *
   * @return array
   *   Return array of paths.
   */
  public function getPaths() {
    if (empty($this->paths)) {
      $this->generatePaths();
    }

    return $this->paths;
  }

  /**
   * Generate Paths array from Terrific Configuration.
   */
  private function generatePaths() {
    $components = $this->terrificConfig['nitro']['views'];
    foreach ($components as $name => $component) {
      $this->paths[$name] = $this->frontendPath . '/' . $component['path'];
    }
  }

  /**
   * File extension.
   *
   * @return mixed
   *   Template File Extension.
   *
   * @throws \Drupal\twig_nitro_bridge\Adapter\DomainException
   *    Exception.
   */
  public function getFileExtension() {
    $fileExtension = $this->terrificConfig['nitro']['view_file_extension'];
    if (!isset($fileExtension)) {
      $this->logger->notice('Frontend Template File Extension not defined in Terrific\'s Configuration File.');
    }

    return $fileExtension;
  }

}
