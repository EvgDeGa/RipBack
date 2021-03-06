<?php

namespace App\Entity;

use App\Repository\ToDoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ToDoRepository::class)
 */
class ToDo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("main")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("main")
     */
    private $text;

    /**
     * @ORM\Column(type="boolean")
     * @Groups ("main")
     */
    private $checked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }
}
