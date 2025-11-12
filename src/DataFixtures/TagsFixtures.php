<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tags = [
            'Premium',
            'Vol direct',
            'Éco-responsable',
            'Dernières places',
        ];

        foreach ($tags as $tg) {
            $tag = new Tags();
            $tag->setName($tg);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
