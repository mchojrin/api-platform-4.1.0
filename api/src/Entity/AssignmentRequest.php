<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\AssignmentRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Post;
use App\Enum\AssignmentRequestStatus;
use App\State\AssignmentRequestProcessor;
use ApiPlatform\OpenApi\Model;

#[ApiResource(
    mercure: true,
    operations: [
        new Post(
            security: "is_granted('ROLE_CLIENT')",
            processor: AssignmentRequestProcessor::class,
            denormalizationContext: ['groups' => ['assignment:post']],
            inputFormats: ['json' => ['application/json']],
            openapi: new Model\Operation(
                summary: 'Create a new assignment request',
                description: 'It doesn\'t require a body. The system takes care of everything',
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [] 
                            ]
                        ]
                    ])
                )
            )
        ),
        new Get(
            security: "is_granted('ROLE_CLIENT') or is_granted('ROLE_ADMIN')"
        )
    ]
)]
#[ORM\Entity(repositoryClass: AssignmentRequestRepository::class)]
class AssignmentRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\OneToOne(mappedBy: 'request', cascade: ['persist', 'remove'])]
    private ?Assignment $assignment = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAssignment(): ?Assignment
    {
        return $this->assignment;
    }

    public function setAssignment(Assignment $assignment): static
    {
        // set the owning side of the relation if necessary
        if ($assignment->getRequest() !== $this) {
            $assignment->setRequest($this);
        }

        $this->assignment = $assignment;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): AssignmentRequestStatus 
    {
        return !empty($this->getAssignment()) ? AssignmentRequestStatus::Scheduled : AssignmentRequestStatus::Pending;
    }
}
