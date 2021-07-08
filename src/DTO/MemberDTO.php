<?php

namespace App\DTO;

use App\Entity\Member;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * @Assert\GroupSequenceProvider()
 */
class MemberDTO implements GroupSequenceProviderInterface
{

    /**
     * @var string
     * @Assert\NotBlank(message="Name is required.")
     * @Assert\Regex(pattern="/^[a-zA-Z- ]+$/", message="A valid name is required.")
     * @Assert\Length(min = 2, max = 50,
     *    minMessage = "This value must be at least {{ min }} characters long.",  
     *    maxMessage = "This value cannot be longer than {{ max }} characters.",  
     *    allowEmptyString = false
     * )
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Surname is required.")
     * @Assert\Regex(pattern="/^[a-zA-Z- ]+$/", message="A valid surname is required.")
     * @Assert\Length(min = 2, max = 50,
     *    minMessage = "This value must be at least {{ min }} characters long.",  
     *    maxMessage = "This value cannot be longer than {{ max }} characters.",  
     *    allowEmptyString = false
     * )
     */
    public $surname;

    /**
     * @var string
     * @Assert\NotBlank(message="Cellphone number is required.")
     * @Assert\Regex(pattern="/0[0-9]{9}+$/", message="A valid cellphone number is required.")
     * @Assert\Length(min = 10, max = 10,
     *    minMessage = "This value must be at least {{ min }} numbers long.",
     *    maxMessage = "This value cannot be longer than {{ max }} numbers.",  
     * )
     */
    public $cellphone;

    /**
     * @var string
     * @Assert\Email( message="A valid email address is required.") 
     * @Assert\Length(min = 10, max = 50,
     *    minMessage = "This value must be at least {{ min }} numbers long.",
     *    maxMessage = "This value cannot be longer than {{ max }} numbers.",  
     * )
     */
    public $email;
    
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function getGroupSequence()
    {
        return ['MemberDTO', 'Strict', 'Default'];
    }
    
}