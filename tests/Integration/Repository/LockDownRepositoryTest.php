<?php declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Repository\LockDownRepository;
use Monolog\Test\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LockDownRepositoryTest extends KernelTestCase
{
    public function testIsInLockDownWithNoLockDownRows()
    {
        $this->bootKernel();

        $lockDownRepository = $this->getContainer()->get(LockDownRepository::class);
        assert($lockDownRepository instanceof LockDownRepository);
        $this->assertFalse($lockDownRepository->isInLockDown());

    }

}