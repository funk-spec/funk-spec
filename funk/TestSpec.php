<?php

namespace funk;

use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\Selenium2Driver;
use Funk\Spec;
use Behat\MinkExtension\Context\MinkAwareContext;

class TestSpec implements Spec, MinkAwareContext
{
    public function setMink(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function setMinkParameters(array $parameters)
    {
        $this->minkParameters = $parameters;
    }

    function it_should_display_behat_moto()
    {
        $session = $this->mink->getSession();
        $session->visit('http://behat.org');
        $this->mink->assertSession()
            ->pageTextContains('A php framework for testing your business expectations.')
        ;
    }

    function it_should_not_talk_about_phpunit()
    {
        $session = $this->mink->getSession();
        $session->visit('http://behat.org');
        $this->mink->assertSession()
            ->pageTextNotContains('phpunit')
        ;
    }

    function it_should_talk_about_konstantin()
    {
        $session = $this->mink->getSession();
        $session->visit('http://behat.org');
        $this->mink->assertSession()
            ->pageTextContains('Konstantin')
        ;
    }

    function it_should_not_fail()
    {
        $session = $this->mink->getSession();
        $session->visit('http://behat.org');
        throw new \Exception;
        $this->mink->assertSession()
            ->pageTextContains('Konstantin')
        ;
    }
}
