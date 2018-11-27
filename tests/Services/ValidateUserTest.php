<?php

namespace Tests\Services;

use App\Services\ValidateUser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Repository\UserRepository;
use App\Entity\User;

class ValidateUserTest extends TestCase
{
    /** @var ValidateUser */
    private $validateUser;

    /** @var MockObject */
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->validateUser = new ValidateUser($this->userRepository);
    }

    public function testUserExistsReturnTypeIsBoolean()
    {
        $this->userRepository->method('findUserByEmail')
            ->with($this->isType('string'))
            ->willReturn(new User());

        $user = $this->userRepository->findUserByEmail('test1@email.com');

        $this->assertInternalType('bool', $this->validateUser->validateUserInstance($user));
    }

    public function testUserExistsReturnIsTrueForExistingEmail()
    {
        $this->userRepository->method('findUserByEmail')
            ->with($this->isType('string'))
            ->willReturn(new User());

        $user = $this->userRepository->findUserByEmail('test1@email.com');

        $this->assertSame(true, $this->validateUser->validateUserInstance($user));
    }

    public function testUserExistsReturnIsNullForNonExistingEmail()
    {
        $this->userRepository->method('findUserByEmail')
            ->with($this->isType('string'))
            ->willReturn('NULL');

        $user = $this->userRepository->findUserByEmail('testWrongEmail@email.com');

        $this->assertSame(false, $this->validateUser->validateUserInstance($user));
    }

    public function testUserAndPasswordMatchesReturnsTrue()
    {
        $userFake = new User();
        $email = 'test1@email.com';
        $password = '1234';

        $userFake->setEmail($email);
        $userFake->setPassword($password);

        $this->userRepository->method('findUserByEmail')
            ->with($this->isType('string'))
            ->willReturn($userFake);

        $user = $this->userRepository->findUserByEmail($email);

        $result = $this->validateUser->validateUserPasswordMatch($user, $email, $password);

        $this->assertSame(true, $result);
    }

    public function testUserAndPasswordNotMatchesReturnsFalse()
    {
        $userFake = new User();
        $wrongEmail = 'testWrong@email.com';
        $password = '1234';
        $validEmail = 'test1@email.com';

        $userFake->setEmail($wrongEmail);
        $userFake->setPassword($password);

        $this->userRepository->method('findUserByEmail')
            ->withAnyParameters()
            ->willReturn($userFake);

        $user = $this->userRepository->findUserByEmail($wrongEmail);

        $result = $this->validateUser->validateUserPasswordMatch($user, $validEmail, $password);

        $this->assertSame(false, $result);
    }
}