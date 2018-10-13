Feature: Post a chirp
  In order to tell the world my thoughts
  As an anonymous user
  I need to be able to post to chirp.ly

  Scenario: Navigating to the "new chirp" page
    Given I am on the homepage
    Then I should see a "a#post-chirp" element
    When I follow "Post Chirp"
    And the response status code should be 200
    Then the url should match "/chirp/new"
    And I should see a "textarea" element
    And print current URL

  Scenario: Making a new chirp
    Given I am on "/chirp/new"
    And I fill in the following:
      | Body | I am really loving this site!!! |
    And I press "Create"
    And the response status code should be 200
    Then the url should match "/chirp/\d+"
    And I should see "I am really loving this site!!!"
