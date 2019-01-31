<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param null|string $password
     *
     * @return $this
     */
    public function setPassword(?string $password = null) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * @param array|null $roles
     *
     * @return User
     */
    public function setRoles(?array $roles = null) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoles() : ?array
    {
        return $this->roles;
    }

    /**
     * @param null|string $salt
     *
     * @return User
     */
    public function setSalt(?string $salt = null) : self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt() : ?string
    {
        return $this->salt;
    }

    /**
     * @param null|string $username
     *
     * @return User
     */
    public function setUsername(?string $username = null) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @return $this
     */
    public function eraseCredentials() : self
    {
        //$this->setPassword();

        return $this;
    }
}
