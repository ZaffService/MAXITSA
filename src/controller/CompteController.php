<?php
/**
 * Contrôleur des comptes
 */
class CompteController extends AbstractController
{
    /**
     * Liste des comptes
     */
    public function index(): void
    {
        $this->render('comptes/index');
    }

    /**
     * Formulaire de création de compte
     */
    public function create(): void
    {
        $this->render('comptes/create');
    }

    /**
     * Sauvegarde d'un nouveau compte
     */
    public function store(): void
    {
        // À implémenter plus tard
        $this->redirect(url('comptes'));
    }
}
