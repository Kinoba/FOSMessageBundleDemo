<?php

namespace App\Form\DataTransformer;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Transforms between a User instance and a username string
 */
class UserToUsernameTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * UserToUsernameTransformer constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms a UserInterface instance into a username string.
     *
     * @param UserInterface|null $value UserInterface instance
     *
     * @return string|null Username
     *
     * @throws UnexpectedTypeException if the given value is not a UserInterface instance
     */
    public function transform($value): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof UserInterface) {
            throw new UnexpectedTypeException($value, 'Symfony\Component\Security\Core\User\UserInterface');
        }

        return $value->getUserIdentifier();
    }

    /**
     * Transforms a username string into a UserInterface instance.
     *
     * @param string $value Username
     *
     * @return UserInterface|null the corresponding UserInterface instance
     *
     * @throws UnexpectedTypeException if the given value is not a string
     */
    public function reverseTransform($value): ?UserInterface
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        return $this->em->getRepository(User::class)->findOneByIdentifier($value);
    }
}
