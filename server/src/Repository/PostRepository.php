<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Post::class);
        $this->manager = $manager;
    }
        /**
     * Recherche les annonces en fonction du formulaire
     * @return void 
     */
    public function search($mots = null, $categorie = null){
        $query = $this->createQueryBuilder('p');
        if($mots != null){
            $query->Where('MATCH_AGAINST(p.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }
        if($categorie != null){
            $query->join('p.categorie', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
        }
        $query->join('p.user', 'u')
                ->addSelect('u')
                ->addSelect('c');
        return $query->getQuery()->getArrayResult();
    }
    public function savePost($title, $body, $user, $categorie,$resume){
        $newPost = new Post();
        $newPost->setTitle($title)
                ->setBody($body)
                ->setUser($user)
                ->setResume($resume)
                ->setCategorie($categorie);
        $this->manager->persist($newPost);
        $this->manager->flush();
    }

    public function removePost(Post $post){
        $this->manager->remove($post);
        $this->manager->flush();
    }
    
    public function updatePost(Post $post): Post {
        $this->manager->persist($post);
        $this->manager->flush();
        return $post;
    }
    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
