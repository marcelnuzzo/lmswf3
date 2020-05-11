<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $proposition;

    /**
     * @ORM\Column(type="boolean")
     */
    private $correction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questions;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuestions(): ?Question
    {
        return $this->questions;
    }

    public function setQuestions(?Question $questions): self
    {
        $this->questions = $questions;

        return $this;
    }
}
