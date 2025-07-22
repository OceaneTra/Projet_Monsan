<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives | Mr. Diarra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-hover:hover {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .archive-card {
            transition: all 0.3s ease;
        }
        .archive-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        .timeline-item {
            position: relative;
            padding-left: 2rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #e5e7eb, transparent);
        }
        .timeline-item:last-child::before {
            display: none;
        }
        .timeline-dot {
            position: absolute;
            left: 0.25rem;
            top: 0.5rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            z-index: 1;
        }
        .filter-badge {
            transition: all 0.2s ease;
        }
        .filter-badge.active {
            background-color: #f59e0b;
            color: white;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-yellow-100 shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-pen-nib text-yellow-600 mr-2"></i>
                        <span class="text-yellow-600 font-bold">Rédaction CR</span>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-edit mr-3 text-gray-500"></i>
                            Nouveau compte rendu
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                            Brouillons
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">3</span>
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-check-circle mr-3 text-gray-500"></i>
                            Comptes rendus finalisés
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-yellow-700 bg-yellow-50">
                            <i class="fas fa-archive mr-3 text-yellow-500"></i>
                            Archives
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-template mr-3 text-gray-500"></i>
                            Modèles
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-chart-line mr-3 text-gray-500"></i>
                            Statistiques
                        </a>
                    </nav>
                    <div class="mt-auto pt-4 border-t border-gray-200">
                        <a href="#" class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-white shadow-sm">
                <div class="flex items-center">
                    <button id="mobileMenuButton" class="md:hidden text-gray-500 focus:outline-none mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">Archives</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-database mr-1"></i>
                        <span>Dernière sauvegarde: il y a 1h</span>
                    </div>
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/men/55.jpg" alt="Mr. Diarra">
                            <span class="text-sm font-medium text-gray-700">Mr. Diarra</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto p-6">
                    <!-- Header Section -->
                    <div class="mb-8">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <div class="mb-4 lg:mb-0">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Archives des Comptes Rendus</h2>
                                    <p class="text-gray-600">Accédez à l'historique complet de vos évaluations</p>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                    <div class="relative">
                                        <input type="text" id="searchInput" placeholder="Rechercher dans les archives..." 
                                               class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 w-64">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                    <button onclick="exportArchives()" class="flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                        <i class="fas fa-download mr-2"></i>Exporter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="mb-6">
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="text-sm font-medium text-gray-700">Filtrer par:</span>
                                <button onclick="filterArchives('all')" class="filter-badge active px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    Tous
                                </button>
                                <button onclick="filterArchives('2025')" class="filter-badge px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    2025
                                </button>
                                <button onclick="filterArchives('2024')" class="filter-badge px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    2024
                                </button>
                                <button onclick="filterArchives('validated')" class="filter-badge px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    <i class="fas fa-check mr-1"></i>Validés
                                </button>
                                <button onclick="filterArchives('rejected')" class="filter-badge px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    <i class="fas fa-times mr-1"></i>Rejetés
                                </button>
                                <div class="ml-auto flex items-center space-x-2">
                                    <select id="sortSelect" class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                        <option value="date-desc">Plus récent</option>
                                        <option value="date-asc">Plus ancien</option>
                                        <option value="name">Nom A-Z</option>
                                        <option value="student">Étudiant A-Z</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 mr-4">
                                    <i class="fas fa-archive text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Archivé</p>
                                    <p class="text-2xl font-bold text-gray-900">156</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 mr-4">
                                    <i class="fas fa-calendar text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Cette Année</p>
                                    <p class="text-2xl font-bold text-gray-900">45</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 mr-4">
                                    <i class="fas fa-folder text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Catégories</p>
                                    <p class="text-2xl font-bold text-gray-900">8</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-100 mr-4">
                                    <i class="fas fa-hard-drive text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Taille</p>
                                    <p class="text-2xl font-bold text-gray-900">2.3GB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Archives Timeline -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Timeline -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                                    <i class="fas fa-history text-indigo-600 mr-2"></i>
                                    Chronologie des Archives
                                </h3>
                                <div class="space-y-6" id="timelineContainer">
                                    <!-- Timeline Item 1 -->
                                    <div class="timeline-item">
                                        <div class="timeline-dot bg-green-500"></div>
                                        <div class="archive-card border border-gray-200 rounded-lg p-4 hover:border-green-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-900">Intelligence Artificielle en Médecine</h4>
                                                <span class="text-xs text-gray-500">23 Mai 2025</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3">Marie Lambert - Validé avec félicitations</p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Validé</span>
                                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">IA</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <button onclick="viewArchive(1)" class="p-1 text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </button>
                                                    <button onclick="downloadArchive(1)" class="p-1 text-green-600 hover:text-green-800">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </button>
                                                    <button onclick="restoreArchive(1)" class="p-1 text-orange-600 hover:text-orange-800">
                                                        <i class="fas fa-undo text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline Item 2 -->
                                    <div class="timeline-item">
                                        <div class="timeline-dot bg-red-500"></div>
                                        <div class="archive-card border border-gray-200 rounded-lg p-4 hover:border-red-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-900">Blockchain et Cryptographie</h4>
                                                <span class="text-xs text-gray-500">22 Mai 2025</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3">Jean Dupont - Rejeté pour méthodologie insuffisante</p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Rejeté</span>
                                                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Blockchain</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <button onclick="viewArchive(2)" class="p-1 text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </button>
                                                    <button onclick="downloadArchive(2)" class="p-1 text-green-600 hover:text-green-800">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </button>
                                                    <button onclick="restoreArchive(2)" class="p-1 text-orange-600 hover:text-orange-800">
                                                        <i class="fas fa-undo text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline Item 3 -->
                                    <div class="timeline-item">
                                        <div class="timeline-dot bg-orange-500"></div>
                                        <div class="archive-card border border-gray-200 rounded-lg p-4 hover:border-orange-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-900">Réseaux de Neurones Convolutifs</h4>
                                                <span class="text-xs text-gray-500">21 Mai 2025</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3">Thomas Moreau - En révision demandée</p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">Révision</span>
                                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">IA</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <button onclick="viewArchive(3)" class="p-1 text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </button>
                                                    <button onclick="downloadArchive(3)" class="p-1 text-green-600 hover:text-green-800">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </button>
                                                    <button onclick="restoreArchive(3)" class="p-1 text-orange-600 hover:text-orange-800">
                                                        <i class="fas fa-undo text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline Item 4 -->
                                    <div class="timeline-item">
                                        <div class="timeline-dot bg-green-500"></div>
                                        <div class="archive-card border border-gray-200 rounded-lg p-4 hover:border-green-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-900">Machine Learning en Finance</h4>
                                                <span class="text-xs text-gray-500">20 Mai 2025</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3">Sophie Dubois - Validé avec excellence</p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Validé</span>
                                                    <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded-full">Finance</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <button onclick="viewArchive(4)" class="p-1 text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </button>
                                                    <button onclick="downloadArchive(4)" class="p-1 text-green-600 hover:text-green-800">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </button>
                                                    <button onclick="restoreArchive(4)" class="p-1 text-orange-600 hover:text-orange-800">
                                                        <i class="fas fa-undo text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- More archives indicator -->
                                    <div class="text-center py-4">
                                        <button onclick="loadMoreArchives()" class="px-4 py-2 text-sm text-yellow-600 border border-yellow-300 rounded-md hover:bg-yellow-50">
                                            <i class="fas fa-chevron-down mr-2"></i>Charger plus d'archives
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Info -->
                        <div class="space-y-6">
                            <!-- Archive Categories -->
                            <div class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-folder-open text-yellow-600 mr-2"></i>
                                    Catégories
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                            <span class="text-sm">Intelligence Artificielle</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-600">42</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                            <span class="text-sm">Blockchain</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-600">28</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                            <span class="text-sm">Réseaux</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-600">35</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></div>
                                            <span class="text-sm">Finance</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-600">22</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                            <span class="text-sm">Sécurité</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-600">18</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                            <span class="text-sm">Autres</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-600">11</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Archive Tools -->
                            <div class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-tools text-gray-600 mr-2"></i>
                                    Outils d'Archive
                                </h3>
                                <div class="space-y-3">
                                    <button onclick="bulkExport()" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                        <i class="fas fa-file-export mr-2"></i>
                                        Export en masse
                                    </button>
                                    <button onclick="archiveCleanup()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                        <i class="fas fa-broom mr-2"></i>
                                        Nettoyage auto
                                    </button>
                                    <button onclick="archiveBackup()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        Sauvegarde sécurisée
                                    </button>
                                    <button onclick="archiveSettings()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                        <i class="fas fa-cog mr-2"></i>
                                        Paramètres
                                    </button>
                                </div>
                            </div>

                            <!-- Storage Info -->
                            <div class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-database text-purple-600 mr-2"></i>
                                    Stockage
                                </h3>
                                <div class="space-y-3">
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm text-gray-600">Utilisé</span>
                                            <span class="text-sm font-semibold">2.3 GB / 10 GB</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: 23%"></div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 space-y-1">
                                        <div class="flex justify-between">
                                            <span>Documents</span>
                                            <span>1.8 GB</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Métadonnées</span>
                                            <span>0.3 GB</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Index</span>
                                            <span>0.2 GB</span>
                                        </div>
                                    </div>
                                    <button onclick="optimizeStorage()" class="w-full mt-3 px-3 py-2 text-xs bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                        <i class="fas fa-compress mr-1"></i>Optimiser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Archive Modal -->
    <div id="viewArchiveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50" onclick="closeArchiveModal()"></div>
            
            <div class="inline-block w-full max-w-4xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                        Archive - Compte Rendu
                    </h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="printArchive()" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            <i class="fas fa-print mr-1"></i>Imprimer
                        </button>
                        <button onclick="downloadarchive()" class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                            <i class="fas fa-download mr-1"></i>Télécharger
                        </button>
                        <button onclick="closeArchiveModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6 max-h-96 overflow-y-auto">
                    <div id="archiveContent" class="prose max-w-none">
                        <!-- Archive content will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données des archives
        const archivesData = [
            {
                id: 1,
                title: "Intelligence Artificielle en Médecine",
                student: "Marie Lambert",
                date: "2025-05-23",
                status: "Validé",
                category: "IA",
                decision: "Validé avec félicitations"
            },
            {
                id: 2,
                title: "Blockchain et Cryptographie",
                student: "Jean Dupont",
                date: "2025-05-22",
                status: "Rejeté",
                category: "Blockchain",
                decision: "Rejeté pour méthodologie insuffisante"
            },
            {
                id: 3,
                title: "Réseaux de Neurones Convolutifs",
                student: "Thomas Moreau",
                date: "2025-05-21",
                status: "Révision",
                category: "IA",
                decision: "En révision demandée"
            },
            {
                id: 4,
                title: "Machine Learning en Finance",
                student: "Sophie Dubois",
                date: "2025-05-20",
                status: "Validé",
                category: "Finance",
                decision: "Validé avec excellence"
            }
        ];

        // Fonctions de filtrage
        function filterArchives(filter) {
            // Mettre à jour l'état actif du filtre
            document.querySelectorAll('.filter-badge').forEach(badge => {
                badge.classList.remove('active');
            });
            event.target.classList.add('active');

            showNotification(`Filtrage par: ${filter}`, 'info');
            
            // Ici on pourrait implémenter la logique de filtrage réelle
            setTimeout(() => {
                const count = filter === 'all' ? archivesData.length : 
                             Math.floor(Math.random() * archivesData.length) + 1;
                showNotification(`${count} archive(s) trouvée(s)`, 'success');
            }, 1000);
        }

        // Actions sur les archives
        function viewArchive(id) {
            const archive = archivesData.find(a => a.id === id) || archivesData[0];
            
            document.getElementById('archiveContent').innerHTML = `
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold mb-4">COMPTE RENDU D'ÉVALUATION (ARCHIVE)</h1>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Commission de Validation des Rapports</h2>
                    <p class="text-gray-600">Université Félix Houphouët-Boigny</p>
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <i class="fas fa-archive text-yellow-600 mr-2"></i>
                        <span class="text-yellow-800 font-medium">Document Archivé - ${new Date(archive.date).toLocaleDateString('fr-FR')}</span>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-bold border-b-2 border-gray-300 pb-3 mb-4">INFORMATIONS GÉNÉRALES</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <p><strong>Titre du rapport :</strong> ${archive.title}</p>
                        <p><strong>Étudiant(e) :</strong> ${archive.student}</p>
                        <p><strong>Date d'archivage :</strong> ${new Date(archive.date).toLocaleDateString('fr-FR')}</p>
                        <p><strong>Statut final :</strong> ${archive.status}</p>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-bold border-b-2 border-gray-300 pb-3 mb-4">DÉCISION ARCHIVÉE</h3>
                    <div class="p-4 rounded-lg ${archive.status === 'Validé' ? 'bg-green-50 border border-green-200' : 
                                                  archive.status === 'Rejeté' ? 'bg-red-50 border border-red-200' : 
                                                  'bg-orange-50 border border-orange-200'}">
                        <p class="font-medium">${archive.decision}</p>
                    </div>
                </div>
                
                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500">
                        Archive consultée le ${new Date().toLocaleDateString('fr-FR')} à ${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}
                    </p>
                </div>
            `;
            
            document.getElementById('viewArchiveModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function downloadArchive(id) {
            showNotification(`Téléchargement de l'archive #${id} en cours...`, 'info');
            setTimeout(() => {
                showNotification('Archive téléchargée avec succès', 'success');
            }, 2000);
        }

        function restoreArchive(id) {
            if (confirm('Êtes-vous sûr de vouloir restaurer cette archive ? Elle sera déplacée vers les rapports actifs.')) {
                showNotification(`Restauration de l'archive #${id} en cours...`, 'info');
                setTimeout(() => {
                    showNotification('Archive restaurée avec succès', 'success');
                }, 2000);
            }
        }

        function closeArchiveModal() {
            document.getElementById('viewArchiveModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function printArchive() {
            const content = document.getElementById('archiveContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Archive - Compte Rendu</title>
                    <style>
                        body { font-family: 'Times New Roman', serif; line-height: 1.6; margin: 40px; }
                        h1, h2, h3 { color: #333; }
                        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
                        .border-b-2 { border-bottom: 2px solid #ccc; padding-bottom: 12px; margin-bottom: 16px; }
                        .mb-8 { margin-bottom: 32px; }
                        .p-4 { padding: 16px; }
                        .rounded-lg { border-radius: 8px; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                    </style>
                </head>
                <body>${content}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        // Outils d'archive
        function bulkExport() {
            showNotification('Export en masse démarré...', 'info');
            setTimeout(() => {
                showNotification('Export terminé - 156 archives exportées', 'success');
            }, 3000);
        }

        function archiveCleanup() {
            showNotification('Analyse des archives pour nettoyage...', 'info');
            setTimeout(() => {
                showNotification('Nettoyage terminé - 12 doublons supprimés', 'success');
            }, 2500);
        }

        function archiveBackup() {
            showNotification('Sauvegarde sécurisée en cours...', 'info');
            setTimeout(() => {
                showNotification('Sauvegarde terminée avec succès', 'success');
            }, 4000);
        }

        function archiveSettings() {
            showNotification('Ouverture des paramètres d\'archive...', 'info');
        }

        function optimizeStorage() {
            showNotification('Optimisation du stockage...', 'info');
            setTimeout(() => {
                showNotification('Optimisation terminée - 340 MB libérés', 'success');
            }, 3000);
        }

        function exportArchives() {
            showNotification('Export des archives sélectionnées...', 'info');
            setTimeout(() => {
                showNotification('Archives exportées avec succès', 'success');
            }, 2000);
        }

        function loadMoreArchives() {
            showNotification('Chargement d\'archives supplémentaires...', 'info');
            setTimeout(() => {
                showNotification('20 archives supplémentaires chargées', 'success');
            }, 1500);
        }

        // Fonctions de recherche et tri
        function searchArchives() {
            const searchTerm = document.getElementById('searchInput').value;
            if (searchTerm.length > 0) {
                showNotification(`Recherche: "${searchTerm}"`, 'info');
                setTimeout(() => {
                    const results = Math.floor(Math.random() * 10) + 1;
                    showNotification(`${results} résultat(s) trouvé(s)`, 'success');
                }, 1000);
            }
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

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Event listeners
            document.getElementById('searchInput').addEventListener('input', searchArchives);
            document.getElementById('sortSelect').addEventListener('change', function() {
                showNotification(`Tri par: ${this.options[this.selectedIndex].text}`, 'info');
            });
            
            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeArchiveModal();
                }
                if (e.ctrlKey && e.key === 'f') {
                    e.preventDefault();
                    document.getElementById('searchInput').focus();
                }
            });
        });
    </script>
</body>
</html>