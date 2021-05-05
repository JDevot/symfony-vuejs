<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VillesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
class VillesController
{ 
    public function __construct(){
    }
    /**
     * @Route("/api/villes", name="get_all_villes", methods={"GET"})   
     */
    public function getAll(VillesRepository $villesRepository): JsonResponse {
        $villes = $villesRepository->findAll();
        $data = [];
        foreach ($villes as $ville){
            $data[] = [
            'id' => $ville->getId(),
            'nomVille' => $ville->getNomVille(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/villes/{id}", name="update_villes", methods={"PUT"})
     */
    public function update($id, Request $request,VillesRepository $villesRepository): JsonResponse {
        $villes = $villesRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
     
        empty($data['nomVille']) ? true : $villes->setNomVille($data['nomVille']);
        $updatedVilles = $villesRepository->updateVille($villes);
        return new JsonResponse($updatedVilles->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/villes/{id}", name="delete_villes", methods={"DELETE"})
     */
    public function delete($id,VillesRepository $villesRepository): JsonResponse{
        $villes = $villesRepository->findOneBy(['id' => $id]);
        $villesRepository->removeVille($villes);
        return new JsonResponse(['status' => 'ville deleted'], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("/api/villes/{id}", name="get_one_villes", methods={"GET"})   
     */
    public function get($id,VillesRepository $villesRepository): JsonResponse {
        try {
            $villes = $villesRepository->findOneBy(['id' => $id]);
            $data = [
                'id' => $villes->getId(),
                'nomVille' => $villes->getNomVille(),
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/villes", name="post_villes", methods={"POST"})
     */
    public function add(Request $request,VillesRepository $villesRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['nomVille'])){
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }
        $villesRepository->saveVille($data);
        return new JsonResponse(['status' => 'Ville Created'], Response::HTTP_CREATED);
    }
}
