<?php

namespace App\Controller;



use App\Repository\TypesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
class TypesController{
    public function __construct(){
    }
    /**
     * @Route("/api/types", name="get_all_types", methods={"GET"})   
     */
    public function getAll(TypesRepository $typesRepository): JsonResponse {
        $types = $typesRepository->findAll();
        $data = [];
        foreach ($types as $type){
            $data[] = [
            'id' => $type->getId(),
            'libelle' => $type->getLibelle(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/types/{id}", name="update_types", methods={"PUT"})
     */
    public function update($id, Request $request,TypesRepository $typesRepository): JsonResponse {
        $types = $typesRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
     
        empty($data['libelle']) ? true : $types->setLibelle($data['libelle']);
        $updatedTypes= $typesRepository->updateType($types);
        return new JsonResponse($updatedTypes->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/types/{id}", name="delete_types", methods={"DELETE"})
     */
    public function delete($id,TypesRepository $typesRepository): JsonResponse{
        $types = $typesRepository->findOneBy(['id' => $id]);
        $typesRepository->removeType($types);
        return new JsonResponse(['status' => 'type deleted'], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("/api/types/{id}", name="get_one_types", methods={"GET"})   
     */
    public function get($id,TypesRepository $typesRepository): JsonResponse {
        try {
            $types = $typesRepository->findOneBy(['id' => $id]);
            $data = [
                'id' => $types->getId(),
                'libelle' => $types->getLibelle(),
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/types", name="post_types", methods={"POST"})
     */
    public function add(Request $request,TypesRepository $typesRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['libelle']) ){
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }
        $typesRepository->saveType($data['libelle']);
        return new JsonResponse(['status' => 'Type Created'], Response::HTTP_CREATED);
    }
}
