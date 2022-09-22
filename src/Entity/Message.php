<?php
// src/Entity/Message.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Entity\Message as BaseMessage;

#[ORM\Entity]
#[ORM\Table(name: 'messages')]
class Message extends BaseMessage
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var \FOS\MessageBundle\Model\ThreadInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Thread', inversedBy: 'messages')]
    protected $thread;

    /**
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\User')]
    protected $sender;

    /**
     * @var MessageMetadata[]|Collection
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\MessageMetadata', mappedBy: 'message', cascade: ['all'])]
    protected $metadata;
}
