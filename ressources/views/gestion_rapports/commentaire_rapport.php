<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
$statistiquesCompteRendu = $GLOBALS['statistiquesCompteRendu'] ?? ['total' => 0, 'semaine' => 0, 'mois' => 0];
$rapports = $GLOBALS['rapports'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Rendu des Rapports | Univalid</title>
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

        .rapport-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .rapport-card::before {
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

        .rapport-card:hover::before {
            opacity: 1;
        }

        .rapport-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12);
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

        .status-en-cours {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #3b82f6;
        }

        .status-valider {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-rejeter {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #ef4444;
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
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 95%;
            max-width: 1000px;
            max-height: 90vh;
            animation: scaleIn 0.5s ease-out forwards;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .modal-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3457cb 0%, #36865a 50%, #59bf3d 100%);
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
                    <i class="fas fa-comments"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Compte Rendu des Rapports</h1>
                    <p class="text-lg text-gray-600 font-normal">Consultez et évaluez les rapports soumis par les étudiants</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <?php if (isset($statistiquesCompteRendu)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.1s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-primary mb-1"><?= $statistiquesCompteRendu['total'] ?? 0 ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Total Rapports</p>
                        <p class="text-xs text-blue-600 font-medium">
                            <i class="fas fa-database mr-1"></i>Total soumis
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.2s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-secondary mb-1"><?= $statistiquesCompteRendu['semaine'] ?? 0 ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Cette Semaine</p>
                        <p class="text-xs text-green-600 font-medium">
                            <i class="fas fa-trending-up mr-1"></i>Récemment
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.3s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-warning/10 text-warning rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-warning mb-1"><?= $statistiquesCompteRendu['mois'] ?? 0 ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Ce Mois</p>
                        <p class="text-xs text-orange-600 font-medium">
                            <i class="fas fa-calendar mr-1"></i>Mensuel
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Filters Section -->
        <div class="card p-8 mb-8 animate-scale-in">
            <form method="GET">
                <input type="hidden" name="page" value="gestion_rapports">
                <input type="hidden" name="action" value="commentaire_rapport">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
                    <div class="search-container flex-1 max-w-md">
                        <input type="text" name="search" placeholder="Rechercher par nom, thème..." 
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                            class="form-input search-input">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <select name="statut" class="form-input min-w-[200px]">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" <?= (isset($_GET['statut']) && $_GET['statut'] === 'en_attente') ? 'selected' : '' ?>>En attente</option>
                            <option value="en_cours" <?= (isset($_GET['statut']) && $_GET['statut'] === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                            <option value="valider" <?= (isset($_GET['statut']) && $_GET['statut'] === 'valider') ? 'selected' : '' ?>>Validé</option>
                            <option value="rejeter" <?= (isset($_GET['statut']) && $_GET['statut'] === 'rejeter') ? 'selected' : '' ?>>Rejeté</option>
                        </select>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i>
                            <span>Filtrer</span>
                        </button>
                        
                        <?php if (!empty($_GET['statut']) || !empty($_GET['search'])): ?>
                            <a href="?page=gestion_rapports&action=commentaire_rapport" class="btn btn-gray">
                                <i class="fas fa-times"></i>
                                <span>Reset</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Reports List -->
        <div class="space-y-6 animate-scale-in">
            <?php if (isset($rapports) && !empty($rapports)): ?>
                <?php foreach ($rapports as $rapport): ?>
                <div class="rapport-card">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($rapport['nom_rapport']) ?></h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2 text-primary"></i>
                                    <span class="font-medium text-gray-700"><?= htmlspecialchars($rapport['prenom_etu'] . ' ' . $rapport['nom_etu']) ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    <span>Soumis le <?= date('d/m/Y', strtotime($rapport['date_rapport'])) ?></span>
                                </div>
                            </div>
                            
                            <?php
                                $status_map = [
                                    'en_attente' => ['class' => 'status-en-attente', 'text' => 'En attente', 'icon' => 'fas fa-clock'],
                                    'en_cours' => ['class' => 'status-en-cours', 'text' => 'En cours', 'icon' => 'fas fa-cogs'],
                                    'valider' => ['class' => 'status-valider', 'text' => 'Validé', 'icon' => 'fas fa-check'],
                                    'rejeter' => ['class' => 'status-rejeter', 'text' => 'Rejeté', 'icon' => 'fas fa-times'],
                                ];
                                $status_info = $status_map[$rapport['statut_rapport']] ?? ['class' => 'status-en-attente', 'text' => 'Inconnu', 'icon' => 'fas fa-question'];
                            ?>
                            <span class="status-badge <?= $status_info['class'] ?>">
                                <i class="<?= $status_info['icon'] ?> mr-2"></i>
                                <?= $status_info['text'] ?>
                            </span>
                        </div>
                        
                        <div class="flex-shrink-0">
                            <button onclick="voirDetailsRapport(<?= $rapport['id_rapport'] ?>)" class="btn btn-primary">
                                <i class="fas fa-eye"></i>
                                <span>Voir & Commenter</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-500 mb-2">Aucun rapport à afficher</h3>
                    <p class="text-gray-400">Les rapports soumis apparaîtront ici pour évaluation</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal détails rapport -->
    <div id="detailsModal" class="modal-overlay">
        <div class="modal-container">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-bold text-primary">Détails et Compte Rendu</h2>
                    <p class="text-gray-600 mt-1">Évaluation du rapport</p>
                </div>
                <button onclick="fermerModalDetails()" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-2xl flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="modalContent" class="p-6 overflow-y-auto max-h-[70vh]">
                <!-- Le contenu sera chargé ici -->
            </div>
        </div>
    </div>

    <script>
        // VOTRE JAVASCRIPT POUR LA MODALE EST CONSERVÉ À L'IDENTIQUE
        function voirDetailsRapport(rapportId) {
            const modal = document.getElementById('detailsModal');
            const modalContent = document.getElementById('modalContent');
            modal.style.display = 'flex';
            modalContent.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 font-medium">Chargement des détails...</p>
                </div>
            `;

            fetch(`?page=gestion_rapports&action=get_commentaires&id=${rapportId}`)
                .then(response => response.ok ? response.text() : Promise.reject('Network response was not ok.'))
                .then(html => modalContent.innerHTML = html)
                .catch(error => {
                    console.error('Fetch Error:', error);
                    modalContent.innerHTML = `
                        <div class="text-center p-8">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                            </div>
                            <p class="text-red-600 font-medium">Erreur lors du chargement des détails</p>
                        </div>
                    `;
                });
        }

        function fermerModalDetails() {
            const modal = document.getElementById('detailsModal');
            modal.style.display = 'none';
        }

        // Fermeture en cliquant à l'extérieur
        document.getElementById('detailsModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('detailsModal')) {
                fermerModalDetails();
            }
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes
            const cards = document.querySelectorAll('.stat-card, .rapport-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>