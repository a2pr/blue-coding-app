<?php

namespace App\Entity;

use App\Repository\UrlEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlEntryRepository::class)
 */
class UrlEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originalUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortUrl;

    /**
     * @ORM\OneToMany(targetEntity=UrlEvents::class, mappedBy="urlEntry")
     */
    private $urlEvents;

    public function __construct()
    {
        $this->urlEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(string $shortUrl): self
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    /**
     * @return Collection|UrlEvents[]
     */
    public function getUrlEvents(): Collection
    {
        return $this->urlEvents;
    }

    public function addUrlEvent(UrlEvents $urlEvent): self
    {
        if (!$this->urlEvents->contains($urlEvent)) {
            $this->urlEvents[] = $urlEvent;
            $urlEvent->setUrlEntry($this);
        }

        return $this;
    }

    public function removeUrlEvent(UrlEvents $urlEvent): self
    {
        if ($this->urlEvents->removeElement($urlEvent)) {
            // set the owning side to null (unless already changed)
            if ($urlEvent->getUrlEntry() === $this) {
                $urlEvent->setUrlEntry(null);
            }
        }

        return $this;
    }
}
