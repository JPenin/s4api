<?php

namespace Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = new User();
        $this->user->setEmail('test1@email.com');
        $this->user->setPassword('1234');
    }

    public function testInstanceResultReceivedFromExistingEmail()
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->once())
            ->method('findUserByEmail')
            ->willReturn($this->user);

        $this->assertInstanceOf(
            User::class,
            $userRepository->findUserByEmail('test1@email.com')
        );
    }

    public function testFindUserByEmailReturnsUserData()
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->any())
            ->method('findUserByEmail')
            ->with($this->isType('string'))
            ->willReturn($this->user);

        /** @var User $user */
        $user = $userRepository->findUserByEmail('test1@email.com');

        $this->assertSame($user->getEmail(), $this->user->getEmail());
        $this->assertSame($user->getPassword(), $this->user->getPassword());
    }
}