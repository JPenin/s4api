<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Entity\User;

/**
 * Class ValidateUser
 *
 * @package App\Services
 */
class ValidateUser
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function userExists($email) : bool
    {
        $user = $this->userRepository->findUserByEmail($email);

        return $this->validateUserInstance($user);
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function EmailAndPasswordMatches($email, $password) : bool
    {
        $userMatches = false;

        $user = $this->userRepository->findUserByEmail($email);

        if ($this->validateUserInstance($user)) {
            $userMatches = $this->validateUserPasswordMatch($user, $email, $password);
        }

        return $userMatches;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function validateUserInstance($user) : bool
    {
        return ($user instanceOf User);
    }

    /**
     * @param User $user
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function validateUserPasswordMatch($user, $email, $password) : bool
    {
        $userPasswordMatches = false;

        if ($user->getEmail() == $email && $user->getPassword() == $password) {

            $userPasswordMatches = true;
        }

        return $userPasswordMatches;
    }
}