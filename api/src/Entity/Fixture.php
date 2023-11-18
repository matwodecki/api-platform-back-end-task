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
use App\Enum\Status;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    order: ['dataPrzyjecia' => 'DESC'],
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
    #[Assert\Length(
        max: 50,
        maxMessage: 'Zbyt długa marka'
    )]
    public string $marka = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Zbyt długi model'
    )]
    public string $model = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Zbyt długi model seryjny'
    )]
    public string $nrSeryjny = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?\DateTimeImmutable $dataPrzyjecia = null;

    #[ORM\Column(length: 1000, nullable: true)]
    #[Assert\Length(
        max: 1000,
        maxMessage: 'Zbyt długi opis'
    )]
    public ?string $opis = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?Status $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
