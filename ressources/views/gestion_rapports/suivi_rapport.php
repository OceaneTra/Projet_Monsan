<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
require_once __DIR__ . '/../../../app/config/database.php'; // Conservé comme dans votre fichier original
$pdo = Database::getConnection();
$statistiques = $GLOBALS['statistiques'] ?? ['total' => 0];
$rapports = $GLOBALS['rapports'] ?? [];

// DÉCLARATION DE TOUTES LES FONCTIONS D'AIDE ICI (UNE SEULE FOIS)
if (!function_exists('render_suivi_stat_card')) {
    function render_suivi_stat_card($label, $value, $icon, $color) {
        echo "<div class='stat-card animate-slide-in-right'><div class='flex items-center gap-4'><div class='w-14 h-14 bg-$color/10 text-$color rounded-xl flex items-center justify-center text-2xl'><i class='fas $icon'></i></div><div><h3 class='text-3xl font-bold text-$color mb-1'>$value</h3><p class='text-sm font-semibold text-gray-600'>$label</p></div></div></div>";
    }
}

if (!function_exists('render_timeline_item')) {
    function render_timeline_item($title, $date, $icon, $color_class, $comment = '') {
        echo '<div class="timeline-item">';
        echo "<div class='timeline-icon $color_class'><i class='fas $icon'></i></div>";
        echo '<div class="timeline-content">';
        echo '<h4 class="timeline-title">' . htmlspecialchars($title) . '</h4>';
        echo '<p class="timeline-date">' . htmlspecialchars($date) . '</p>';
        if ($comment) { 
            echo '<p class="timeline-comment">"' . htmlspecialchars($comment) . '"</p>'; 
        }
        echo '</div>';
        echo '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Rapports | Univalid</title>
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

        .rapport-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
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

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-en-attente {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #64748b;
            border: 1px solid #cbd5e1;
        }

        .status-en-cours {
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

        .timeline-container {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 2rem;
            padding: 1.5rem 0;
            overflow-x: auto;
            min-height: 120px;
        }

        .timeline-item {
            position: relative;
            min-width: 200px;
            flex-shrink: 0;
            text-align: center;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 100%;
            width: 2rem;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 16px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline-content {
            text-align: center;
        }

        .timeline-title {
            font-weight: 600;
            font-size: 14px;
            color: #374151;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .timeline-date {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .timeline-comment {
            font-size: 11px;
            color: #6b7280;
            font-style: italic;
            line-height: 1.2;
            max-width: 180px;
            margin: 0 auto;
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
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Suivi des Rapports</h1>
                    <p class="text-lg text-gray-600 font-normal">Consultez l'état d'avancement de chaque rapport en temps réel</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <?php
            // APPEL de la fonction, la déclaration est maintenant en haut du fichier
            render_suivi_stat_card("Total", $statistiques['total'] ?? 0, "fa-file-alt", "primary");
            render_suivi_stat_card("En cours", $statistiques['en_cours'] ?? 0, "fa-cogs", "warning");
            render_suivi_stat_card("Validés", $statistiques['valide'] ?? 0, "fa-check-double", "secondary");
            render_suivi_stat_card("À corriger", $statistiques['a_corriger'] ?? 0, "fa-edit", "danger");
            ?>
        </div>

        <!-- Filters Section -->
        <div class="card p-8 mb-8 animate-scale-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
                <div class="search-container flex-1 max-w-md">
                    <input type="text" id="searchInput" placeholder="Rechercher un rapport..." 
                        class="form-input search-input">
                    <i class="fas fa-search search-icon"></i>
                </div>
                
                <select id="statusFilter" class="form-input min-w-[200px]">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="en_cours">En cours</option>
                    <option value="rejete">Rejeté</option>
                    <option value="valide">Validé</option>
                </select>
            </div>
        </div>

        <!-- Reports List -->
        <div class="reports-list animate-scale-in">
            <?php if (!empty($rapports)): ?>
                <?php foreach ($rapports as $rapport): ?>
                <div class="report-item rapport-card">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-6 lg:space-y-0 mb-6">
                        <div class="flex-1">
                            <h3 class="report-title text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($rapport['nom_rapport']) ?></h3>
                            <p class="text-sm text-gray-500 mb-4">Soumis le <?= date('d/m/Y', strtotime($rapport['date_rapport'])) ?></p>
                            
                            <?php
                                $status_map = [
                                    'en_attente' => ['class' => 'status-en-attente', 'text' => 'En attente', 'icon' => 'fas fa-clock'],
                                    'en_cours' => ['class' => 'status-en-cours', 'text' => 'En cours', 'icon' => 'fas fa-cogs'],
                                    'valide' => ['class' => 'status-valide', 'text' => 'Validé', 'icon' => 'fas fa-check'],
                                    'rejete' => ['class' => 'status-rejete', 'text' => 'Rejeté', 'icon' => 'fas fa-times'],
                                ];
                                $status_info = $status_map[$rapport['statut_rapport']] ?? ['class' => 'status-en-attente', 'text' => 'Inconnu', 'icon' => 'fas fa-question'];
                            ?>
                            <span class="status status-badge <?= $status_info['class'] ?>">
                                <i class="<?= $status_info['icon'] ?> mr-2"></i>
                                <?= $status_info['text'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline-container">
                        <?php
                        // Votre logique PHP pour la timeline est préservée ici
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM deposer WHERE num_etu = ? AND id_rapport = ?");
                        $stmt->execute([$_SESSION['num_etu'], $rapport['id_rapport']]);
                        $estDepose = $stmt->fetchColumn() > 0;
                        
                        // APPEL de la fonction, la déclaration est maintenant en haut du fichier
                        render_timeline_item('Enregistrement du rapport', date('d M Y - H:i', strtotime($rapport['date_rapport'])), 'fa-save', 'bg-blue-500');

                        $soumissionDate = 'En attente';
                        if ($estDepose) {
                            $stmt = $pdo->prepare("SELECT date_depot FROM deposer WHERE num_etu = ? AND id_rapport = ?");
                            $stmt->execute([$_SESSION['num_etu'], $rapport['id_rapport']]);
                            $dateDepot = $stmt->fetchColumn();
                            $soumissionDate = $dateDepot ? date('d M Y - H:i', strtotime($dateDepot)) : 'Date inconnue';
                        }
                        render_timeline_item('Soumission du rapport', $soumissionDate, $estDepose ? 'fa-check' : 'fa-hourglass', $estDepose ? 'bg-blue-500' : 'bg-gray-400');

                        $verif = null;
                        foreach ($rapport['decisions'] as $decision) { if ($decision['lib_approb'] === 'Niveau 1') { $verif = $decision; break; } }
                        $verif_color = $verif ? ($verif['decision'] === 'approuve' ? 'bg-blue-500' : 'bg-red-500') : 'bg-gray-400';
                        $verif_icon = $verif ? ($verif['decision'] === 'approuve' ? 'fa-check' : 'fa-times') : 'fa-hourglass';
                        render_timeline_item('Vérification initiale', $verif ? date('d M Y - H:i', strtotime($verif['date_approv'])) : 'En attente', $verif_icon, $verif_color, $verif['commentaire_approv'] ?? '');
                        
                        $eval = null;
                        foreach ($rapport['decisions'] as $decision) { if ($decision['lib_approb'] === 'Niveau 2') { $eval = $decision; break; } }
                        $eval_color = $eval ? ($eval['decision'] === 'approuve' ? 'bg-blue-500' : 'bg-red-500') : 'bg-gray-400';
                        $eval_icon = $eval ? ($eval['decision'] === 'approuve' ? 'fa-check' : 'fa-times') : 'fa-hourglass';
                        render_timeline_item('Évaluation commission', $eval ? date('d M Y - H:i', strtotime($eval['date_approv'])) : 'En attente', $eval_icon, $eval_color, $eval['commentaire_approv'] ?? '');

                        $is_final = ($eval && $eval['decision'] === 'approuve' && $rapport['statut_rapport'] === 'valide');
                        render_timeline_item('Validation finale', $is_final ? 'Validé' : 'En attente', $is_final ? 'fa-check-double' : 'fa-hourglass', $is_final ? 'bg-green-500' : 'bg-gray-400');
                        ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-500 mb-2">Aucun rapport à suivre</h3>
                    <p class="text-gray-400">Vos rapports apparaîtront ici une fois soumis</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // VOTRE SCRIPT DE FILTRAGE CÔTÉ CLIENT EST CONSERVÉ
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');
            const reportItems = document.querySelectorAll('.report-item');

            statusFilter.addEventListener('change', filterReports);
            searchInput.addEventListener('input', filterReports);

            function filterReports() {
                const statusValue = statusFilter.value;
                const searchValue = searchInput.value.toLowerCase();

                reportItems.forEach(item => {
                    const title = item.querySelector('.report-title').textContent.toLowerCase();
                    const statusElement = item.querySelector('.status');
                    const statusText = statusElement.textContent.trim().toLowerCase().replace('é', 'e');
                    
                    const matchesSearch = title.includes(searchValue);
                    const matchesStatus = (statusValue === '' || statusText === statusValue.replace('_', ' '));
                    
                    if (matchesSearch && matchesStatus) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            // Animation des cartes
            const cards = document.querySelectorAll('.stat-card, .rapport-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>