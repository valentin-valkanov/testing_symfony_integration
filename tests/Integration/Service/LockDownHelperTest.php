<?php declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Enum\LockDownStatus;
use App\Factory\LockDownFactory;
use App\Service\GithubService;
use App\Service\LockDownHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LockDownHelperTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    public function testEndCurrentLockdown()
    {
        self::bootKernel();

        $lockDown = LockDownFactory::createOne([
            'status' => LockDownStatus::ACTIVE
        ]);

        $gitHubService = $this->createMock(GithubService::class);
        $gitHubService->expects($this->once())
            ->method('clearLockDownAlerts');
        self::getContainer()->set(GithubService::class, $gitHubService);

        $lockDownHelper = self::getContainer()->get(LockDownHelper::class);
        assert($lockDownHelper instanceof LockDownHelper);


        $lockDownHelper->endCurrentLockDown();
        $this->assertSame(LockDownStatus::ENDED, $lockDown->getStatus());

    }
}