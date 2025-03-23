<?php

namespace App\Entity;

use App\Interface\ICalculateAmount;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(['name'])]
class Category implements ICalculateAmount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    /**
     * @var Collection<int, Depense>
     */
    #[ORM\OneToMany(targetEntity: Depense::class, mappedBy: 'category')]
    private Collection $depenses;

    public function __construct()
    {
        $this->depenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection<int, Depense>
     */
    public function getDepenses(): Collection
    {
        return $this->depenses;
    }

    public function addDepense(Depense $depense): static
    {
        if (!$this->depenses->contains($depense)) {
            $this->depenses->add($depense);
            $depense->setCategory($this);
        }

        return $this;
    }

    public function removeDepense(Depense $depense): static
    {
        if ($this->depenses->removeElement($depense)) {
            // set the owning side to null (unless already changed)
            if ($depense->getCategory() === $this) {
                $depense->setCategory(null);
            }
        }

        return $this;
    }

    public function GetSumAmount(): float
    {
        $res = 0;

        foreach($this->depenses as $depense)
        {
            $res += $depense->getAmount();
        } 

        return $res;
    }

    public function GetSumAmountMonth(): float
    {
        $res = 0;

        $currentMonth = date('n');
        $currentYear = date('Y');

        foreach($this->depenses as $depense)
        {
            $depenseMonth = date('n',$depense->getCreated()->getTimestamp());
            $depenseYear = date('Y',$depense->getCreated()->getTimestamp());
            if( $depenseMonth === $currentMonth &&  $depenseYear === $currentYear)
                $res += $depense->getAmount();
        } 

        return $res;
    }
}
