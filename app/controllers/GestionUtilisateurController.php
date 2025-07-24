<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/TypeUtilisateur.php";
require_once __DIR__ . "/../models/GroupeUtilisateur.php";
require_once __DIR__ . "/../models/NiveauAccesDonnees.php";
require_once __DIR__ . "/../models/AuditLog.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

class GestionUtilisateurController
{
    private $utilisateur;
    private $baseViewPath;

    private $typeUtilisateur;

    private $groupeUtilisateur;

    private $niveauAcces;
    private $auditLog;



    public function __construct()
    {

        $this->baseViewPath = __DIR__ . '/../../ressources/views/';
        $this->utilisateur = new Utilisateur(Database::getConnection());
        $this->groupeUtilisateur = new GroupeUtilisateur(Database::getConnection());
        $this->typeUtilisateur = new TypeUtilisateur(Database::getConnection());
        $this->niveauAcces = new NiveauAccesDonnees(Database::getConnection());
        $this->auditLog = new AuditLog(Database::getConnection());

    }

    // Afficher la liste des étudiants
    public function index()
    {
        $utilisateur_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';
        $action = $_GET['action'] ?? '';

        try {
            // Récupérer les personnes non enregistrées comme utilisateurs
            $enseignantsNonUtilisateurs = $this->utilisateur->getEnseignantsNonUtilisateurs();
            $personnelNonUtilisateurs = $this->utilisateur->getPersonnelNonUtilisateurs();
            $etudiantsNonUtilisateurs = $this->utilisateur->getEtudiantsMaster2NonUtilisateurs();

            // Gestion des actions GET pour les modales
            if ($action === 'edit' && isset($_GET['id_utilisateur'])) {
                $utilisateur_a_modifier = $this->utilisateur->getUtilisateurById($_GET['id_utilisateur']);
                if (!$utilisateur_a_modifier) {
                    $messageErreur = "Utilisateur non trouvé.";
                }
            } elseif ($action === 'add') {
                // Pour l'ajout, on initialise un objet vide
                $utilisateur_a_modifier = (object)[
                    'id_utilisateur' => '',
                    'nom_utilisateur' => '',
                    'login_utilisateur' => '',
                    'id_type_utilisateur' => '',
                    'statut_utilisateur' => '1',
                    'id_GU' => '',
                    'id_niv_acces_donnee' => ''
                ];
            }

            // Gestion des actions POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Ajout d'un nouvel utilisateur
                if (isset($_POST['btn_add_utilisateur'])) {
                    $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
                    $id_type_utilisateur = $_POST['id_type_utilisateur'] ?? '';
                    $id_GU = $_POST['id_GU'] ?? '';
                    $login_utilisateur = $_POST['login_utilisateur'] ?? '';
                    $statut_utilisateur = $_POST['statut_utilisateur'] ?? '';
                    $id_niveau_acces = $_POST['id_niveau_acces'] ?? '';
                    
                    if (empty($nom_utilisateur) || empty($id_type_utilisateur) || empty($id_GU) || 
                        empty($login_utilisateur) || empty($statut_utilisateur) || empty($id_niveau_acces)) {
                        $messageErreur = "Tous les champs sont obligatoires.";
                    } else {
                        // Vérifier si le login est déjà utilisé
                        if ($this->utilisateur->isLoginUsed($login_utilisateur)) {
                            $messageErreur = "Ce login (email) est déjà utilisé par un autre utilisateur.";
                        } else {
                            $mdp = $this->generateRandomPassword();
                            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

                            if ($this->utilisateur->ajouterUtilisateur(
                                $nom_utilisateur,
                                $id_type_utilisateur,
                                $id_GU,
                                $id_niveau_acces,
                                $statut_utilisateur,
                                $login_utilisateur,
                                $mdp_hash
                            )) {
                                if($this->envoyerEmailInscriptionPHPMailer($login_utilisateur, $nom_utilisateur, $login_utilisateur, $mdp)){
                                    $messageSuccess = "Utilisateur ajouté avec succès et email envoyé.";
                                    $this->auditLog->logCreation($_SESSION['id_utilisateur'], 'utilisateur', 'Succès');
                                }
                            } else {
                                $messageErreur = "Erreur lors de l'ajout de l'utilisateur.";
                                $this->auditLog->logCreation($_SESSION['id_utilisateur'], 'utilisateur', 'Erreur');
                            }
                        }
                    }
                }

                // Traitement de l'ajout en masse
                if (isset($_POST['btn_add_multiple']) && !empty($_POST['selected_persons'])) {
                
                    $utilisateurs = [];
                    $utilisateurModel = new Utilisateur(Database::getConnection());
                    
                    foreach ($_POST['selected_persons'] as $person) {
                        list($type, $id) = explode('_', $person);
                        $login = '';
                        $nom = '';
                        
                        switch ($type) {
                            case 'ens':
                                $enseignant = $utilisateurModel->getEnseignantById($id);
                                if ($enseignant && !$utilisateurModel->isLoginUsed($enseignant->mail_enseignant)) {
                                    $login = $enseignant->mail_enseignant;
                                    $nom = $enseignant->nom_enseignant . ' ' . $enseignant->prenom_enseignant;
                                }
                                break;
                            case 'pers':
                                $personnel = $utilisateurModel->getPersonnelById($id);
                                if ($personnel && !$utilisateurModel->isLoginUsed($personnel->email_pers_admin)) {
                                    $login = $personnel->email_pers_admin;
                                    $nom = $personnel->nom_pers_admin . ' ' . $personnel->prenom_pers_admin;
                                }
                                break;
                            case 'etu':
                                $etudiant = $utilisateurModel->getEtudiantById($id);
                                if ($etudiant && !$utilisateurModel->isLoginUsed($etudiant->email_etu)) {
                                    $login = $etudiant->email_etu;
                                    $nom = $etudiant->nom_etu . ' ' . $etudiant->prenom_etu;
                                }
                                break;
                        }
                        
                        if ($login && $nom) {
                            $utilisateurs[] = [
                                'nom' => $nom,
                                'login' => $login,
                                'id_type' => $_POST['id_type_utilisateur'],
                                'id_groupe' => $_POST['id_GU'],
                                'id_niveau' => $_POST['id_niveau_acces'],
                                'statut' => $_POST['statut_utilisateur']
                            ];
                        }
                    }
                    
                    if (!empty($utilisateurs)) {
                        try {
                            $utilisateursAjoutes = $utilisateurModel->ajouterUtilisateursEnMasse($utilisateurs);
                            
                            // Envoyer les emails aux utilisateurs ajoutés
                            foreach ($utilisateursAjoutes as $utilisateur) {
                                if($this->envoyerEmailInscriptionPHPMailer(
                                    $utilisateur['login'],
                                    $utilisateur['nom'],
                                    $utilisateur['login'],
                                    $utilisateur['mdp']
                                )) {
                                    $messageSuccess= count($utilisateursAjoutes) . " utilisateur(s) ajouté(s) avec succès et emails envoyés.";
                                    $this->auditLog->logCreation($_SESSION['id_utilisateur'], 'utilisateur', 'Succès');
                                } else {
                                    $messageErreur = "Utilisateurs ajoutés mais erreur lors de l'envoi des emails.";
                                    $this->auditLog->logCreation($_SESSION['id_utilisateur'], 'utilisateur', 'Erreur');
                                }
                            }
                        } catch (Exception $e) {
                            $messageErreur = "Erreur lors de l'ajout en masse : " . $e->getMessage();
                            $this->auditLog->logCreation($_SESSION['id_utilisateur'], 'utilisateur', 'Erreur');
                        }
                    } else {
                        $messageErreur= "Aucun utilisateur valide à ajouter";
                    }
                

                }

                // Modification d'un utilisateur
                if (isset($_POST['btn_modifier_utilisateur'])) {
                    $id_utilisateur = $_POST['id_utilisateur'] ?? '';
                    $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
                    $id_type_utilisateur = $_POST['id_type_utilisateur'] ?? '';
                    $id_GU = $_POST['id_GU'] ?? '';
                    $login_utilisateur = $_POST['login_utilisateur'] ?? '';
                    $statut_utilisateur = $_POST['statut_utilisateur'] ?? '';
                    $id_niveau_acces = $_POST['id_niveau_acces'] ?? '';
                   

                    if (empty($id_utilisateur) || empty($nom_utilisateur) || empty($id_type_utilisateur) || 
                        empty($id_GU) || empty($login_utilisateur) || empty($statut_utilisateur) || 
                        empty($id_niveau_acces)) {
                        $messageErreur = "Tous les champs sont obligatoires.";
                    } else {
                        if ($this->utilisateur->updateUtilisateur(
                            $nom_utilisateur,
                            $id_type_utilisateur,
                            $id_GU,
                            $id_niveau_acces,
                            $statut_utilisateur,
                            $login_utilisateur,
                            $id_utilisateur
                        )) {
                            $messageSuccess = "Utilisateur modifié avec succès.";
                            $this->auditLog->logModification($_SESSION['id_utilisateur'], 'utilisateur', 'Succès');
                        } else {
                            $messageErreur = "Erreur lors de la modification de l'utilisateur.";
                            $this->auditLog->logModification($_SESSION['id_utilisateur'], 'utilisateur', 'Erreur');
                        }
                    }
                    
                }

                // Activation ou désactivation d'utilisateurs
                if (isset($_POST['selected_ids'])) {
                    if (isset($_POST['submit_enable_multiple']) && $_POST['submit_enable_multiple']==3) {
                        $success = true;
                        foreach ($_POST['selected_ids'] as $id) {
                            if (!$this->utilisateur->reactiverUtilisateur($id)) {
                                $success = false;
                                break;
                            }
                        }
                        if ($success) {
                            $messageSuccess = "Utilisateurs activés avec succès.";
                            $this->auditLog->logModification($_SESSION['id_utilisateur'], 'utilisateur', 'Succès');
                        } else {
                            $messageErreur = "Erreur lors de l'activation des utilisateurs.";
                            $this->auditLog->logModification($_SESSION['id_utilisateur'], 'utilisateur', 'Erreur');
                        }
                    } elseif (isset($_POST['submit_disable_multiple']) && $_POST['submit_disable_multiple']==2 ) {
                        $success = true;
                        foreach ($_POST['selected_ids'] as $id) {
                            if (!$this->utilisateur->desactiverUtilisateur($id)) {
                                $success = false;
                                break;
                            }
                        }
                        if ($success) {
                            $messageSuccess = "Utilisateurs désactivés avec succès.";
                            $this->auditLog->logModification($_SESSION['id_utilisateur'], 'utilisateur', 'Succès');
                        } else {
                            $messageErreur = "Erreur lors de la désactivation des utilisateurs.";
                            $this->auditLog->logModification($_SESSION['id_utilisateur'], 'utilisateur', 'Erreur');
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $messageErreur = "Erreur : " . $e->getMessage();
        }

        // Préparation des données pour la vue
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
        $GLOBALS['utilisateurs'] = $this->utilisateur->getAllUtilisateurs();
        $GLOBALS['types_utilisateur'] = $this->typeUtilisateur->getAllTypeUtilisateur();
        $GLOBALS['groupes_utilisateur'] = $this->groupeUtilisateur->getAllGroupeUtilisateur();
        $GLOBALS['niveau_acces'] = $this->niveauAcces->getAllNiveauxAccesDonnees();
        $GLOBALS['utilisateur_a_modifier'] = $utilisateur_a_modifier;
        $GLOBALS['action'] = $action;
        $GLOBALS['enseignantsNonUtilisateurs'] = $enseignantsNonUtilisateurs;
        $GLOBALS['personnelNonUtilisateurs'] = $personnelNonUtilisateurs;
        $GLOBALS['etudiantsNonUtilisateurs'] = $etudiantsNonUtilisateurs;
    }


    // Fonction pour générer un mot de passe aléatoire
    function generateRandomPassword($length = 12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    function construireMessageHTML($nom, $login, $motDePasse)
    {
        // Construction du sujet
        $sujet = "Bienvenue sur Univalid, " . htmlspecialchars($nom) . " !";

        // Construction du corps du message HTML
        $message = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Bienvenue</title>
            <style>
                body { 
                    font-family: "Inter", Arial, sans-serif; 
                    line-height: 1.6; 
                    color: #1f2937; 
                    margin: 0; 
                    padding: 0; 
                    background-color: #f8fafc;
                }
                .container { 
                    max-width: 600px; 
                    margin: 0 auto; 
                    background-color: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                }
                .header { 
                    background: linear-gradient(135deg, #24407a 0%, #3457cb 100%);
                    color: white; 
                    padding: 30px 20px; 
                    text-align: center; 
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: 700;
                }
                .logo-section {
                    background-color: #ffffff;
                    padding: 20px;
                    text-align: center;
                    border-bottom: 3px solid #36865a;
                }
                .content { 
                    padding: 30px 20px; 
                    background-color: #ffffff; 
                }
                .footer { 
                    margin-top: 20px; 
                    padding: 20px; 
                    text-align: center; 
                    font-size: 12px; 
                    color: #6b7280; 
                    background-color: #f8fafc;
                    border-top: 1px solid #e5e7eb;
                }
                .button {
                    display: inline-block; 
                    padding: 12px 24px; 
                    background: linear-gradient(135deg, #36865a 0%, #59bf3d 100%);
                    color: white; 
                    text-decoration: none; 
                    border-radius: 8px; 
                    margin: 20px 0;
                    font-weight: 600;
                    transition: all 0.3s ease;
                }
                .button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(54, 134, 90, 0.3);
                }
                .credentials { 
                    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                    padding: 20px; 
                    border-radius: 8px; 
                    margin: 20px 0; 
                    border-left: 4px solid #F6C700;
                }
                .credentials h3 {
                    color: #24407a;
                    margin-top: 0;
                    margin-bottom: 15px;
                    font-size: 18px;
                    font-weight: 600;
                }
                .credential-item {
                    margin-bottom: 10px;
                    padding: 8px 0;
                }
                .credential-label {
                    font-weight: 600;
                    color: #24407a;
                }
                .credential-value {
                    color: #4b5563;
                    font-family: "Courier New", monospace;
                    background-color: #ffffff;
                    padding: 4px 8px;
                    border-radius: 4px;
                    border: 1px solid #d1d5db;
                    display: inline-block;
                    margin-left: 8px;
                }
                .warning-box {
                    background-color: #fef3c7;
                    border: 1px solid #F6C700;
                    border-radius: 6px;
                    padding: 15px;
                    margin: 15px 0;
                }
                .warning-text {
                    color: #92400e;
                    font-size: 14px;
                    margin: 0;
                }
                .platform-name {
                    color: #24407a;
                    font-weight: 700;
                }
                .welcome-text {
                    font-size: 16px;
                    color: #374151;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo-section">
                    <h2 style="color: #24407a; margin: 0; font-size: 28px; font-weight: 800;">
                        <span style="color: #36865a;">Uni</span><span style="color: #24407a;">Valid</span>
                    </h2>
                    <p style="color: #6b7280; margin: 5px 0 0 0; font-size: 14px;">Plateforme de Gestion de Soutenance</p>
                </div>
                
                <div class="header">
                    <h1>🎉 Bienvenue dans votre espace !</h1>
                </div>
                
                <div class="content">
                    <p class="welcome-text">Bonjour <strong style="color: #24407a;">' . htmlspecialchars($nom) . '</strong>,</p>
                    
                    <p class="welcome-text">
                        Félicitations ! Votre compte a été créé avec succès sur la plateforme 
                        <span class="platform-name">UniValid</span>. Vous pouvez maintenant accéder à tous les services 
                        de gestion de soutenance.
                    </p>
                    
                    <div class="credentials">
                        <h3>🔐 Vos identifiants de connexion</h3>
                        <div class="credential-item">
                            <span class="credential-label">📧 Email/Login :</span>
                            <span class="credential-value">' . htmlspecialchars($login) . '</span>
                        </div>';
        
        // Ajout du mot de passe temporaire si fourni
        if ($motDePasse) {
            $message .= '
                        <div class="credential-item">
                            <span class="credential-label">🔑 Mot de passe temporaire :</span>
                            <span class="credential-value">' . htmlspecialchars($motDePasse) . '</span>
                        </div>';
        }
        
        $message .= '
                    </div>';
        
        if ($motDePasse) {
            $message .= '
                    <div class="warning-box">
                        <p class="warning-text">
                            ⚠️ <strong>Important :</strong> Pour votre sécurité, nous vous recommandons fortement 
                            de modifier ce mot de passe temporaire lors de votre première connexion.
                        </p>
                    </div>';
        }
        
        $message .= '
                    <div style="text-align: center; margin: 30px 0;">
                        <p style="margin-bottom: 15px; color: #374151;">Prêt à commencer ? Connectez-vous dès maintenant :</p>
                        <a href="http://localhost:8080/page_connexion.php" class="button" style="color: #ffffff; text-decoration: none;">
                            🚀 Accéder à mon compte
                        </a>
                    </div>
                    
                    <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #3457cb; margin: 20px 0;">
                        <h4 style="color: #24407a; margin-top: 0; margin-bottom: 10px;">📋 Que pouvez-vous faire sur UniValid ?</h4>
                        <ul style="color: #4b5563; margin: 0; padding-left: 20px;">
                            <li>Gérer vos candidatures de soutenance</li>
                            <li>Suivre l\'avancement de vos dossiers</li>
                            <li>Consulter les rapports et évaluations</li>
                            <li>Communiquer avec l\'équipe administrative</li>
                        </ul>
                    </div>
                    
                    <p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
                        Si vous n\'êtes pas à l\'origine de cette création de compte ou si vous rencontrez des difficultés, 
                        n\'hésitez pas à contacter notre équipe support à 
                        <a href="mailto:univalid24@gmail.com" style="color: #36865a; text-decoration: none;">univalid24@gmail.com</a>
                    </p>
                </div>
                
                <div class="footer">
                    <p style="margin: 0 0 10px 0;">
                        © ' . date('Y') . ' <span style="color: #24407a; font-weight: 600;">UniValid</span> - Tous droits réservés
                    </p>
                    <p style="margin: 0; font-size: 11px;">
                        Plateforme de Gestion de Soutenance | Université Félix Houphouët-Boigny
                    </p>
                </div>
            </div>
        </body>
        </html>';

        return $message;
    }


    function envoyerEmailInscriptionPHPMailer($email, $nom, $login, $motDePasse)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->SMTPDebug = 2; // Active le débogage détaillé
            $mail->Debugoutput = function($str, $level) {
                error_log("PHPMailer Debug: $str");
            };
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'univalid25@gmail.com';
            $mail->Password = 'yuwgnzuqtmbwyrbv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Destinataires
            $mail->setFrom('univalid25@gmail.com', 'Univalid'); // Utiliser une adresse email valide
            $mail->addAddress($email, $nom);
            $mail->addReplyTo('univalid25@gmail.com', 'Support technique');

            // Contenu
            $mail->isHTML(true);
            $mail->Subject = "Bienvenue sur notre plateforme, $nom !";

            // Construction du message HTML
            $message = $this->construireMessageHTML($nom, $login, $motDePasse);
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);

            error_log("Tentative d'envoi d'email à : " . $email);
            $result = $mail->send();
            error_log("Email envoyé avec succès à : " . $email);
            return true;
        } catch (Exception $e) {
            error_log("Erreur PHPMailer détaillée: " . $e->getMessage());
            error_log("Erreur PHPMailer: {$mail->ErrorInfo}");
            return false;
        }
    }

   

}