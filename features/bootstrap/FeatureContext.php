<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Danhunsaker\BC;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    protected $latest = null;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given a scale of :arg1
     */
    public function aScaleOf($arg1)
    {
        BC::scale($arg1);
        bcscale($arg1);
    }

    /**
     * @When /I call (BC::\w+)\((\[?[-0-9.,\s]+\]?)\)/
     */
    public function iCallBcMethod($method, $args)
    {
        if ($args[0] == '[') {
            $args = [explode(', ', substr($args, 1, -1))];
        } else {
            $args = explode(', ', $args);
        }
        
        $this->latest = call_user_func_array("Danhunsaker\\{$method}", $args);
    }

    /**
     * @Then /the return value should match (bc\w+)\((\[?[-0-9.,\s]+\]?)\)/
     */
    public function theReturnValueShouldMatchBcFunction($method, $args)
    {
        if ($args[0] == '[') {
            $args = [explode(', ', substr($args, 1, -1))];
        } else {
            $args = explode(', ', $args);
        }

        PHPUnit_Framework_Assert::assertEquals(call_user_func_array($method, $args), $this->latest);
    }

    /**
     * @Then the return value should be :arg1
     */
    public function theReturnValueShouldBe($arg1)
    {
        PHPUnit_Framework_Assert::assertEquals($arg1, $this->latest);
    }
}
