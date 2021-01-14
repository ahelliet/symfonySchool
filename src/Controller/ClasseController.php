<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    /**
     * @Route("/classe", name="classe")
     */
    public function index(ClasseRepository $repo): Response
    {
        $classes = $repo->findAll();
        return $this->render('classe/index.html.twig', [
            'classes' => $classes,
        ]);
    }

    /**
     * @Route("/classe/new", name="newClasse")
     * @Route("/classe/{id}/edit", name="editClasse")
     */
    public function newClasse(Request $request, EntityManagerInterface $manager, Classe $classe = null): Response
    {
        if (!$classe) {
            $classe = new Classe();
        }

        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($classe);
            $manager->flush();
            return $this->redirectToRoute('classe');
        }

        return $this->render('classe/new.html.twig', [
            'classe' => $classe,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/classe/{id}", name="showClasse")
     */
    public function showClasse(ClasseRepository $repoClasse, EleveRepository $repoEleve, int $id): Response
    {
        $classe = $repoClasse->find($id);
        $eleves = $repoEleve->findBy([
            'classe' => $id
        ]);
        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'eleves' => $eleves
        ]);
    }

    /**
     * @Route("/classe/{id}/delete", name="deleteClasse")
     */
    public function deleteClasse(ClasseRepository $repo, EntityManagerInterface $manager, int $id): Response
    {
        $classe = $repo->find($id);
        $manager->remove($classe);
        $manager->flush();
        return $this->redirectToRoute('classe');
    }
}
