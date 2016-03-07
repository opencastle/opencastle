@javascript
Feature: User registration
  Scenario: A user arrives on the homepage, and tries to sign in with correct informations
    Given I am on "/"
    And I click on the element with css selector "a[id=btn_inscription]"
    And I wait for AJAX to finish
    And I fill in the following:
      | opencastle_security_player_inscription[username]                | test_user |
      | opencastle_security_player_inscription[plain_password][first]   | testpassword123 |
      | opencastle_security_player_inscription[plain_password][second]  | testpassword123 |
    And I click on the element with css selector "a[id=opencastle_security_inscription_process]"
    Then The toast with text "Votre compte a bien été créé!" is shown

  Scenario: A user arrives on the homepage and tries to register with a wrong password
    Given I am on "/"
    And I click on the element with css selector "a[id=btn_inscription]"
    And I wait for AJAX to finish
    And I fill in the following:
      | opencastle_security_player_inscription[username]                | test_user |
      | opencastle_security_player_inscription[plain_password][first]   | testpassword123 |
      | opencastle_security_player_inscription[plain_password][second]  | testpassword1234 |
    And I click on the element with css selector "a[id=opencastle_security_inscription_process]"
    And I should see 1 "input[class*=invalid][id=opencastle_security_player_inscription_plain_password_second]" elements

  Scenario: A user arrives on the homepage, and tries to sign in with a username already taken
    Given I am on "/"
    And I have a user named "test_user" with the password "testpassword123"
    And I click on the element with css selector "a[id=btn_inscription]"
    And I wait for AJAX to finish
    And I fill in the following:
      | opencastle_security_player_inscription[username]                | test_user |
      | opencastle_security_player_inscription[plain_password][first]   | testpassword123 |
      | opencastle_security_player_inscription[plain_password][second]  | testpassword123 |
    And I click on the element with css selector "a[id=opencastle_security_inscription_process]"
    And I wait for AJAX to finish
    And I should see 1 "input[class*=invalid][id=opencastle_security_player_inscription_username]" elements