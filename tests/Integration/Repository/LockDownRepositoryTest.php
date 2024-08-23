<?php declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Entity\LockDown;
use App\Repository\LockDownRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Test\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LockDownRepositoryTest extends KernelTestCase
{
    public function testIsInLockDownWithNoLockDownRows()
    {
        $this->bootKernel();

        $this->assertFalse($this->getLockDownRepository()->isInLockDown());
    }

    public function testIsInLockDownReturnsTrueIfMostRecentLockDownIsActive()
    {
        $this->bootKernel();

        $lockDown = new LockDown();
        $lockDown->setReason('Dinos have organized their own lunch break');
        $lockDown->setCreatedAt(new \DateTimeImmutable('-1 day'));

        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManagerInterface);
        $entityManager->persist($lockDown);
        $entityManager->flush();

        $this->assertTrue($this->getLockDownRepository()->isInLockDown());
    }

    private function getLockDownRepository(): LockDownRepository
    {
        return $this->getContainer()->get(LockDownRepository::class);
    }

}