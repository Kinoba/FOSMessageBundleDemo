<?php
// src/Entity/MessageMetadata.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\MessageMetadata as BaseMessageMetadata;

#[ORM\Entity]
#[ORM\Table(name: 'messages_metadata')]
class MessageMetadata extends BaseMessageMetadata
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var \FOS\MessageBundle\Model\MessageInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Message', inversedBy: 'metadata')]
    protected $message;

    /**
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\User')]
    protected $participant;
}
