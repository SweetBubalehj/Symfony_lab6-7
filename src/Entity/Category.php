<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Gadget::class)]
    private Collection $gadgets;

    public function __construct()
    {
        $this->gadgets = new ArrayCollection();
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

    /**
     * @return Collection<int, Gadget>
     */
    public function getGadgets(): Collection
    {
        return $this->gadgets;
    }

    public function addGadget(Gadget $gadget): self
    {
        if (!$this->gadgets->contains($gadget)) {
            $this->gadgets->add($gadget);
            $gadget->setCategory($this);
        }

        return $this;
    }

    public function removeGadget(Gadget $gadget): self
    {
        if ($this->gadgets->removeElement($gadget)) {
            // set the owning side to null (unless already changed)
            if ($gadget->getCategory() === $this) {
                $gadget->setCategory(null);
            }
        }

        return $this;
    }
}
