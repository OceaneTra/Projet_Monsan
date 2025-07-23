<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
$stage_info = isset($GLOBALS['stage_info']) ? $GLOBALS['stage_info'] : [];
$compte_rendu = isset($GLOBALS['compte_rendu']) ? $GLOBALS['compte_rendu'] : [];
$has_candidature = isset($GLOBALS['has_candidature']) ? $GLOBALS['has_candidature'] : false;
$candidature = isset($GLOBALS['candidature']) ? $GLOBALS['candidature'] : null;
$candidatures_etudiant = isset($GLOBALS['candidatures_etudiant']) ? $GLOBALS['candidatures_etudiant'] : [];

// Vérifier s'il existe au moins une candidature en attente ou validée
$disableCandidature = empty($stage_info);
$candidatureStatus = null; // Pour stocker le statut de la candidature bloquante

foreach ($candidatures_etudiant as $cand) {
    if (in_array($cand['statut_candidature'], ['En attente', 'Validée'])) {
        $disableCandidature = true;
        $candidatureStatus = $cand['statut_candidature'];
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidature à la Soutenance | Univalid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#24407a',
                        'primary-light': '#3457cb',
                        'secondary': '#36865a',
                        'secondary-light': '#59bf3d',
                        'accent': '#F6C700',
                        'warning': '#f59e0b',
                        'danger': '#ef4444',
                    },
                    animation: {
                        'fade-in-down': 'fadeInDown 0.8s ease-out forwards',
                        'slide-in-right': 'slideInRight 0.8s ease-out forwards',
                        'scale-in': 'scaleIn 0.5s ease-out forwards',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3457cb 0%, #36865a 50%, #59bf3d 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(15, 23, 42, 0.12);
        }

        .step-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .step-card.completed::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #22c55e 0%, #16a34a 100%);
        }

        .step-card.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3457cb 0%, #24407a 100%);
        }

        .step-number {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .step-number.completed {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .step-number.active {
            background: linear-gradient(135deg, #3457cb 0%, #24407a 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(52, 87, 203, 0.3);
        }

        .step-number.disabled {
            background: #f1f5f9;
            color: #94a3b8;
            border: 2px solid #e2e8f0;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3457cb 0%, #24407a 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(52, 87, 203, 0.3);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(52, 87, 203, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #36865a 0%, #59bf3d 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(54, 134, 90, 0.3);
        }

        .btn-secondary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(54, 134, 90, 0.4);
        }

        .btn-disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border: 2px solid #e2e8f0;
        }

        .btn-gray {
            background: #f1f5f9;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-gray:hover {
            background: white;
            border-color: rgba(52, 87, 203, 0.2);
            transform: translateY(-2px);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: #3457cb;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 87, 203, 0.1);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            z-index: 999;
            justify-content: center;
            align-items: center;
            animation: fadeInDown 0.3s ease-out forwards;
        }

        .modal-container {
            background: white;
            backdrop-filter: blur(20px);
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 95%;
            max-width: 800px;
            animation: scaleIn 0.5s ease-out forwards;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3457cb 0%, #36865a 50%, #59bf3d 100%);
            border-radius: 24px 24px 0 0;
        }

        .notification {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            border: 1px solid;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.1);
        }

        .notification.success {
            background: linear-gradient(135deg, rgba(54, 134, 90, 0.1) 0%, rgba(89, 191, 61, 0.1) 100%);
            border-color: rgba(54, 134, 90, 0.2);
            color: #36865a;
        }

        .notification.error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .notification.warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
            border-color: rgba(245, 158, 11, 0.2);
            color: #d97706;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-en-attente {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .status-validee {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #10b981;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Notification Area -->
    <div id="notification-area" class="fixed top-6 right-6 z-50 w-full max-w-sm space-y-3">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="notification success animate-fade-in-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="font-semibold"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
        <div class="notification error animate-fade-in-down">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                <span class="font-semibold"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
        </div>
        <?php endif; ?>
        
        <div id="warningMessage" class="notification warning hidden">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                <span id="warningMessageText" class="font-semibold"></span>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                <div class="header-icon bg-gradient-to-br from-primary to-primary-light text-white w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Candidature à la Soutenance</h1>
                    <p class="text-lg text-gray-600 font-normal">Suivez les étapes ci-dessous pour soumettre votre dossier de candidature</p>
                </div>
            </div>
        </div>

        <!-- Steps Container -->
        <div class="space-y-6 animate-scale-in">
            <!-- Step 1: Informations du stage -->
            <div class="step-card <?= !empty($stage_info) ? 'completed' : 'active' ?> p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                    <div class="flex items-start space-x-6">
                        <div class="step-number <?= !empty($stage_info) ? 'completed' : 'active' ?>">
                            <?php if (!empty($stage_info)): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                1
                            <?php endif; ?>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Informations du Stage</h2>
                            <p class="text-gray-600 mb-4">Cette première étape est requise pour débloquer la suite du processus.</p>
                            <?php if (!empty($stage_info)): ?>
                                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-green-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                <strong>Entreprise:</strong> <?= htmlspecialchars($stage_info['nom_entreprise'] ?? '') ?><br>
                                                <strong>Sujet:</strong> <?= htmlspecialchars($stage_info['sujet_stage'] ?? '') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <button onclick="openStageInfoModal()" class="btn <?= !empty($stage_info) ? 'btn-secondary' : 'btn-primary' ?>">
                            <i class="fas fa-<?= !empty($stage_info) ? 'edit' : 'plus' ?>"></i>
                            <span><?php echo empty($stage_info) ? 'Remplir les informations' : 'Mettre à jour'; ?></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Demande de candidature -->
            <div class="step-card <?= $candidatureStatus ? 'completed' : (empty($stage_info) ? '' : 'active') ?> p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                    <div class="flex items-start space-x-6">
                        <div class="step-number <?= $candidatureStatus ? 'completed' : (empty($stage_info) ? 'disabled' : 'active') ?>">
                            <?php if ($candidatureStatus): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                2
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="flex items-center space-x-4 mb-2">
                                <h2 class="text-2xl font-bold <?php echo empty($stage_info) ? 'text-gray-400' : 'text-gray-900'; ?>">
                                    Demande de Candidature
                                </h2>
                                <?php if ($candidatureStatus): ?>
                                    <span class="status-badge <?php echo $candidatureStatus === 'Validée' ? 'status-validee' : 'status-en-attente'; ?>">
                                        <?php echo htmlspecialchars($candidatureStatus); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <p class="<?php echo empty($stage_info) ? 'text-gray-400' : 'text-gray-600'; ?> mb-4">
                                Soumettez votre dossier à l'administration pour validation.
                            </p>
                            <?php if ($candidatureStatus): ?>
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                Votre candidature a été soumise avec succès. 
                                                <?php if ($candidatureStatus === 'Validée'): ?>
                                                    Elle a été validée par l'administration.
                                                <?php else: ?>
                                                    Elle est en cours d'examen par l'administration.
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <?php
                            $onclick_cand = empty($stage_info)
                                ? 'showWarning("Veuillez d\'abord remplir les informations de stage à l\'étape 1."); return false;'
                                : ($disableCandidature
                                    ? 'showWarning("Vous avez déjà une candidature en attente ou validée."); return false;'
                                    : 'openConfirmationModal()');
                            $btnClass = $disableCandidature || empty($stage_info) ? 'btn-disabled' : 'btn-primary';
                        ?>
                        <button onclick="<?php echo $onclick_cand; ?>" class="btn <?php echo $btnClass; ?>" <?= ($disableCandidature || empty($stage_info)) ? 'disabled' : '' ?>>
                            <i class="fas fa-paper-plane"></i>
                            <span>Faire une demande</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation -->
    <div id="confirmationModal" class="modal-overlay">
        <div class="modal-container max-w-md">
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-question-circle text-blue-500 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Confirmer votre demande</h3>
                <p class="text-gray-600 mb-8">Êtes-vous sûr de vouloir soumettre votre demande de candidature ? Cette action ne pourra pas être annulée.</p>

                <form method="POST" action="?page=candidature_soutenance&action=demande_candidature">
                    <div class="flex gap-4">
                        <button type="button" onclick="closeConfirmationModal()" class="btn btn-gray flex-1">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="fas fa-check"></i>
                            <span>Confirmer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Informations du Stage -->
    <div id="stageInfoModal" class="modal-overlay">
        <div class="modal-container">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-primary">Informations du Stage</h3>
                    <p class="text-gray-600 mt-1">Complétez les informations ci-dessous</p>
                </div>
                <button onclick="closeStageInfoModal()" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-2xl flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="stageInfoForm" method="POST" action="?page=candidature_soutenance&action=info_stage" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="entreprise" class="block text-sm font-semibold text-gray-700 mb-2">Entreprise</label>
                        <input type="text" name="entreprise" required value="<?php echo isset($stage_info['nom_entreprise']) ? htmlspecialchars($stage_info['nom_entreprise']) : ''; ?>" class="form-input">
                    </div>
                    <div class="md:col-span-2">
                        <label for="sujet" class="block text-sm font-semibold text-gray-700 mb-2">Sujet du stage</label>
                        <input type="text" name="sujet" required value="<?php echo isset($stage_info['sujet_stage']) ? htmlspecialchars($stage_info['sujet_stage']) : ''; ?>" class="form-input">
                    </div>
                    <div>
                        <label for="date_debut" class="block text-sm font-semibold text-gray-700 mb-2">Date de début</label>
                        <input type="date" name="date_debut" required value="<?php echo isset($stage_info['date_debut_stage']) ? htmlspecialchars($stage_info['date_debut_stage']) : ''; ?>" class="form-input">
                    </div>
                    <div>
                        <label for="date_fin" class="block text-sm font-semibold text-gray-700 mb-2">Date de fin</label>
                        <input type="date" name="date_fin" required value="<?php echo isset($stage_info['date_fin_stage']) ? htmlspecialchars($stage_info['date_fin_stage']) : ''; ?>" class="form-input">
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description du stage</label>
                        <textarea name="description" required rows="4" class="form-input"><?php echo isset($stage_info['description_stage']) ? htmlspecialchars($stage_info['description_stage']) : ''; ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="encadrant" class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'encadrant</label>
                        <input type="text" name="encadrant" required value="<?php echo isset($stage_info['encadrant_entreprise']) ? htmlspecialchars($stage_info['encadrant_entreprise']) : ''; ?>" class="form-input">
                    </div>
                    <div>
                        <label for="email_encadrant" class="block text-sm font-semibold text-gray-700 mb-2">Email de l'encadrant</label>
                        <input type="email" name="email_encadrant" required value="<?php echo isset($stage_info['email_encadrant']) ? htmlspecialchars($stage_info['email_encadrant']) : ''; ?>" class="form-input">
                    </div>
                    <div>
                        <label for="telephone_encadrant" class="block text-sm font-semibold text-gray-700 mb-2">Téléphone de l'encadrant</label>
                        <input type="tel" name="telephone_encadrant" required value="<?php echo isset($stage_info['telephone_encadrant']) ? htmlspecialchars($stage_info['telephone_encadrant']) : ''; ?>" class="form-input">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-8">
                    <button type="button" onclick="closeStageInfoModal()" class="btn btn-gray flex-1">
                        Annuler
                    </button>
                    <button type="submit" name="btn_enregistrer" value="1" class="btn btn-primary flex-1">
                        <i class="fas fa-save"></i>
                        <span>Enregistrer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        
        const openConfirmationModal = () => openModal('confirmationModal');
        const closeConfirmationModal = () => closeModal('confirmationModal');
        const openStageInfoModal = () => openModal('stageInfoModal');
        const closeStageInfoModal = () => closeModal('stageInfoModal');

        function showWarning(message) {
            const warningBox = document.getElementById('warningMessage');
            const warningText = document.getElementById('warningMessageText');
            
            warningText.textContent = message;
            warningBox.classList.remove('hidden');

            setTimeout(() => {
                warningBox.style.transition = 'opacity 0.5s ease';
                warningBox.style.opacity = '0';
                setTimeout(() => {
                    warningBox.classList.add('hidden');
                    warningBox.style.opacity = '1'; 
                }, 500);
            }, 5000);
        }

        // Fermeture des modales en cliquant à l'extérieur
        window.addEventListener('click', function(e) {
            const modals = ['confirmationModal', 'stageInfoModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && e.target === modal) {
                    closeModal(modalId);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide notifications
            const notifications = document.querySelectorAll('#notification-area .notification:not(#warningMessage)');
            notifications.forEach(function(notification) {
                setTimeout(function() {
                    notification.style.transition = 'opacity 0.5s ease';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            });

            // Animation des cards
            const cards = document.querySelectorAll('.step-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>