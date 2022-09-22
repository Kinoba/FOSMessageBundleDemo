<?php
// src/Entity/Thread.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Entity\Thread as BaseThread;

#[ORM\Entity]
#[ORM\Table(name: 'threads')]
class Thread extends BaseThread
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\User')]
    protected $createdBy;

    /**
     * @var Message[]|Collection
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\Message', mappedBy: 'thread')]
    protected $messages;

    /**
     * @var ThreadMetadata[]|Collection
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\ThreadMetadata', mappedBy: 'thread', cascade: ['all'])]
    protected $metadata;
}
