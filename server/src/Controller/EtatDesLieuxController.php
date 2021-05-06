<?php

namespace App\Controller;

use App\Entity\EtatDesLieux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\EtatDesLieuxRepository;
use App\Repository\TypesRepository;
use App\Repository\VillesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use App\Service\FileUploader;

class EtatDesLieuxController extends AbstractController
{

    public function __construct()
    {
    }
    /**
     * @Route("/api/edl", name="get_all_edl", methods={"GET"})   
     */
    public function getAll(EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        try {
            $edls = $etatDesLieuxRepository->findAll();
            $data = [];
            foreach ($edls as $edl) {
                $data[] = [
                    'id' => $edl->getId(),
                    'titre' => $edl->getTitre(),
                    'type' => $edl->getType()->getLibelle(),
                    'villes' =>  $edl->getVilles()->getNomVille(),
                    'nbPieces' => $edl->getNbPieces(),
                    'surface' => $edl->getSurface(),
                    'photo' => $edl->getPhoto(),
                ];
            }
            return new JsonResponse($data, Response::HTTP_OK);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/api/edl/{id}", name="update_edl", methods={"PUT"})
     */
    public function update($id, Request $request, EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        try {
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
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/edl/type/{id}", name="search_type", methods={"GET"})
     */
    public function searchType($id, EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        $edl = $etatDesLieuxRepository->findBy(['type' => $id]);
        return $this->json($edl);
    }
    /**
     * @Route("/api/edl/ville/{id}", name="search_ville", methods={"GET"})
     */
    public function searchVille($id, EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        $edl = $etatDesLieuxRepository->findBy(['villes' => $id]);
        return $this->json($edl);
    }
    /**
     * @Route("/api/edl/{id}", name="delete_edl", methods={"DELETE"})
     */
    public function delete($id, EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        $edl = $etatDesLieuxRepository->findOneBy(['id' => $id]);
        $etatDesLieuxRepository->removePost($edl);
        return new JsonResponse(['status' => 'edl deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/edl/{id}", name="get_one_edl", methods={"GET"})   
     */
    public function show($id, EtatDesLieuxRepository $etatDesLieuxRepository): JsonResponse
    {
        try {
            $edl = $etatDesLieuxRepository->findOneBy(['id' => $id]);
            $data = [
                'id' => $edl->getId(),
                'titre' => $edl->getTitre(),
                'type' => $edl->getType()->getLibelle(),
                'villes' =>   $edl->getVilles()->getNomVille(),
                'nbPieces' => $edl->getNbPieces(),
                'surface' => $edl->getSurface(),
                'photo' => $edl->getPhoto()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/edl", name="post_edl", methods={"POST"})
     */
    public function add(Request $request, EtatDesLieuxRepository $etatDesLieuxRepository, TypesRepository $typesRepository, VillesRepository $villeRepository, FileUploader $file_uploader): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        if (empty($data['titre']) || empty($data['type'] || empty($data['nomVille'] || empty($data['surface'] || empty($data['nbPieces'] || empty($data['photo'])))))) {
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }
        $type = $typesRepository->findOneBy(['libelle' => $data['type']]);
        $ville = $villeRepository->findOneBy(['nomVille' => $data['nomVille']]);
        $data['photos'] = [];
        foreach ($data['photo'] as $photo) {
            $photoEnd = $file_uploader->uploadBase64($photo);
            array_push($data['photos'], $photoEnd);
        }
        $etatDesLieuxRepository->saveEdl($data, $type, $ville);
        return new JsonResponse(['status' => 'created'], Response::HTTP_CREATED);
    }
}
