<?php
namespace DennisDigital\Behat\Amazon\Context;

use Behat\Gherkin\Node\TableNode;
use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * AmazonContext
 */
class AmazonContext extends RawDrupalContext {
  /**
   * @var array Amazon items.
   */
  protected $items = array();

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
