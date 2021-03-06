<?php

namespace App\Repository;

interface RepositoryInterface
{
    public function findAll();

    public function findBy(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null);
}