<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user",inversedBy="comment")
     * @ORM\JoinColumn
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\post",mappedBy="comment")
     * @ORM\JoinColumn
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
    public function getUser(){
        return $this->user;
    }
    public function setUser($user): self
    {
        $this->user=$user;
        return $this;
    }
    public function getPost(){
        return $this->user;
    }
    public function setPost($post): self
    {
        $this->post=$post;
        return $this;
    }
}
