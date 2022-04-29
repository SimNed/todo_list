<?php

namespace App\Entity;

use App\Repository\TodoTaskRepository;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoTaskRepository::class)]
#[ApiResource(
    shortName: 'tasks',
    normalizationContext: ['groups' => ['tasks:read']],
    denormalizationContext: ['groups' => ['tasks:write']],
    itemOperations: [
        'get',
        'patch' => ['denormalization_context' => ['groups' => 'tasks:item:write']],
        'delete'
    ],
)]
class TodoTask
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(type: 'integer')
    ]
    private $id;

    #[
        ORM\Column(type: 'string', length: 255),
        Groups(['tasks:read', 'tasks:write', 'tasks:item:write'])
    ]
    private $taskText;

    #[
        ORM\Column(type: 'boolean'),
        Groups(['tasks:read', 'tasks:item:write'])
    ]
    private $isCompleted = false;

    #[
        ORM\Column(type: 'datetime'),
        Groups(['tasks:read'])
    ]
    private $createdAt;

    #[
        ORM\Column(type: 'datetime', nullable: true),
        Groups(['tasks:item:read'])
    ]
    private $completedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskText(): ?string
    {
        return $this->taskText;
    }

    public function setTaskText(string $taskText): self
    {
        $this->taskText = $taskText;

        return $this;
    }

    public function getIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;
        $this->completedAt = new \DateTime();

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }
}
