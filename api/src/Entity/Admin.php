<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    public function getRoles(): array
    {
        return array_merge(parent::getRoles(), ['ROLE_ADMIN']);
    }
}
