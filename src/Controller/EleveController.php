<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EleveController extends AbstractController
{
    /**
     * @Route("/eleves", name="eleve")
     */
    public function index(EleveRepository $repo): Response
    {
        return $this->render('eleve/index.html.twig', [
            'eleves' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/eleves/new", name="newEleve")
     * @Route("/eleves/{id}/edit", name="editEleve")
     */
    public function newEleve(Request $request, EntityManagerInterface $manager, Eleve $eleve = null): Response
    {

        if (!$eleve) {
            $eleve = new Eleve();
        }

        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($eleve);
            $manager->flush();
            return $this->redirectToRoute('showEleve', ['id' => $eleve->getId()]);
        }

        return $this->render('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/eleves/{id}", name="showEleve")
     */
    public function showEleve(EleveRepository $repo, int $id): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $repo->find($id),
        ]);
    }

    /**
     * @Route("/eleves/{id}/delete", name="deleteEleve")
     */
    public function deleteEleve(EleveRepository $repo, EntityManagerInterface $manager, int $id): Response
    {
        $eleve = $repo->find($id);
        $manager->remove($eleve);
        $manager->flush();
        return $this->redirectToRoute('eleve');
    }
}
