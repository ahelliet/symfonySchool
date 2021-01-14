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
     * @Route("/eleve", name="eleve")
     */
    public function index(EleveRepository $repo): Response
    {
        $eleves = $repo->findAll();
        return $this->render('eleve/index.html.twig', [
            'title' => 'Tous les élèves',
            'eleves' => $eleves
        ]);
    }

    /**
     * @Route("/eleve/new", name="newEleve")
     * @Route("/eleve/{id}/edit", name="editEleve")
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
            return $this->redirectToRoute('eleve');
        }

        return $this->render('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/eleve/{id}", name="showEleve")
     */
    public function showEleve(EleveRepository $repo, int $id): Response
    {
        $eleve = $repo->find($id);
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * @Route("/eleve/{id}/delete", name="deleteEleve")
     */
    public function deleteEleve(EleveRepository $repo, EntityManagerInterface $manager, int $id): Response
    {
        $eleve = $repo->find($id);
        $manager->remove($eleve);
        $manager->flush();
        return $this->redirectToRoute('eleve');
    }
}
