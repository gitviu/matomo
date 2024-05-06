<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CoreHome\tests\Integration;

use Piwik\Tests\Framework\TestCase\IntegrationTestCase;

use Piwik\Tests\Framework\Mock\FakeAccess;
use Piwik\Tests\Framework\Fixture;
use Piwik\Plugins\LanguagesManager\LanguagesManager;
use Piwik\Plugins\CoreHome\Widgets\GetCurrentlocaltime;

/**
 * @group CoreHome
 * @group GetCurrentlocaltimeTest
 * @group Plugins
 */
class GetCurrentlocaltimeTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $idSite = Fixture::createWebsite('2022-01-01 00:00:00', 0, 'TestSite', 'http://example.com', 1, null, null, 'Europe/Paris');
        $_GET['idSite'] = $idSite;
    }

    public function tearDown(): void
    {
        // clean up your test here if needed

        parent::tearDown();
    }

    /**
     * All your actual test methods should start with the name "test"
     */
    public function testWebsiteTimezoneInWidget()
    {

        $instance = new GetCurrentlocaltime();

        $tplHtml = $instance->render();
        $this->assertStringContainsString("options.timeZone = 'Europe/Paris';", $tplHtml);
    }

    public function testUserTimeFormatSettingsInWidget()
    {

        $instance = new GetCurrentlocaltime();
        $tplHtml = $instance->render();

        $currentTimeFormat = (int) LanguagesManager::uses12HourClockForCurrentUser();

        $this->assertStringContainsString("hour12: $currentTimeFormat", $tplHtml);
    }

    public function provideContainerConfig()
    {
        return array(
            'Piwik\Access' => new FakeAccess()
        );
    }
}
