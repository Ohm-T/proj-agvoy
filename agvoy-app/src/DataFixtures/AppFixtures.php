<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Owner;
use App\Entity\Room;
use App\Entity\Region;


class AppFixtures extends Fixture
{
    // définit un nom de référence pour une instance de Region
    public const IDF_REGION_REFERENCE = 'idf-region';
    public const ARA_REGION_REFERENCE = 'ara-region';
    public const AQU_REGION_REFERENCE = 'aqu-region';


    /*
    public function load(ObjectManager $manager)
    {
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);
        $manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);
    


        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Auvergne Rhone-Alpes");
        $region->setPresentation("La région française la plus belle");
        $manager->persist($region);
        $manager->flush();
        $this->addReference(self::ARA_REGION_REFERENCE, $region);

    
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Aquitaine");
        $region->setPresentation("La région française du surf");
        $manager->persist($region);
        $manager->flush();
        $this->addReference(self::AQU_REGION_REFERENCE, $region);


        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));     
        $manager->persist($room);
    
        $manager->flush();
    }
    */

    private static function regionGenerator()
    {
        yield ["FR", "Auvergne Rhone-Alpes", "La région française capitale", ARA_REGION_REFERENCE];
        yield ["FR", "Ile de France", "La région française la plus belle", IDF_REGION_REFERENCE];
        yield ["FR", "Aquitaine", "La région française du surf", AQU_REGION_REFERENCE];

    }

    private static function roomGenerator()
    {
        yield ["Patrick", ARA_REGION_REFERENCE, "très joli espace sur paille", "Beau poulailler ancien à Évry"];
        yield ["Joel", IDF_REGION_REFERENCE,"très moche espace sur paille", "Vieux poulailler ancien à Évry"];
        yield ["Fred", AQU_REGION_REFERENCE,"Espace en montagne", "Ferme ancienne de Savoie"];

     }

     public function load(ObjectManager $manager)
    {
    $regionRepo = $manager->getRepository(Region::class);

    foreach (self::regionGenerator() as [$country, $name, $presentation, $ref] ) {
        $region = new Region();
        $region->setCountry($country);
        $region->setName($name);
        $region->setPresentation($presentation);
        $manager->persist($region); 
        $this->addReference(self::$ref, $region);          
    }
    $manager->flush();

    foreach (self::roomGenerator() as [$name, $ref, $summary, $description] ) {
        $room = new Room();
        $room->setSummary($summary);
        $room->setRoom($name);
        $room->setDescription($description);
        $room->addRegion($this->getReference(self::$ref));     
        $manager->persist($room);        
    }
    $manager->flush();

    
    }
}
