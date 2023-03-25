<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
      /**
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le nom de l'article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de l'article ne peut pas comporter plus de {{ limit }} caractères"
     * )
     */
    private ?string $nom = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    /**
     * @Assert\GreaterThan(
     *      value = 0,
     *      message = "Le prix de l'article doit être supérieur à {{ compared_value }}"
     * )
     */
    private ?string $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
