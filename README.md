# Amazon Behat Context

Provides Behat steps to create Amazon items

## Usage

### Add context to behat.yml:
Add the context under contexts: `DennisDigital\Behat\Amazon\Context\AmazonContext`

### Step definitions

    Given I have Amazon items:

#### Example:

    Given I have Amazon items:
      | asin      | locale |
      | 12345678  | UK     |
      | 56463563  | US     |
