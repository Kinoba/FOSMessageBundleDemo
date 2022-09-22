<?php
// src/Entity/ThreadMetadata.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\ThreadMetadata as BaseThreadMetadata;

#[ORM\Entity]
#[ORM\Table(name: 'threads_metadata')]
class ThreadMetadata extends BaseThreadMetadata
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var \FOS\MessageBundle\Model\ThreadInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Thread', inversedBy: 'metadata')]
    protected $thread;

    /**
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\User')]
    protected $participant;
}
