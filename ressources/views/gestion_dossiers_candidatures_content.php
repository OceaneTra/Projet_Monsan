<?php
// Récupérer les données du contrôleur
$rapportsVerifies = $GLOBALS['rapports_verifies'] ?? [];
$statistiques = $GLOBALS['statistiques'] ?? ['total' => 0, 'approuves' => 0, 'desapprouves' => 0];

// Filtres
$statutFilter = $_GET['statut'] ?? 'all';
$searchTerm = $_GET['search'] ?? '';

// Filtrer les rapports selon les critères
if ($statutFilter !== 'all') {
    $rapportsVerifies = array_filter($rapportsVerifies, function($rapport) use ($statutFilter) {
        return $rapport['statut_approbation'] === $statutFilter;
    });
}

if (!empty($searchTerm)) {
    $rapportsVerifies = array_filter($rapportsVerifies, function($rapport) use ($searchTerm) {
        return stripos($rapport['nom_etu'] . ' ' . $rapport['prenom_etu'], $searchTerm) !== false ||
               stripos($rapport['titre_rapport'], $searchTerm) !== false ||
               stripos($rapport['theme_rapport'], $searchTerm) !== false;
    });
}

// Pagination
$perPage = 15;
$totalRapports = count($rapportsVerifies);
$totalPages = ($totalRapports > 0) ? ceil($totalRapports / $perPage) : 1;
$p = isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0 ? (int)$_GET['p'] : 1;
if ($p > $totalPages) $p = $totalPages;
$startIndex = ($p - 1) * $perPage;
$rapportsPage = array_slice($rapportsVerifies, $startIndex, $perPage);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Dossiers | Univalid</title>
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
            text-decoration: none;
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

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
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

        .status-approuve {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-desapprouve {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-nav {
            display: flex;
            gap: 4px;
        }

        .pagination-link {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
            text-decoration: none;
        }

        .pagination-link.active {
            background: linear-gradient(135deg, #3457cb 0%, #24407a 100%);
            color: white;
            border-color: #3457cb;
        }

        .pagination-link:not(.active) {
            background: white;
            color: #64748b;
        }

        .pagination-link:not(.active):hover {
            background: rgba(52, 87, 203, 0.05);
            color: #3457cb;
            border-color: rgba(52, 87, 203, 0.2);
        }

        .pagination-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
                    <i class="fas fa-archive"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">
                        Historique des Rapports <span class="text-gradient bg-gradient-to-r from-secondary to-secondary-light bg-clip-text text-transparent">MIAGE</span>
                    </h1>
                    <p class="text-lg text-gray-600 font-normal">Consultez tous les rapports vérifiés et validés</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.1s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-primary mb-1"><?php echo $statistiques['total']; ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Total Vérifiés</p>
                        <p class="text-xs text-blue-600 font-medium">
                            <i class="fas fa-info-circle mr-1"></i>Traités
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.2s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-secondary mb-1"><?php echo $statistiques['approuves']; ?></h3>
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
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-danger mb-1"><?php echo $statistiques['desapprouves']; ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Désapprouvés</p>
                        <p class="text-xs text-red-600 font-medium">
                            <i class="fas fa-arrow-down mr-1"></i>Rejetés
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="card p-6 mb-8 animate-scale-in">
            <form method="get" class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <?php if (isset($_GET['page'])): ?>
                <input type="hidden" name="page" value="<?= htmlspecialchars($_GET['page']) ?>">
                <?php endif; ?>
                
                <div class="flex-1 max-w-md">
                    <input type="text" name="search" placeholder="Rechercher par étudiant, titre ou thème..."
                        class="form-input" value="<?= htmlspecialchars($searchTerm) ?>">
                </div>
                
                <div class="flex gap-4 items-center">
                    <select name="statut" class="form-input min-w-[200px]">
                        <option value="all" <?php echo $statutFilter === 'all' ? 'selected' : ''; ?>>Tous les statuts</option>
                        <option value="approuve" <?php echo $statutFilter === 'approuve' ? 'selected' : ''; ?>>Approuvé</option>
                        <option value="desapprouve" <?php echo $statutFilter === 'desapprouve' ? 'selected' : ''; ?>>Désapprouvé</option>
                    </select>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        <span>Filtrer</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-container animate-scale-in">
            <div class="table-header">
                <h2 class="text-xl font-bold text-primary flex items-center">
                    <i class="fas fa-list-ul mr-3"></i>
                    Liste des Rapports Vérifiés
                </h2>
                <p class="text-gray-600 mt-1">Historique complet des rapports traités</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-user-graduate mr-2"></i>Étudiant
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-file-alt mr-2"></i>Rapport
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-lightbulb mr-2"></i>Thème
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Date d'envoi
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-user-check mr-2"></i>Vérifié par
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-flag mr-2"></i>Statut
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rapportsPage)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-search text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-500 mb-2">Aucun rapport trouvé</p>
                                    <p class="text-sm text-gray-400">Aucun rapport vérifié ne correspond à votre recherche</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($rapportsPage as $rapport): ?>
                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold">
                                        <?= strtoupper(substr($rapport['nom_etu'], 0, 1) . substr($rapport['prenom_etu'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">
                                            <?php echo htmlspecialchars($rapport['nom_etu'] . ' ' . $rapport['prenom_etu']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">Étudiant</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900"><?php echo htmlspecialchars($rapport['titre_rapport']); ?></div>
                                <div class="text-sm text-gray-500">Rapport de master</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-blue-700 max-w-xs">
                                    <span class="italic"><?php echo htmlspecialchars($rapport['theme_rapport']); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar text-warning"></i>
                                    <span class="font-semibold text-gray-700"><?php echo date('d/m/Y', strtotime($rapport['date_depot'])); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-secondary font-semibold">
                                    <?php echo htmlspecialchars($rapport['nom_pers_admin'] . ' ' . $rapport['prenom_pers_admin']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge <?php echo $rapport['statut_approbation'] === 'approuve' ? 'status-approuve' : 'status-desapprouve'; ?>">
                                    <i class="<?php echo $rapport['statut_approbation'] === 'approuve' ? 'fas fa-check-circle' : 'fas fa-times-circle'; ?>"></i>
                                    <?php echo $rapport['statut_approbation'] === 'approuve' ? 'Approuvé' : 'Désapprouvé'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center gap-2 justify-center flex-wrap">
                                    <a href="?page=gestion_dossiers_candidatures&action=telecharger_pdf&id_rapport=<?php echo $rapport['id_rapport']; ?>"
                                        title="Télécharger le rapport en PDF" class="btn btn-primary">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>PDF</span>
                                    </a>
                                    <a href="?page=gestion_dossiers_candidatures&action=consulter_rapport&id_rapport=<?php echo $rapport['id_rapport']; ?>"
                                        target="_blank" title="Consulter le rapport" class="btn btn-secondary">
                                        <i class="fas fa-file-text"></i>
                                        <span>Consulter</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1 || $totalRapports > 0): ?>
            <div class="pagination-container">
                <div class="text-gray-600 text-sm">
                    <?php if ($totalRapports > 0): ?>
                    Page <?= $p ?> sur <?= $totalPages ?> —
                    Affichage de <span class="font-semibold"><?= $startIndex + 1 ?></span>
                    à <span class="font-semibold"><?= min($startIndex + $perPage, $totalRapports) ?></span>
                    sur <span class="font-semibold"><?= $totalRapports ?></span> rapports vérifiés
                    <?php else: ?>
                    Aucun rapport à afficher
                    <?php endif; ?>
                </div>
                
                <?php if ($totalPages > 1): ?>
                <div class="pagination-nav">
                    <?php
                    function buildPageUrl($p) {
                        $params = $_GET;
                        $params['p'] = $p;
                        if (isset($_GET['page'])) {
                            $params['page'] = $_GET['page'];
                        }
                        return '?' . http_build_query($params);
                    }
                    ?>
                    <a href="<?= $p > 1 ? buildPageUrl($p-1) : '#' ?>" 
                        class="pagination-link <?= $p == 1 ? 'disabled' : '' ?>">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?= buildPageUrl($i) ?>" 
                        class="pagination-link <?= $i == $p ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                    <?php endfor; ?>
                    
                    <a href="<?= $p < $totalPages ? buildPageUrl($p+1) : '#' ?>" 
                        class="pagination-link <?= $p == $totalPages ? 'disabled' : '' ?>">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modale résumé de candidature -->
    <div id="resumeModal" class="modal-overlay">
        <div class="modal-container">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-primary">Détails du Rapport</h3>
                    <p class="text-gray-600 mt-1">Informations complètes du rapport</p>
                </div>
                <button onclick="closeResumeModal()" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-2xl flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="modalContent" class="text-gray-900">
                <!-- Contenu dynamique du résumé à insérer ici -->
            </div>
        </div>
    </div>

    <script>
        // Fonction pour ouvrir la modale des détails
        function openResumeModal(idRapport) {
            const modal = document.getElementById('resumeModal');
            modal.style.display = 'flex';

            // Récupérer les détails du rapport via AJAX
            fetch(`?page=gestion_dossiers_candidatures&action=get_details_rapport&id_rapport=${idRapport}`)
                .then(response => response.json())
                .then(data => {
                    const modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-500 mb-1">Étudiant</p>
                                    <p class="font-bold text-gray-900">${data.nom_etu} ${data.prenom_etu}</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-500 mb-1">Numéro étudiant</p>
                                    <p class="font-bold text-gray-900">${data.num_etu}</p>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm font-semibold text-gray-500 mb-1">Rapport</p>
                                <p class="font-bold text-gray-900">${data.nom_rapport}</p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm font-semibold text-gray-500 mb-1">Thème</p>
                                <p class="font-bold text-gray-900 italic">${data.theme_rapport}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-500 mb-1">Date de dépôt</p>
                                    <p class="font-bold text-gray-900">${new Date(data.date_rapport).toLocaleDateString('fr-FR')}</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-500 mb-1">Statut</p>
                                    <span class="status-badge ${data.statut_approbation === 'approuve' ? 'status-approuve' : 'status-desapprouve'}">
                                        <i class="${data.statut_approbation === 'approuve' ? 'fas fa-check-circle' : 'fas fa-times-circle'}"></i>
                                        ${data.statut_approbation === 'approuve' ? 'Approuvé' : 'Désapprouvé'}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-500 mb-1">Vérifié par</p>
                                    <p class="font-bold text-secondary">${data.nom_pers_admin} ${data.prenom_pers_admin}</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-500 mb-1">Date de vérification</p>
                                    <p class="font-bold text-gray-900">${new Date(data.date_approbation).toLocaleDateString('fr-FR')}</p>
                                </div>
                            </div>
                            
                            ${data.commentaire ? `
                                <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                                    <p class="text-sm font-semibold text-blue-700 mb-1">Commentaire</p>
                                    <p class="text-blue-900 italic">"${data.commentaire}"</p>
                                </div>
                            ` : ''}
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails:', error);
                    document.getElementById('modalContent').innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p class="font-semibold">Erreur lors de la récupération des détails du rapport</p>
                        </div>
                    `;
                });
        }

        function closeResumeModal() {
            const modal = document.getElementById('resumeModal');
            modal.style.display = 'none';
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Fermer la modale en cliquant à l'extérieur
            document.getElementById('resumeModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeResumeModal();
                }
            });

            // Animation des cartes
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Fermer la modale avec Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeResumeModal();
                }
            });
        });
    </script>
</body>

</html>