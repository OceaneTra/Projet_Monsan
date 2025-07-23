<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
$infosDepot = isset($GLOBALS['infosDepot']) ? $GLOBALS['infosDepot'] : [];

$candidature_validee = false;
$message_candidature = '';

if (isset($_SESSION['num_etu'])) {
    $candidatures_etudiant = isset($GLOBALS['candidatures_etudiant']) ? $GLOBALS['candidatures_etudiant'] : [];
    
    foreach ($candidatures_etudiant as $candidature) {
        if ($candidature['statut_candidature'] === 'Validée') {
            $candidature_validee = true;
            break;
        }
    }
    
    if (!$candidature_validee) {
        $message_candidature = "Vous devez avoir une candidature validée pour accéder aux fonctionnalités de gestion des rapports.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rapports | Univalid</title>
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

        .action-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            text-align: center;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12);
        }

        .action-card.disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .action-card.disabled:hover {
            transform: none;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
        }

        .action-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 24px;
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon {
            transform: scale(1.1);
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
            text-decoration: none;
            justify-content: center;
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

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
        }

        .btn-disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border: 2px solid #e2e8f0;
        }

        .rapport-item {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .rapport-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
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
            gap: 8px;
        }

        .status-depose {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-en-cours {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .notification-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-width: 400px;
        }

        .notification {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.1);
            border: 1px solid #e2e8f0;
            border-left: 4px solid;
            transform: translateX(100%);
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            border-left-color: #10b981;
        }

        .notification.error {
            border-left-color: #ef4444;
        }

        .notification.warning {
            border-left-color: #f59e0b;
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
        }

        .modal-container {
            background: white;
            backdrop-filter: blur(20px);
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 95%;
            max-width: 500px;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                <div class="header-icon bg-gradient-to-br from-primary to-primary-light text-white w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Gestion des Rapports</h1>
                    <p class="text-lg text-gray-600 font-normal">Créez, suivez et consultez les retours sur vos rapports de master</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Section -->
        <div class="card mb-12 animate-scale-in">
            <div class="p-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tableau de bord</h2>
                <p class="text-gray-600">Accédez rapidement à toutes les fonctionnalités de gestion des rapports</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8">
                <?php
                function render_action_card($icon, $title, $description, $link, $button_text, $is_enabled, $icon_bg) {
                    $card_class = $is_enabled ? 'action-card' : 'action-card disabled';
                    $btn_class = $is_enabled ? 'btn btn-primary w-full' : 'btn btn-disabled w-full';
                    $onclick = $is_enabled ? '' : 'onclick="showCandidatureRequiredMessage(); return false;"';
                    
                    echo "<div class='$card_class'>";
                    echo "<div class='action-icon $icon_bg text-white'>$icon</div>";
                    echo "<h3 class='text-xl font-bold text-gray-900 mb-3'>$title</h3>";
                    echo "<p class='text-gray-600 mb-6 flex-grow text-sm leading-relaxed'>$description</p>";
                    if ($is_enabled) {
                        echo "<a href='$link' class='$btn_class'><i class='fas fa-arrow-right'></i><span>$button_text</span></a>";
                    } else {
                        echo "<button $onclick class='$btn_class' disabled><i class='fas fa-lock'></i><span>$button_text</span></button>";
                    }
                    echo '</div>';
                }

                render_action_card(
                    '<i class="fas fa-plus"></i>', 
                    'Créer un Rapport', 
                    'Rédigez et soumettez un nouveau rapport via notre plateforme interactive avec éditeur avancé.', 
                    '?page=gestion_rapports&action=creer_rapport', 
                    'Commencer', 
                    $candidature_validee,
                    'bg-gradient-to-br from-primary to-primary-light'
                );
                
                render_action_card(
                    '<i class="fas fa-chart-line"></i>', 
                    'Suivre l\'Avancée', 
                    'Surveillez l\'état de vos soumissions en temps réel avec un système de notifications avancé.', 
                    '?page=gestion_rapports&action=suivi_rapport', 
                    'Consulter', 
                    $candidature_validee,
                    'bg-gradient-to-br from-secondary to-secondary-light'
                );
                
                render_action_card(
                    '<i class="fas fa-comments"></i>', 
                    'Consulter les Retours', 
                    'Accédez aux commentaires détaillés des évaluateurs pour améliorer votre travail.', 
                    '?page=gestion_rapports&action=commentaire_rapport', 
                    'Voir les retours', 
                    $candidature_validee,
                    'bg-gradient-to-br from-warning to-orange-500'
                );
                ?>
            </div>
        </div>

        <!-- Reports List Section -->
        <div class="card animate-scale-in">
            <div class="p-8 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Mes Rapports Récents</h2>
                    <p class="text-gray-600">Gérez et suivez l'état de vos rapports</p>
                </div>
                <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold">
                    <?= count($infosDepot) ?> rapport<?= count($infosDepot) > 1 ? 's' : '' ?>
                </span>
            </div>
            
            <div class="p-8">
                <?php if (isset($rapportsRecents) && !empty($rapportsRecents)): ?>
                    <div class="space-y-4">
                        <?php foreach ($rapportsRecents as $rapport): ?>
                        <div class="rapport-item">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars($rapport->nom_rapport) ?></h4>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            Créé le <?= date('d/m/Y', strtotime($rapport->date_rapport)) ?>
                                        </span>
                                    </div>
                                    
                                    <?php
                                    $infoDepot = $infosDepot[$rapport->id_rapport] ?? ['peutDeposer' => true, 'messageDepot' => '', 'dejaDepose' => false];
                                    ?>

                                    <?php if ($infoDepot['dejaDepose']): ?>
                                        <span class="status-badge status-depose">
                                            <i class="fas fa-check-circle"></i>
                                            Déposé
                                        </span>
                                    <?php else: ?>
                                        <?php if (!$infoDepot['peutDeposer']): ?>
                                            <span class="status-badge status-en-cours" title="<?= htmlspecialchars($infoDepot['messageDepot']) ?>">
                                                <i class="fas fa-clock"></i>
                                                Évaluation en cours
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <?php if ($infoDepot['dejaDepose']): ?>
                                        <a href="?page=gestion_rapports&action=creer_rapport&edit=<?= $rapport->id_rapport ?>" 
                                           class="btn btn-secondary" title="Consulter">
                                            <i class="fas fa-eye"></i>
                                            <span>Consulter</span>
                                        </a>
                                    <?php else: ?>
                                        <?php if ($infoDepot['peutDeposer']): ?>
                                            <form method="POST" action="?page=gestion_rapports" class="inline">
                                                <input type="hidden" name="id_rapport" value="<?= $rapport->id_rapport ?>">
                                                <input type="hidden" name="action" value="deposer_rapport">
                                                <button type="submit" class="btn btn-warning" title="Déposer le rapport">
                                                    <i class="fas fa-paper-plane"></i>
                                                    <span>Déposer</span>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <a href="?page=gestion_rapports&action=creer_rapport&edit=<?= $rapport->id_rapport ?>" 
                                           class="btn btn-primary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                            <span>Modifier</span>
                                        </a>
                                        <button onclick="confirmerSuppression(<?= $rapport->id_rapport ?>, '<?= htmlspecialchars(addslashes($rapport->nom_rapport)) ?>')" 
                                                class="btn btn-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-500 mb-2">Vous n'avez aucun rapport pour le moment</h3>
                        <p class="text-gray-400 mb-6">Commencez par créer votre premier rapport de stage</p>
                        <?php if ($candidature_validee): ?>
                        <a href="?page=gestion_rapports&action=creer_rapport" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span>Créer mon premier rapport</span>
                        </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($rapportsRecents) && count($rapportsRecents) > 0): ?>
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <a href="?page=gestion_rapports&action=suivi_rapport" 
                       class="text-primary hover:text-primary-light font-semibold text-sm transition-colors duration-200">
                        Voir tous les rapports <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-container">
            <div class="text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Confirmer la suppression</h3>
                <p class="text-gray-600 mb-8">Êtes-vous sûr de vouloir supprimer le rapport <strong id="rapportNom" class="text-gray-800"></strong> ? Cette action est irréversible.</p>
                
                <form method="POST" action="?page=gestion_rapports">
                    <input type="hidden" name="action" value="supprimer_rapport">
                    <input type="hidden" name="rapport_id" id="rapportIdToDelete">
                    <div class="flex gap-4">
                        <button type="button" onclick="fermerModalSuppression()" class="btn btn-disabled flex-1">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-danger flex-1">
                            <i class="fas fa-trash"></i>
                            <span>Supprimer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="notification-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php if (isset($_GET['message'])): ?>
            <?php if ($_GET['message'] === 'depot_ok'): ?>
            showNotification('success', 'Le rapport a bien été déposé.');
            <?php elseif ($_GET['message'] === 'depot_fail'): ?>
            showNotification('error', 'Impossible de déposer le rapport.');
            <?php elseif ($_GET['message'] === 'depot_en_cours'): ?>
            showNotification('warning', 'Un autre rapport est déjà en cours d\'évaluation.');
            <?php elseif ($_GET['message'] === 'suppression_ok'): ?>
            showNotification('success', 'Le rapport a été supprimé avec succès.');
            <?php endif; ?>
            <?php endif; ?>

            // Animation des cartes
            const cards = document.querySelectorAll('.card, .action-card, .rapport-item');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        function showNotification(type, message, title = null) {
            const container = document.getElementById('notificationContainer');
            const notif = document.createElement('div');
            notif.className = `notification ${type}`;
            
            const typeTitles = { success: 'Succès', error: 'Erreur', info: 'Information', warning: 'Attention' };
            const icons = {
                success: '<i class="fas fa-check-circle text-green-500"></i>',
                error: '<i class="fas fa-times-circle text-red-500"></i>',
                info: '<i class="fas fa-info-circle text-blue-500"></i>',
                warning: '<i class="fas fa-exclamation-triangle text-yellow-500"></i>'
            };

            notif.innerHTML = `
                <div class="notification-icon">${icons[type]}</div>
                <div class="notification-content">
                    <h4 class="font-semibold text-gray-900 text-sm">${title || typeTitles[type]}</h4>
                    <p class="text-gray-600 text-sm">${message}</p>
                </div>
            `;
            container.appendChild(notif);

            setTimeout(() => notif.classList.add('show'), 10);
            setTimeout(() => {
                notif.classList.remove('show');
                setTimeout(() => notif.remove(), 300);
            }, 5000);
        }

        function showCandidatureRequiredMessage() {
            showNotification('error', "Vous devez avoir une candidature validée pour accéder à cette fonctionnalité.");
        }

        function confirmerSuppression(rapportId, rapportNom) {
            document.getElementById('rapportIdToDelete').value = rapportId;
            document.getElementById('rapportNom').textContent = `"${rapportNom}"`;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function fermerModalSuppression() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Fermeture des modales en cliquant à l'extérieur
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('deleteModal');
            if (modal && e.target === modal) {
                fermerModalSuppression();
            }
        });
    </script>
</body>

</html>