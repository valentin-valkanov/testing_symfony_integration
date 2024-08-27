<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\LockDown;
use App\Enum\LockDownStatus;
use App\Repository\LockDownRepository;
use Doctrine\ORM\EntityManagerInterface;

class LockDownHelper
{
    public function __construct(
        private LockDownRepository $lockDownRepository,
        private EntityManagerInterface $entityManager,
        private GithubService $githubService
    )
    {
    }
    public function endCurrentLockDown(): void
    {
        $lockDown = $this->lockDownRepository->findMostRecent();
        if (!$lockDown) {
            throw new \LogicException('There is no lock down to end');
        }
        $lockDown->setStatus(LockDownStatus::ENDED);
        $this->entityManager->flush();

        $this->githubService->clearLockDownAlerts();
    }

    public function dinoEscaped(): void
    {
        $lockDown = new LockDown();
        $lockDown->setStatus(LockDownStatus::ACTIVE);
        $lockDown->setReason('Dino escaped... NOT good...');
        $this->entityManager->persist($lockDown);
        $this->entityManager->flush();
        // send an email with subject like "RUUUUUUNNNNNN!!!!"
    }
}