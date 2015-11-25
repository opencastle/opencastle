<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 25.11.15
 * Time: 18:42
 */

namespace OpenCastle\CoreBundle\Behat;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Base Behat context, contains shared functions
 */
class BaseFeatureContext extends MinkContext implements KernelAwareContext
{
    use KernelDictionary;

    /**
     * Wait for a toast to be shown
     *
     * @Given /^The toast with text "(.*)" is shown$/
     */
    public function toastIsShown($text)
    {
        $this->getSession()->wait(
            20000,
            "$('.toast:contains(\"".$text."\")').length > 0"
        );
    }

    /**
     * Wait for AJAX to finish.
     *
     * @Given I wait for AJAX to finish
     */
    public function iWaitForAjaxToFinish()
    {
        $this->getSession()->wait(
            10000,
            '(typeof(jQuery)=="undefined" || (0 === jQuery.active))'
        );
    }
    /**
     * Click on the element with the provided CSS Selector
     *
     * @When /^I click on the element with css selector "([^"]*)"$/
     */
    public function iClickOnTheElementWithCSSSelector($cssSelector)
    {
        $session = $this->getSession();

        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('css', $cssSelector) // just changed xpath to css
        );

        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $cssSelector));
        }

        $element->click();
    }

}
