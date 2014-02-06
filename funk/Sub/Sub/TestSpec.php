<?php

namespace funk\Sub\Sub;

use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\Selenium2Driver;
use Funk\Spec;

class TestSpec implements Spec
{
    public function __construct()
    {
        $this->mink = new Mink([
            'selenium2' => new Session(new Selenium2Driver)
        ]);
    }

    function it_should_display_behat_moto()
    {
        $session = $this->mink->getSession('selenium2');
        $session->visit('http://behat.org');
        $this->mink->assertSession('selenium2')
            ->pageTextContains('A php framework for testing your business expectations.')
        ;
    }

    function it_should_not_talk_about_phpunit()
    {
        $session = $this->mink->getSession('selenium2');
        $session->visit('http://behat.org');
        $this->mink->assertSession('selenium2')
            ->pageTextNotContains('phpunit')
        ;
    }

    function it_should_talk_about_konstantin()
    {
        $session = $this->mink->getSession('selenium2');
        $session->visit('http://behat.org');
        $this->mink->assertSession('selenium2')
            ->pageTextContains('Konstantin')
        ;
    }

    function it_should_not_fail()
    {
        $session = $this->mink->getSession('selenium2');
        $session->visit('http://behat.org');
        throw new \Exception;
        $this->mink->assertSession('selenium2')
            ->pageTextContains('Konstantin')
        ;
    }
}
