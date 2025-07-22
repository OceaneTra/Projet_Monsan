<?php
// Récupérer les données du contrôleur
global $stats;
$dashboardData = $stats ?? [];

// Données par défaut si pas de données
$totalRapports = $dashboardData['total_rapports'] ?? 0;
$tauxValidation = $dashboardData['taux_validation'] ?? 0;
$tempsMoyen = $dashboardData['temps_moyen'] ?? 0;
$enAttente = $dashboardData['en_attente'] ?? 0;

// Données pour les graphiques
$evolutionData = $dashboardData['evolution_mensuelle'] ?? [];
$repartitionData = $dashboardData['repartition_statuts'] ?? [];
$performanceData = $dashboardData['performance_categories'] ?? [];
$activitesData = $dashboardData['activites_recentes'] ?? [];
$rapportsDetails = $dashboardData['rapports_details'] ?? [];

// Fonctions utilitaires
function getTimeAgo($date) {
    if (!$date) return 'N/A';
    $time = time() - strtotime($date);
    if ($time < 3600) return floor($time/60) . 'min';
    if ($time < 86400) return floor($time/3600) . 'h';
    return floor($time/86400) . 'j';
}

function getStatusClass($status) {
    switch ($status) {
        case 'valide': return 'bg-green-100 text-green-800';
        case 'rejete': return 'bg-red-100 text-red-800';
        case 'en_cours': return 'bg-orange-100 text-orange-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

// Préparer les données pour Chart.js
$evolutionLabels = [];
$evolutionFinalises = [];
$evolutionRejetes = [];

foreach ($evolutionData as $data) {
    $evolutionLabels[] = date('M Y', strtotime($data['mois'] . '-01'));
    $evolutionFinalises[] = $data['finalises'];
    $evolutionRejetes[] = $data['rejetes'];
}

$statusLabels = [];
$statusData = [];
$statusColors = ['#ef4444','#10b981', '#f59e0b', '#6b7280'];

foreach ($repartitionData as $data) {
    $statusLabels[] = ucfirst($data['statut']);
    $statusData[] = $data['nombre'];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques | Commission de Validation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
    .sidebar-hover:hover {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .progress-ring {
        transition: stroke-dasharray 0.6s ease-in-out;
    }

    .metric-value {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .trend-up {
        color: #10b981;
    }

    .trend-down {
        color: #ef4444;
    }

    .trend-stable {
        color: #6b7280;
    }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <!-- Main content area -->
        <div class="flex-1 overflow-y-auto bg-gray-50">
            <div class="max-w-7xl mx-auto p-6">
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Comptes Rendus</p>
                                <p class="metric-value"><?php echo $totalRapports; ?></p>
                                <div class="flex items-center mt-2">
                                    <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                    <span class="text-sm text-green-600">+12% ce mois</span>
                                </div>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100">
                                <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Taux de Validation</p>
                                <p class="metric-value"><?php echo $tauxValidation; ?>%</p>
                                <div class="flex items-center mt-2">
                                    <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                    <span class="text-sm text-green-600">+3% ce mois</span>
                                </div>
                            </div>
                            <div class="p-3 rounded-full bg-green-100">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Temps Moyen</p>
                                <p class="metric-value"><?php echo $tempsMoyen; ?>j</p>
                                <div class="flex items-center mt-2">
                                    <i class="fas fa-arrow-down text-sm trend-up mr-1"></i>
                                    <span class="text-sm text-green-600">-8% ce mois</span>
                                </div>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100">
                                <i class="fas fa-clock text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">En Attente</p>
                                <p class="metric-value"><?php echo $enAttente; ?></p>
                                <div class="flex items-center mt-2">
                                    <i class="fas fa-minus text-sm trend-stable mr-1"></i>
                                    <span class="text-sm text-gray-600">Stable</span>
                                </div>
                            </div>
                            <div class="p-3 rounded-full bg-orange-100">
                                <i class="fas fa-hourglass-half text-orange-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Evolution Chart -->
                    <div class="bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                                Évolution des Comptes Rendus
                            </h3>
                            <div class="flex items-center space-x-2 text-sm">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-600 rounded-full mr-1"></div>
                                    <span>Finalisés</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-600 rounded-full mr-1"></div>
                                    <span>Rejetés</span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="evolutionChart"></canvas>
                        </div>
                    </div>

                    <!-- Status Distribution -->
                    <div class="bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                                Répartition par Statut
                            </h3>
                            <button onclick="refreshCharts()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Detailed Stats -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Performance by Category -->
                    <div class="bg-white rounded-lg shadow p-6 fade-in">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-tags text-purple-600 mr-2"></i>
                            Performance par Catégorie
                        </h3>
                        <div class="space-y-4">
                            <?php if (!empty($performanceData)): ?>
                                <?php foreach ($performanceData as $category): ?>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium"><?php echo ucfirst($category['categorie']); ?></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $category['taux']; ?>%"></div>
                                        </div>
                                        <span class="text-sm font-semibold"><?php echo $category['taux']; ?>%</span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-gray-500 py-4">
                                    <i class="fas fa-chart-bar text-2xl mb-2"></i>
                                    <p>Aucune donnée disponible</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow p-6 fade-in">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-history text-indigo-600 mr-2"></i>
                            Activité Récente
                        </h3>
                        <div class="space-y-3">
                            <?php if (!empty($activitesData)): ?>
                                <?php foreach ($activitesData as $activite): ?>
                                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                                    <div class="p-2 <?php echo $activite['statut'] === 'valider' ? 'bg-green-100' : 'bg-red-100'; ?> rounded-full">
                                        <i class="fas fa-<?php echo $activite['statut'] === 'valider' ? 'check' : 'times'; ?> text-<?php echo $activite['statut'] === 'valider' ? 'green' : 'red'; ?>-600 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Rapport <?php echo ucfirst($activite['statut']); ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?php echo $activite['titre']; ?> - <?php echo $activite['prenom_etudiant'] . ' ' . $activite['nom_etudiant']; ?>
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            Par <?php echo $activite['prenom_enseignant'] . ' ' . $activite['nom_enseignant']; ?>
                                        </p>
                                    </div>
                                    <span class="text-xs text-gray-400"><?php echo getTimeAgo($activite['date_validation']); ?></span>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-gray-500 py-4">
                                    <i class="fas fa-history text-2xl mb-2"></i>
                                    <p>Aucune activité récente</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6 fade-in">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                            Actions Rapides
                        </h3>
                        <div class="space-y-3">
                            <button onclick="generateReport()"
                                class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Générer Rapport Mensuel
                            </button>
                            <button onclick="exportData()"
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                <i class="fas fa-download mr-2"></i>
                                Exporter Données
                            </button>
                            <button onclick="viewArchives()"
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                <i class="fas fa-archive mr-2"></i>
                                Consulter Archives
                            </button>
                            <button onclick="settings()"
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                <i class="fas fa-cog mr-2"></i>
                                Paramètres
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Performance Table -->
                <div class="bg-white rounded-lg shadow p-6 fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-table text-gray-600 mr-2"></i>
                            Détails des Performances
                        </h3>
                        <div class="flex items-center space-x-2">
                            <input type="text" placeholder="Rechercher..."
                                class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <button class="px-3 py-1 text-sm bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enseignant</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps de traitement</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($rapportsDetails)): ?>
                                    <?php foreach ($rapportsDetails as $rapport): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full <?php echo $rapport['statut'] === 'valider' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                                <?php echo ucfirst($rapport['statut']); ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            <?php echo $rapport['titre']; ?>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            <?php echo $rapport['prenom_etudiant'] . ' ' . $rapport['nom_etudiant']; ?>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            <?php echo $rapport['prenom_enseignant'] . ' ' . $rapport['nom_enseignant']; ?>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            <?php echo $rapport['temps_traitement'] ?? 0; ?> jours
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-blue-600 hover:text-blue-900 mr-2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            <i class="fas fa-table text-2xl mb-2"></i>
                                            <p>Aucun rapport disponible</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
    // Variables globales pour les graphiques
    let evolutionChart, statusChart;

    // Données pour les graphiques depuis PHP
    const evolutionData = {
        labels: <?php echo json_encode($evolutionLabels); ?>,
        datasets: [{
                label: 'Finalisés',
                data: <?php echo json_encode($evolutionFinalises); ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Rejetés',
                data: <?php echo json_encode($evolutionRejetes); ?>,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    };

    const statusData = {
        labels: <?php echo json_encode($statusLabels); ?>,
        datasets: [{
            data: <?php echo json_encode($statusData); ?>,
            backgroundColor: <?php echo json_encode($statusColors); ?>,
            borderWidth: 0
        }]
    };

    // Initialisation des graphiques
    function initCharts() {
        // Graphique d'évolution
        const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
        evolutionChart = new Chart(evolutionCtx, {
            type: 'line',
            data: evolutionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    }
                }
            }
        });

        // Graphique de statut
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Fonctions d'action
    function refreshCharts() {
        showNotification('Actualisation des données...', 'info');
        setTimeout(() => {
            showNotification('Données actualisées avec succès', 'success');
        }, 1500);
    }

    function generateReport() {
        showNotification('Génération du rapport mensuel...', 'info');
        setTimeout(() => {
            showNotification('Rapport mensuel généré avec succès', 'success');
        }, 3000);
    }

    function exportData() {
        showNotification('Export des données en cours...', 'info');
        setTimeout(() => {
            showNotification('Données exportées au format Excel', 'success');
        }, 2000);
    }

    function viewArchives() {
        showNotification('Redirection vers les archives...', 'info');
        setTimeout(() => {
            showNotification('Ouverture de la section archives', 'success');
        }, 1000);
    }

    function settings() {
        showNotification('Ouverture des paramètres...', 'info');
    }

    // Système de notifications
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white text-sm font-medium z-50 ${
                type === 'success' ? 'bg-green-600' : 
                type === 'error' ? 'bg-red-600' : 
                type === 'info' ? 'bg-blue-600' : 'bg-gray-600'
            }`;
        notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} mr-2"></i>
                    ${message}
                </div>
            `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Animation des métriques au chargement
    function animateMetrics() {
        const metrics = document.querySelectorAll('.metric-value');
        metrics.forEach((metric, index) => {
            const finalValue = metric.textContent;
            metric.textContent = '0';

            setTimeout(() => {
                const increment = finalValue.includes('%') ? 1 : finalValue.includes('j') ? 0.1 : 1;
                const target = parseFloat(finalValue);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }

                    if (finalValue.includes('%')) {
                        metric.textContent = Math.round(current) + '%';
                    } else if (finalValue.includes('j')) {
                        metric.textContent = current.toFixed(1) + 'j';
                    } else {
                        metric.textContent = Math.round(current);
                    }
                }, 50);
            }, index * 200);
        });
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
        animateMetrics();

        const cards = document.querySelectorAll('.fade-in');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                refreshCharts();
            }
        });
    });

    setInterval(() => {
        refreshCharts();
    }, 300000);
    </script>
</body>

</html>