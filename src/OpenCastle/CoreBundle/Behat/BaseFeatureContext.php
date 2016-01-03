<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 25.11.15
 * Time: 18:42.
 */
namespace OpenCastle\CoreBundle\Behat;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Base Behat context, contains shared functions.
 */
class BaseFeatureContext extends MinkContext implements KernelAwareContext
{
    use KernelDictionary;

    /**
     * @var Application
     */
    private $application;

    /**
     * Clear the database before each scenario.
     *
     * @BeforeScenario
     */
    public function resetEnvironment()
    {
        $this->application = new Application($this->getContainer()->get('kernel'));
        $this->application->setAutoExit(false);
        $this->runConsole('cache:clear');
        $this->runConsole('doctrine:schema:drop', array('--force' => true));
        $this->runConsole('doctrine:schema:create', array());
        $this->runConsole('doctrine:schema:update', array('--force' => true));
        $this->runConsole('doctrine:fixtures:load', array('-n' => true));
    }

    /**
     * Launch the given command.
     *
     * @param string $command
     * @param array  $options
     *
     * @return int
     */
    protected function runConsole($command, array $options = array())
    {
        $options['-e'] = 'test';
        $options['-q'] = true;
        $options = array_merge($options, array('command' => $command));

        return $this->application->run(new ArrayInput($options));
    }

    /**
     * Wait for a toast to be shown.
     *
     * @Given /^The toast with text "(.*)" is shown$/
     *
     * @param string $text
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
            '(typeof(jQuery)=="undefined" || (0 === jQuery.active && 0 === jQuery(\':animated\').length))'
        );
    }

    /**
     * Click on the element with the provided CSS Selector.
     *
     * @When /^I click on the element with css selector "([^"]*)"$/
     *
     * @param string $cssSelector
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
