<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\EtatDesLieuxRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class EtatDesLieuxController
{
    public function __construct(){
    }
    /**
     * @Route("/api/edl", name="get_all_edl", methods={"GET"})   
     */
    public function getAll(EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse {
        $edls = $etatDesLieuxRepository->findAll();
        $data = [];
        foreach ($edls as $edl){
            $data[] = [
            'id' => $edl->getId(),
            'titre' => $edl->getTitre(),
            'type' => $edl->getType(),
            'villes' => $edl->getVilles(),
            'nbPieces' => $edl->getNbPieces(),
            'surface' => $edl->getSurface(),
            'photo' => $edl->getPhoto()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/edl/{id}", name="update_edl", methods={"PUT"})
     */
    public function update($id, Request $request,EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse {
        $edl = $etatDesLieuxRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
     
        empty($data['titre']) ? true : $edl->setTitre($data['titre']);
        empty($data['type']) ? true : $edl->setType($data['type']);
        empty($data['villes']) ? true : $edl->setType($data['villes']);
        empty($data['nbPieces']) ? true : $edl->setType($data['nbPieces']);
        empty($data['surface']) ? true : $edl->setType($data['surface']);
        empty($data['photo']) ? true : $edl->setType($data['photo']);
        $updatedEdl = $etatDesLieuxRepository->updatePost($edl);
        return new JsonResponse($updatedEdl->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/edl/{id}", name="delete_edl", methods={"DELETE"})
     */
    public function delete($id,EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse{
        $edl = $etatDesLieuxRepository->findOneBy(['id' => $id]);
        $etatDesLieuxRepository->removePost($edl);
        return new JsonResponse(['status' => 'edl deleted'], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("/api/edl/{id}", name="get_one_edl", methods={"GET"})   
     */
    public function get($id,EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse {
        try {
            $edl = $etatDesLieuxRepository->findOneBy(['id' => $id]);
            $data = [
                'id' => $edl->getId(),
                'titre' => $edl->getTitre(),
                'type' => $edl->getType(),
                'villes' => $edl->getVilles(),
                'nbPieces' => $edl->getNbPieces(),
                'surface' => $edl->getSurface(),
                'photo' => $edl->getPhoto()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/edl", name="post_edl", methods={"POST"})
     */
    public function add(Request $request,EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['titre']) || empty($data['type']) || empty($data['villes']) || 
        empty($data['villes']) ||  empty($data['nbPieces']) ||  empty($data['surface']) 
        ||   empty($data['photo'])){
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }
        $etatDesLieuxRepository->saveEdl($data);
        return new JsonResponse(['status' => 'Etats des lieux Created'], Response::HTTP_CREATED);
    }
}
