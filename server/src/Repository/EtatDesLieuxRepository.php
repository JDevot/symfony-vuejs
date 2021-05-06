<?php

namespace App\Repository;
use App\Entity\EtatDesLieux;
use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method EtatDesLieux|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatDesLieux|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatDesLieux[]    findAll()
 * @method EtatDesLieux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatDesLieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, EtatDesLieux::class);
        $this->manager = $manager;
    }

    public function saveEdl($data,$type,$ville){
        $newEdl = new EtatDesLieux();
        
        foreach($data['photos'] as $photo){
            $image = new Image();
            $image->setPath($photo);
            $newEdl->addPhoto($image);
        }
        $newEdl->setTitre($data['titre'])
                ->setType($type)
                ->setVilles($ville)
                ->setSurface($data['surface'])
                ->setNbPieces($data['nbPieces']);
        $this->manager->persist($newEdl);
        $this->manager->flush();
    }
    public function removeEdl(EtatDesLieux $edl){
        $this->manager->remove($edl);
        $this->manager->flush();
    }
    public function updateEdl(EtatDesLieux $edl){
        $this->manager->persist($edl);
        $this->manager->flush();
        return $edl;
    }
    // /**
    //  * @return EtatDesLieux[] Returns an array of EtatDesLieux objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatDesLieux
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
