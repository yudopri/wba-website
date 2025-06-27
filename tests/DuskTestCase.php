<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver()
{
    $options = (new \Facebook\WebDriver\Chrome\ChromeOptions)->addArguments([
        '--disable-gpu',
        '--headless',
    ]);

    return \Facebook\WebDriver\Remote\RemoteWebDriver::create(
    'http://127.0.0.1:9515',
    \Facebook\WebDriver\Remote\DesiredCapabilities::chrome()->setCapability(
        \Facebook\WebDriver\Chrome\ChromeOptions::CAPABILITY, $options
    )
);

}

}
