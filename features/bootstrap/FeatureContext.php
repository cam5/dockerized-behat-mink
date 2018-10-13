<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert as Assertions;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    private $result;

    /**
     * @param mixed
     */
    public function __construct()
    {
        $driver  = new GoutteDriver();
        $this->session = new Session($driver);

        // start the session
        $this->session->start();
    }//end __construct()

    /**
     * @Given we know about numbers
     */
    public function weKnowAboutNumbers()
    {
        Assertions::assertTrue(function_exists('is_int'));
    }

    /**
     * @When I add :arg1 and :arg2
     */
    public function iAddAnd($arg1, $arg2)
    {
        $this->result = ((int) $arg1 + (int) $arg2);
    }

    /**
     * @Then the result should equal :arg1
     */
    public function theResultShouldEqual($arg1)
    {
        Assertions::assertEquals(
            (int) $arg1,
            $this->result
        );
    }

    /**
     * @Given I print the contents of :url
     */
    public function iPrintContentsOf($url)
    {
        $this->session->visit($url);

        var_dump($this->session->getPage()->getContent());
    }//end iPrintContentsOf()

    /**
     * @When I wait to see if autocomplete contains :words
     */
    public function iWaitToSeeWords($words)
    {
        $this->getSession()->wait(
            5000,
            "document.querySelectorAll('.search__autocomplete').length"
        );

        Assertions::assertContains(
            $words,
            $this->getSession()->evaluateScript("document.querySelectorAll('.search__autocomplete')[0].innerText")
        );
    }
}//end class
