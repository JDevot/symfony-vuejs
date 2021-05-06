<?php

namespace App\Controller;



use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
class CategorieController{
    public function __construct(){
    }
    /**
     * @Route("/api/categories", name="get_all_categories", methods={"GET"})   
     */
    public function getAll(CategorieRepository $categoriesRepository): JsonResponse {
        $categories = $categoriesRepository->findAll();
        $data = [];
        foreach ($categories as $categorie){
            $data[] = [
            'id' => $categorie->getId(),
            'label' => $categorie->getLabel(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/categories/{id}", name="update_categories", methods={"PUT"})
     */
    public function update($id, Request $request,CategorieRepository $categoriesRepository): JsonResponse {
        $categories = $categoriesRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
     
        empty($data['libelle']) ? true : $categories->setLabel($data['label']);
        $updatedCategorie = $categoriesRepository->updateCategorie($categories);
        return new JsonResponse($updatedCategorie->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/categories/{id}", name="delete_categories", methods={"DELETE"})
     */
    public function delete($id,CategorieRepository $categoriesRepository): JsonResponse{
        $categories = $categoriesRepository->findOneBy(['id' => $id]);
        $categoriesRepository->removeCategorie($categories);
        return new JsonResponse(['status' => 'categorie deleted'], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("/api/categories/{id}", name="get_one_categories", methods={"GET"})   
     */
    public function getCategories($id,CategorieRepository $categoriesRepository): JsonResponse {
        try {
            $categories = $categoriesRepository->findOneBy(['id' => $id]);
            $data = [
                'id' => $categories->getId(),
                'label' => $categories->getlabel(),
                'post' => $categories->getPosts()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/categories", name="post_categories", methods={"POST"})
     */
    public function add(Request $request,CategorieRepository $categoriesRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['label']) ){
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }
        $categoriesRepository->saveCategorie($data['label']);
        return new JsonResponse(['status' => 'Categorie Created'], Response::HTTP_CREATED);
    }
}
