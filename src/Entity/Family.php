<?php

namespace App\Entity;

use App\Interface\ICalculateAmount;
use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family implements ICalculateAmount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'family')]
    private Collection $members;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setFamily($this);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getFamily() === $this) {
                $member->setFamily(null);
            }
        }

        return $this;
    }

    public function getSumAmount(): float
    {
        $res = 0;

        foreach ($this->members as $member) {
            $res += $member->getSumAmount();
        }

        return $res;
    }

    public function getSumAmountMonth(): float
    {
        $res = 0;

        foreach ($this->members as $member) {
            $res += $member->getSumAmountMonth();
        }

        return $res;
    }

    public function getPassword2(): string
    {
        return '$2y$13$.UPunezIFcxtdVV9FIC8.uoKqdUn0lEuDetcAgfzt858xj5uv4wG.';
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
