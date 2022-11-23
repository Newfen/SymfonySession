<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle_categorie;

    /**
     * @ORM\OneToMany(targetEntity=ModuleFormation::class, mappedBy="id_categorie", orphanRemoval=true)
     */
    private $moduleFormations;

    public function __construct()
    {
        $this->moduleFormations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelle_categorie;
    }

    public function setLibelleCategorie(string $libelle_categorie): self
    {
        $this->libelle_categorie = $libelle_categorie;

        return $this;
    }

    /**
     * @return Collection<int, ModuleFormation>
     */
    public function getModuleFormations(): Collection
    {
        return $this->moduleFormations;
    }

    public function addModuleFormation(ModuleFormation $moduleFormation): self
    {
        if (!$this->moduleFormations->contains($moduleFormation)) {
            $this->moduleFormations[] = $moduleFormation;
            $moduleFormation->setIdCategorie($this);
        }

        return $this;
    }

    public function removeModuleFormation(ModuleFormation $moduleFormation): self
    {
        if ($this->moduleFormations->removeElement($moduleFormation)) {
            // set the owning side to null (unless already changed)
            if ($moduleFormation->getIdCategorie() === $this) {
                $moduleFormation->setIdCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->libelle_categorie;
    }
}
