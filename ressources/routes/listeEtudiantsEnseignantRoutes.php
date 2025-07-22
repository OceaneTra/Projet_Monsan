<?php

require_once __DIR__ . '/../../app/controllers/ListeEtudiantsEnseignantController.php';

// Routes pour la liste des étudiants encadrés par un enseignant
if (isset($_GET['page']) && $_GET['page'] === 'liste_etudiants_ens_simple') {
    
    $controller = new ListeEtudiantsEnseignantController();
    $controller->index();
} 