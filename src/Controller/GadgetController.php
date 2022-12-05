<?php

namespace App\Controller;

use App\Repository\GadgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class GadgetController extends AbstractController
{
    #[Route('/gadget/{id}', name: 'app_gadget')]
    public function index(int $id, GadgetRepository $gadgetRepository): Response
    {
        $gadget = $gadgetRepository->find($id);
        if (!$gadget) {
            throw new NotFoundHttpException("Gadget {$id} not found");
        }

        return $this->render('gadget/index.html.twig', [
            'gadget' => $gadget,
        ]);
    }

    #[Route('/gadget', name: 'app_gadget_list')]
    public function showAll(GadgetRepository $gadgetRepository): Response
    {
        $gadgets = $gadgetRepository->findAll();

        return $this->render('gadget/list.html.twig', [
            'gadgets' => $gadgets,
        ]);
    }

    #[Route('/gadget/delete/{id}', name: 'app_gadget_remove')]
    public function deleteGadget(int $id, GadgetRepository $gadgetRepository): Response
    {
        $gadget = $gadgetRepository->find($id);
        if (!$gadget) {
            throw new NotFoundHttpException("Gadget with id {$id} not found");
        }

        $gadgetRepository->remove($gadget, true);

        return $this->redirectToRoute('app_gadget_list');
    }
}
