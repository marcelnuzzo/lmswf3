<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestquizRepository")
 */
class Testquiz
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="integer")
     */
    private $proposition;

    /**
     * @ORM\Column(type="boolean")
     */
    private $correction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getProposition(): ?int
    {
        return $this->proposition;
    }

    public function setProposition(int $proposition): self
    {
        $this->proposition = $proposition;

        return $this;
    }

    public function getCorrection(): ?bool
    {
        return $this->correction;
    }

    public function setCorrection(bool $correction): self
    {
        $this->correction = $correction;

        return $this;
    }
}
