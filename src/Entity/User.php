<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    const ROLE_DEFAULT = 'ROLE_USER';

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
    private $roles = [];

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
     * @var bool
     */
    private $enabled;

    /**
     * User constructor.
     */
    public function __construct()
    {
        if(!$this->roles) {
            $this->roles[] = self::ROLE_DEFAULT;
        }
    }

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
    public function getEmail() : ?string
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
     * @param null|string $role
     *
     * @return User
     */
    public function addRole(?string $role = null) : self
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoles() : ?array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
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
    public function getUsername() : ?string
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

    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled(bool $enabled) : self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
