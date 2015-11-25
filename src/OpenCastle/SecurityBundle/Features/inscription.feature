Feature: User registration
  Scenario: A user arrives on the homepage, and tries to sign in with correct informations

    Given I am on "/"
    And I click on the element with css selector "a[href=\#modal_inscription]"
    And I wait for AJAX to finish
    And I fill in the following:
      | opencastle_security_player_inscription[username]                | test_user |
      | opencastle_security_player_inscription[plain_password][first]   | testpassword123 |
      | opencastle_security_player_inscription[plain_password][second]  | testpassword123 |
    And I click on the element with css selector "a[id=opencastle_security_inscription_process]"
    Then The toast with text "Votre compte a bien été créé!" is shown 