<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\GroceryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: GroceryRepository::class)]
#[ORM\Table(name: 'groceries')]
final class Grocery
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups(['grocery:read'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['grocery:read'])]
    #[SerializedName('name')]
    private string $name;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['grocery:read'])]
    #[SerializedName('type')]
    private string $type;

    #[ORM\Column(type: 'integer')]
    #[Groups(['grocery:read'])]
    #[SerializedName('quantity')]
    private int $quantity;

    #[ORM\Column(type: 'string', length: 10)]
    private string $unit = 'g';

    public function __construct()
    {
        $this->unit = 'g';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }
}
