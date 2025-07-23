<?php
// Récupérer les données des rapports depuis le contrôleur
$rapports = $GLOBALS['rapports'] ?? [];
$nbRapports = $GLOBALS['nbRapports'] ?? 0;
$statsRapports = $GLOBALS['statsRapports'] ?? [];

// Fonction pour obtenir la classe CSS du statut
function getStatutClass($statut) {
    switch ($statut) {
        case 'valide':
            return 'text-green-500 ';
        case 'rejete':
            return 'text-red-500 ';
        case 'en_cours':
            return 'text-blue-500 ';
        case 'en_attente':
            return 'text-yellow-500 ';
        default:
            return 'text-gray-500 ';
    }
}

// Fonction pour traduire le statut
function traduireStatut($statut) {
    switch ($statut) {
        case 'valide':
            return 'Validé';
        case 'rejete':
            return 'Rejeté';
        case 'en_cours':
            return 'En cours';
        case 'en_attente':
            return 'En attente';
        default:
            return ucfirst($statut);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification des Candidatures | Univalid</title>
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

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
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

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12);
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

        .search-container {
            position: relative;
        }

        .search-input {
            padding-left: 48px;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }

        .table-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 20px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-row {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-row:hover {
            background: rgba(52, 87, 203, 0.02);
            transform: scale(1.01);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3457cb 0%, #24407a 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(52, 87, 203, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(52, 87, 203, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #36865a 0%, #59bf3d 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(54, 134, 90, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(54, 134, 90, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4);
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
            max-width: 700px;
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

        .notification.info {
            background: linear-gradient(135deg, rgba(52, 87, 203, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
            border-color: rgba(52, 87, 203, 0.2);
            color: #3457cb;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }

        body.modal-open {
            overflow: hidden;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-en-attente {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .status-valide {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-rejete {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .status-en-cours {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #3b82f6;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <?php
    // Afficher les messages de session
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $messageType = $_SESSION['message_type'] ?? 'info';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        
        echo '<div id="notification" class="fixed top-6 right-6 z-50 notification ' . $messageType . '">';
        echo '<div class="flex items-center">';
        echo '<i class="fas ' . (($messageType === 'success') ? 'fa-check-circle' : 
                               (($messageType === 'error') ? 'fa-exclamation-circle' : 
                               'fa-info-circle')) . ' mr-2 text-lg"></i>';
        echo '<span class="font-semibold">' . htmlspecialchars($message) . '</span>';
        echo '</div>';
        echo '</div>';
        
        echo '<script>
            setTimeout(function() {
                const notification = document.getElementById("notification");
                if (notification) {
                    notification.style.transform = "translateX(100%)";
                    setTimeout(function() {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }
            }, 3000);
        </script>';
    }
    ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                <div class="header-icon bg-gradient-to-br from-secondary to-secondary-light text-white w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Vérification des Candidatures</h1>
                    <p class="text-lg text-gray-600 font-normal">Gérez et validez les rapports soumis par les étudiants</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.1s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-primary mb-1"><?= $nbRapports ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Total Rapports</p>
                        <p class="text-xs text-blue-600 font-medium">
                            <i class="fas fa-info-circle mr-1"></i>En attente
                        </p>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($statsRapports)): ?>
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.2s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-secondary mb-1"><?= $statsRapports['approuve'] ?? 0 ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Approuvés</p>
                        <p class="text-xs text-green-600 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>Validés
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.3s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-danger/10 text-danger rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-danger mb-1"><?= $statsRapports['desapprouve'] ?? 0 ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Désapprouvés</p>
                        <p class="text-xs text-red-600 font-medium">
                            <i class="fas fa-arrow-down mr-1"></i>Rejetés
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Search Section -->
        <div class="card p-6 mb-8 animate-scale-in">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Rechercher par nom d'étudiant, rapport ou thème..." 
                    class="form-input search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-container animate-scale-in">
            <div class="table-header">
                <h2 class="text-xl font-bold text-primary flex items-center">
                    <i class="fas fa-list-ul mr-3"></i>
                    Liste des Rapports à Vérifier
                </h2>
                <p class="text-gray-600 mt-1">Validez ou rejetez les rapports soumis par les étudiants</p>
            </div>

            <div class="overflow-x-auto">
                <table id="rapportsTable" class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-user-graduate mr-2"></i>Étudiant
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-file-lines mr-2"></i>Rapport
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-lightbulb mr-2"></i>Thème
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar-day mr-2"></i>Date de dépôt
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rapports)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-file-circle-xmark text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-500 mb-2">Aucun rapport trouvé</p>
                                    <p class="text-sm text-gray-400">Les rapports soumis par les étudiants apparaîtront ici</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($rapports as $i => $rapport): ?>
                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-secondary/10 text-secondary rounded-full flex items-center justify-center text-sm font-bold">
                                        <?= strtoupper(substr($rapport->nom_etu, 0, 1) . substr($rapport->prenom_etu, 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">
                                            <?= htmlspecialchars($rapport->nom_etu . ' ' . $rapport->prenom_etu) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">Étudiant</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900"><?= htmlspecialchars($rapport->nom_rapport) ?></div>
                                <div class="text-sm text-gray-500">Rapport de master</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-blue-700 max-w-xs">
                                    <span class="italic"><?= htmlspecialchars($rapport->theme_rapport) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-warning"></i>
                                    <span class="font-semibold text-gray-700"><?= date('d/m/Y', strtotime($rapport->date_depot)) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="action-buttons">
                                    <button onclick="voirDetail(<?= $rapport->id_rapport ?>)" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                        <span>Détail</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal pour les détails du rapport -->
    <div id="detailModal" class="modal-overlay">
        <div class="modal-container">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-primary">Détails du Rapport</h3>
                    <p class="text-gray-600 mt-1">Informations complètes du rapport</p>
                </div>
                <button onclick="fermerModal()" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-2xl flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="modalContent">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
        </div>
    </div>

    <!-- Modal de confirmation validation/rejet -->
    <div id="confirmModal" class="modal-overlay">
        <div class="modal-container max-w-md">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-warning/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-warning text-3xl"></i>
                </div>
                <h3 id="confirmModalTitle" class="text-xl font-bold text-gray-800"></h3>
            </div>

            <!-- Formulaire PHP pour valider -->
            <form id="validerForm" method="POST" action="?page=verification_candidatures_soutenance" style="display: none;">
                <input type="hidden" name="valider" value="1">
                <input type="hidden" id="validerRapportId" name="id_rapport">
                <div class="mb-6">
                    <label for="validerComment" class="block text-sm font-semibold text-gray-700 mb-2">Commentaire (obligatoire)</label>
                    <textarea id="validerComment" name="commentaire" rows="3"
                        class="form-input resize-none"
                        placeholder="Entrez votre commentaire..." required></textarea>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" onclick="closeConfirmModal()" class="btn btn-gray flex-1">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-secondary flex-1">
                        <i class="fas fa-check"></i>
                        Confirmer l'approbation
                    </button>
                </div>
            </form>

            <!-- Formulaire PHP pour rejeter -->
            <form id="rejeterForm" method="POST" action="?page=verification_candidatures_soutenance" style="display: none;">
                <input type="hidden" name="rejeter" value="1">
                <input type="hidden" id="rejeterRapportId" name="id_rapport">
                <div class="mb-6">
                    <label for="rejeterComment" class="block text-sm font-semibold text-gray-700 mb-2">Commentaire (obligatoire)</label>
                    <textarea id="rejeterComment" name="commentaire" rows="3"
                        class="form-input resize-none"
                        placeholder="Entrez votre commentaire..." required></textarea>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" onclick="closeConfirmModal()" class="btn btn-gray flex-1">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-danger flex-1">
                        <i class="fas fa-times"></i>
                        Confirmer le rejet
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variables globales
        let pendingAction = null;
        let pendingRapportId = null;

        // Recherche dynamique dans le tableau
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('#rapportsTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // Fonctions de validation/rejet
        function validerRapport(idRapport) {
            openConfirmModal('valider', idRapport);
        }

        function rejeterRapport(idRapport) {
            openConfirmModal('rejeter', idRapport);
        }

        function openConfirmModal(action, idRapport) {
            console.log('Ouverture modal pour action:', action, 'ID:', idRapport);

            pendingAction = action;
            pendingRapportId = idRapport;

            document.getElementById('confirmModalTitle').textContent = (action === 'valider') ?
                'Confirmer l\'approbation du rapport ?' : 'Confirmer la désapprobation du rapport ?';

            const validerForm = document.getElementById('validerForm');
            const rejeterForm = document.getElementById('rejeterForm');

            if (action === 'valider') {
                validerForm.style.display = 'block';
                rejeterForm.style.display = 'none';
                document.getElementById('validerRapportId').value = idRapport;
                document.getElementById('validerComment').value = '';
            } else {
                validerForm.style.display = 'none';
                rejeterForm.style.display = 'block';
                document.getElementById('rejeterRapportId').value = idRapport;
                document.getElementById('rejeterComment').value = '';
            }

            const modal = document.getElementById('confirmModal');
            modal.style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        // Fonction pour voir les détails d'un rapport
        function voirDetail(idRapport) {
            const modal = document.getElementById('detailModal');
            modal.style.display = 'flex';
            document.body.classList.add('modal-open');

            document.getElementById('modalContent').innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                    <span class="ml-2 text-gray-600 font-medium">Chargement des détails...</span>
                </div>
            `;

            fetch('?page=verification_candidatures_soutenance&action=detail&id=' + idRapport)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors du chargement');
                    }
                    return response.text();
                })
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('modalContent').innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p class="font-semibold">Erreur lors du chargement des détails</p>
                        </div>
                    `;
                });
        }

        function fermerModal() {
            const modal = document.getElementById('detailModal');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Fermer les modals en cliquant à l'extérieur
            const modals = ['detailModal', 'confirmModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        if (modalId === 'detailModal') {
                            fermerModal();
                        } else {
                            closeConfirmModal();
                        }
                    }
                });
            });

            // Animation des cartes
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Fermer les modals avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fermerModal();
                closeConfirmModal();
            }
        });

        // Fonction pour afficher des notifications
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 z-50 notification ${type}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2 text-lg"></i>
                    <span class="font-semibold">${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    </script>
</body>

</html>