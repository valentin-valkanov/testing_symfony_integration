<?php declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Repository\LockDownRepository;
use Monolog\Test\TestCase;

class LockDownRepositoryTest extends TestCase
{
    public function testIsInLockDownWithNoLockDownRows()
    {
        $repository = new LockDownRepository();
    }

}