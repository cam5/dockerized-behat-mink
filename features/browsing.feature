Feature: Surfing the Net!
  In order to understand the vastness of the internet
  As a young child
  I need to be able to look up everything

  Scenario: Looking at first page
    Given I go to "http://example.org"
    Then print current URL
    And print last response

  Scenario: Submitting a form
    Given I go to "http://google.com"
    When I fill in "q" with "York Region PHP Meetup"
    # How does this work??
    And I press "Google Search"
    # How does *this* work?
    And print current URL
    Then I should see "https://yorkregionphp.ca/"
    When I follow "York Region PHP Group"
    Then print current URL

  @javascript
  Scenario: Autocomplete
    Given I go to "https://duckduckgo.com/"
    When I fill in "q" with "Why Is Toronto"
    And I wait to see if autocomplete contains "the 6"
    Then print current URL

