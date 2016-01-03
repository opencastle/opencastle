Feature: User login
  Scenario: A user arrives on the homepage, and tries to login with wrong credentials
    Given I am on "/"
    And I click on the element with css selector "a[id=btn_connexion]"
    And I wait for AJAX to finish
    And I fill in the following:
      | _username | wronguser |
      | _password | wrongpass |
    And I click on the element with css selector "a[id=opencastle_security_connexion_submit]"
    And I wait for AJAX to finish
    Then I should see "Login ou mot de passe incorrect"

  Scenario: A user arrives on the homepage, and tries to login with correct credentials
    Given I am on "/"
    And I have a user named "test_user" with the password "testpassword123"
    And I click on the element with css selector "a[id=btn_connexion]"
    And I wait for AJAX to finish
    And I fill in the following:
      | _username | test_user |
      | _password | testpassword123 |
    And I click on the element with css selector "a[id=opencastle_security_connexion_submit]"
    And I wait for AJAX to finish
    Then I should not see "Login ou mot de passe incorrect"