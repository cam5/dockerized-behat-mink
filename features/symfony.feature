Feature: Testing Our App
  In order to Smoke Test this thing
  As Developer
  I need to be able to look at what is on the webroot

  Scenario: Visiting Homepage
    Given I am on the homepage
    Then print last response
    Then I should see text matching "Hello, and welcome to chirp.ly. The premier site for people who only want to post 140 characters at a time"
    And the response status code should be 200

