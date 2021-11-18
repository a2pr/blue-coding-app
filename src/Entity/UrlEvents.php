<?php

namespace App\Entity;

use App\Repository\UrlEventsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlEventsRepository::class)
 */
class UrlEvents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=UrlEntry::class, inversedBy="urlEvents")
     */
    private $urlEntry;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlEntry(): ?UrlEntry
    {
        return $this->urlEntry;
    }

    public function setUrlEntry(?UrlEntry $urlEntry): self
    {
        $this->urlEntry = $urlEntry;

        return $this;
    }
}
