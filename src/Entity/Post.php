<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    private $comments;
    private $username;
    private $imageshown;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageshown(): ?string
    {
        return $this->imageshown;
    }
    public function setImageshown(string $imageshown): self
    {
        $this->imageshown = $imageshown;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setLikes(Int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }
    public function getLikes(): ?string
    {
        return $this->likes;
    }
    
    public function getUserid(){
        return $this->user_id;
    }
    public function setUserid(Int $user_id): self
    {
        $this->user_id=$user_id;
        return $this;
    }
    public function getComments(){
        return $this->comments;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setUsername(String $user): self
    {
        $this->username=$user;
        return $this;
    }
}
