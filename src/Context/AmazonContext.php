<?php
namespace DennisDigital\Behat\Amazon\Context;

use Drupal\DrupalExtension\Context\DrupalAwareInterface;
use Drupal\DrupalDriverManager;
use Behat\Testwork\Hook\HookDispatcher;
use Behat\Gherkin\Node\TableNode;

/**
 * AmazonContext
 */
class AmazonContext implements DrupalAwareInterface {
  /**
   * @var array Amazon items.
   */
  protected $items = array();

  /**
   * @var DrupalDriverManager
   */
  protected $drupal;

  /**
   * @var HookDispatcher
   */
  protected $dispatcher;

  /**
   * @var array
   */
  protected $parameters = array();

  /**
   * @inheritDoc
   */
  public function setDrupal(DrupalDriverManager $drupal) {
    $this->drupal = $drupal;
  }

  /**
   * @inheritDoc
   */
  public function setDispatcher(HookDispatcher $dispatcher) {
    $this->dispatcher = $dispatcher;
  }

  /**
   * @inheritDoc
   */
  public function getDrupal() {
    return $this->drupal;
  }

  /**
   * @inheritDoc
   */
  public function setDrupalParameters(array $parameters) {
    $this->parameters = $parameters;
  }

  /**
   * @Given I have Amazon items:
   */
  public function generateItems(TableNode $table) {
    $json = json_decode(file_get_contents(dirname(__FILE__) . '/data_provider/amazon_item.json'), TRUE);
    foreach ($table as $row) {
      $item = $json;
      foreach ($row as $key => $value) {
        $item[$key] = $value;
      }
      $this->items[] = $item;
      amazon_item_insert($item);
    }
  }

  /**
   * Remove any created items.
   *
   * @AfterScenario
   */
  public function cleanup() {
    foreach ($this->items as $item) {
      amazon_item_delete($item['asin'], $item['locale']);
    }
  }
}
