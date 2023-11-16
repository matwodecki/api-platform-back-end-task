<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use App\Validator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    order: ['data_przyjecia' => 'DESC'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch()
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'partial', 'model' => 'ipartial'])]
class Fixture
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public string $marka = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    public string $model = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    public string $nr_seryjny = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?\DateTimeImmutable $data_przyjecia = null;

    #[ORM\Column(length: 1000, nullable: true)]
    public ?string $opis = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Validator\AllowedStatus]
    public string $status = '';

    public function getId(): ?int
    {
        return $this->id;
    }
}
