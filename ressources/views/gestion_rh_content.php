<?php
// Déterminer l'onglet actif (par défaut 'pers_admin')
$activeTab = $_GET['tab'] ?? 'pers_admin';
if (!in_array($activeTab, ['pers_admin', 'enseignant'])) { // Valider la valeur de l'onglet
    $activeTab = 'pers_admin';
}

// Récupération des messages depuis le contrôleur
$messageErreur = $GLOBALS['messageErreur'] ?? '';
$messageSuccess = $GLOBALS['messageSuccess'] ?? '';

// Récupération des données depuis le contrôleur
$personnel_admin = $GLOBALS['listePersAdmin'] ?? [];
$enseignants = $GLOBALS['listeEnseignants'] ?? [];
$listeGrades = $GLOBALS['listeGrades'] ?? [];
$listeFonctions = $GLOBALS['listeFonctions'] ?? [];
$listeSpecialites = $GLOBALS['listeSpecialites'] ?? [];

// Récupération des données pour édition
$pers_admin_a_modifier = $GLOBALS['pers_admin_a_modifier'] ?? null;
$enseignant_a_modifier = $GLOBALS['enseignant_a_modifier'] ?? null;

// Gestion des actions CRUD
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

// Structure pour le formulaire d'édition
$admin_edit = $pers_admin_a_modifier ?? null;

// Structure pour le formulaire d'édition enseignant
$enseignant_edit = $enseignant_a_modifier ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Ressources Humaines</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#157A6E', // Vert institutionnel
                        'primary-dark': '#0B3C32',
                        'secondary': '#2F53CD',
                        'secondary-light': '#60A5FA',
                        'accent': '#F6C700', // Jaune/Or pour le contraste
                        'yellow-custom': '#FFD700',
                        'yellow-bright': '#FFEB3B'
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in-down': 'fadeInDown 0.8s ease-out forwards',
                        'slide-in-right': 'slideInRight 0.8s ease-out forwards',
                        'scale-in': 'scaleIn 0.5s ease-out forwards',
                    }
                }
            }
        }
    </script>
    <style>
        /* General Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Custom Styles for this page */
        .tab-button-active {
            background-color: #157A6E;
            /* primary */
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(21, 122, 110, 0.3);
            /* Shadow for active tab */
            transform: translateY(-2px);
            /* Slight lift */
        }

        .tab-button-inactive {
            background-color: #f3f4f6;
            /* gray-100 */
            color: #4b5563;
            /* gray-700 */
            border: 1px solid #e5e7eb;
            /* gray-200 */
        }

        .tab-button-inactive:hover {
            background-color: #e0f2f1;
            /* primary/10 */
            color: #157A6E;
            /* primary */
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Darker overlay */
            backdrop-filter: blur(8px);
            /* Stronger blur */
            z-index: 999;
            /* Below sidebars/notifications, above main content */
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out forwards;
        }

        .modal-container {
            background-color: #fff;
            padding: 3rem;
            /* More padding */
            border-radius: 1.5rem;
            /* More rounded */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            /* Stronger shadow */
            width: 95%;
            max-width: 650px;
            /* Wider modal */
            animation: scaleIn 0.4s ease-out forwards;
            position: relative;
        }

        .modal-close-btn {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: none;
            border: none;
            font-size: 2rem;
            /* Larger icon */
            color: #9ca3af;
            /* gray-400 */
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .modal-close-btn:hover {
            color: #6b7280;
            /* gray-500 */
        }

        /* Custom Scrollbar for overflow elements */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            /* gray-400 */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
            /* gray-500 */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-800">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-6 py-10">

            <?php if (!empty($messageSuccess)): ?>
                <div id="success-message"
                    class="bg-green-100 border border-green-400 text-green-700 p-4 rounded-lg shadow-md mb-8 animate-fade-in-down"
                    role="alert">
                    <p class="flex items-center"><i class="fas fa-check-circle mr-3 text-lg"></i> <?= htmlspecialchars($messageSuccess) ?></p>
                </div>
            <?php endif; ?>
            <?php if (!empty($messageErreur)): ?>
                <div id="error-message"
                    class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg shadow-md mb-8 animate-fade-in-down"
                    role="alert">
                    <p class="flex items-center"><i class="fas fa-exclamation-triangle mr-3 text-lg"></i> <?= htmlspecialchars($messageErreur) ?></p>
                </div>
            <?php endif; ?>



            <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden">
                <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                    <div class="header-icon bg-gradient-to-br from-primary to-primary-dark text-white w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Gestion des ressources humaines</h1>
                        <p class="text-lg text-gray-600 font-normal">Gérez efficacement les membres du personnel</p>
                    </div>
                </div>
            </div>

            <header class="flex flex-col md:flex-row justify-between items-center mb-10 p-6 bg-white rounded-2xl shadow-lg animate-fade-in-down">
                <h1 class="text-4xl font-extrabold text-gray-900 flex items-ri mb-4 md:mb-0">
                    <i class="fas fa-users-gear text-primary mr-5 text-4xl"></i>

                </h1>
                <div class="flex space-x-3">
                    <a href="?page=gestion_rh&tab=pers_admin"
                        class="px-6 py-3 rounded-full text-base font-semibold transition-all duration-300 transform hover:scale-105 shadow-md flex items-center justify-center
                        <?= ($activeTab === 'pers_admin') ? 'tab-button-active' : 'tab-button-inactive' ?>">
                        <i class="fas fa-user-tie mr-3"></i> Personnel Administratif
                    </a>
                    <a href="?page=gestion_rh&tab=enseignant"
                        class="px-6 py-3 rounded-full text-base font-semibold transition-all duration-300 transform hover:scale-105 shadow-md flex items-center justify-center
                        <?= ($activeTab === 'enseignant') ? 'tab-button-active' : 'tab-button-inactive' ?>">
                        <i class="fas fa-chalkboard-teacher mr-3"></i> Enseignants
                    </a>
                </div>
            </header>

            <div>
                <?php if ($activeTab === 'pers_admin'): ?>
                    <!-- STAT CARDS -->
                    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-8 -mt-25 mb-12 px-2">
                        <div class="bg-gradient-to-br from-blue-100 to-blue-300 rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform">
                            <i class="fas fa-file-alt text-4xl text-blue-600 mb-2"></i>
                            <div class="text-3xl font-bold text-blue-800"><?php echo 0; ?></div>
                            <div class="text-blue-700 mt-1">Total Membre du personnel administratif</div>
                        </div>
                    </div>



                    <section id="tab_pers_admin" class="flex flex-col space-y-8">
                        <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-lg animate-fade-in-down" style="animation-delay: 0.1s;">
                            <h2 class="text-3xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-user-shield text-secondary mr-4 text-3xl"></i>
                                Liste du Personnel Administratif
                            </h2>
                            <a href="?page=gestion_rh&tab=pers_admin&action=add"
                                class="px-7 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary-dark transition-all duration-300 transform hover:scale-105 flex items-center shadow-lg">
                                <i class="fas fa-user-plus mr-3"></i> Ajouter un Agent
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4 animate-fade-in-down" style="animation-delay: 0.2s;">
                            <div class="relative w-full md:w-1/3">
                                <input type="text" id="searchInput" placeholder="Rechercher par nom, email..."
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-3 justify-center md:justify-end">
                                <button type="button" onclick="printTable('pers_admin')"
                                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-full hover:bg-blue-700 transition-all duration-200 shadow-md flex items-center">
                                    <i class="fas fa-print mr-3"></i> Imprimer
                                </button>
                                <button type="button" onclick="exportToExcel('pers_admin')"
                                    class="px-6 py-3 bg-orange-600 text-white font-medium rounded-full hover:bg-orange-700 transition-all duration-200 shadow-md flex items-center">
                                    <i class="fas fa-file-export mr-3"></i> Exporter
                                </button>
                                <button type="button" onclick="showDeleteModal('pers_admin')" id="deleteButtonPersAdmin"
                                    class="px-6 py-3 bg-red-600 text-white font-medium rounded-full hover:bg-red-700 transition-all duration-200 shadow-md flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-trash-alt mr-3"></i> Supprimer
                                </button>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-2xl shadow-lg overflow-hidden animate-fade-in-down" style="animation-delay: 0.3s;">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y-2 divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-5 py-3 text-center">
                                                <input type="checkbox" id="selectAllCheckbox"
                                                    class="form-checkbox h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Nom & Prénom</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Contact</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Poste</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Date d'Embauche</th>
                                            <th scope="col" class="px-6 py-3 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        <?php if (empty($personnel_admin)): ?>
                                            <tr>
                                                <td colspan="6" class="px-6 py-6 text-center text-gray-500 text-lg">
                                                    <i class="fas fa-box-open mr-3"></i> Aucun personnel administratif trouvé.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($personnel_admin as $admin): ?>
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-5 py-4 text-center">
                                                        <input type="checkbox" name="selected_ids[]"
                                                            value="<?= htmlspecialchars($admin->id_pers_admin) ?>"
                                                            class="form-checkbox h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-base font-medium text-gray-900"><?= htmlspecialchars($admin->prenom_pers_admin) ?> <?= htmlspecialchars($admin->nom_pers_admin) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-600 flex items-center mb-1"><i class="fas fa-envelope mr-2 text-primary"></i><?= htmlspecialchars($admin->email_pers_admin) ?></div>
                                                        <div class="text-sm text-gray-600 flex items-center"><i class="fas fa-phone mr-2 text-primary"></i><?= htmlspecialchars($admin->tel_pers_admin) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-700 font-medium">
                                                        <?= htmlspecialchars($admin->poste) ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-700">
                                                        <?= htmlspecialchars($admin->date_embauche) ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base">
                                                        <button onclick="showModifyModal('pers_admin', <?= $admin->id_pers_admin ?>); return false;"
                                                            class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition duration-200" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if ($activeTab === 'enseignant'): ?>
                    <!-- STAT CARDS -->
                    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-8 -mt-25 mb-12 px-2">
                        <div class="bg-gradient-to-br from-blue-100 to-blue-300 rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform">
                            <i class="fas fa-file-alt text-4xl text-blue-600 mb-2"></i>
                            <div class="text-3xl font-bold text-blue-800"><?php echo 0; ?></div>
                            <div class="text-blue-700 mt-1">Total Enseignants</div>
                        </div>
                    </div>
                    <section id="tab_enseignant" class="flex flex-col space-y-8">
                        <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-lg animate-fade-in-down" style="animation-delay: 0.1s;">
                            <h2 class="text-3xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-user-graduate text-secondary mr-4 text-3xl"></i>
                                Liste des Enseignants
                            </h2>
                            <a href="?page=gestion_rh&tab=enseignant&action=add"
                                class="px-7 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary-dark transition-all duration-300 transform hover:scale-105 flex items-center shadow-lg">
                                <i class="fas fa-user-plus mr-3"></i> Ajouter un Enseignant
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4 animate-fade-in-down" style="animation-delay: 0.2s;">
                            <div class="relative w-full md:w-1/3">
                                <input type="text" id="searchInputEnseignant" placeholder="Rechercher par nom, spécialité..."
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-3 justify-center md:justify-end">
                                <button type="button" onclick="printTable('enseignant')"
                                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-full hover:bg-blue-700 transition-all duration-200 shadow-md flex items-center">
                                    <i class="fas fa-print mr-3"></i> Imprimer
                                </button>
                                <button type="button" onclick="exportToExcel('enseignant')"
                                    class="px-6 py-3 bg-orange-600 text-white font-medium rounded-full hover:bg-orange-700 transition-all duration-200 shadow-md flex items-center">
                                    <i class="fas fa-file-export mr-3"></i> Exporter
                                </button>
                                <button type="button" onclick="showDeleteModal('enseignant')" id="deleteButtonEnseignant"
                                    class="px-6 py-3 bg-red-600 text-white font-medium rounded-full hover:bg-red-700 transition-all duration-200 shadow-md flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-trash-alt mr-3"></i> Supprimer
                                </button>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-2xl shadow-lg overflow-hidden animate-fade-in-down" style="animation-delay: 0.3s;">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y-2 divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-5 py-3 text-center">
                                                <input type="checkbox" id="selectAllCheckboxEnseignant"
                                                    class="form-checkbox h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Nom & Prénom</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Contact</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Spécialité</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Fonction & Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Grade & Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Type d'Enseignant</th>
                                            <th scope="col" class="px-6 py-3 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        <?php if (empty($enseignants)): ?>
                                            <tr>
                                                <td colspan="8" class="px-6 py-6 text-center text-gray-500 text-lg">
                                                    <i class="fas fa-box-open mr-3"></i> Aucun enseignant trouvé.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($enseignants as $enseignant): ?>
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-5 py-4 text-center">
                                                        <input type="checkbox" name="selected_ids[]"
                                                            value="<?= htmlspecialchars($enseignant->id_enseignant) ?>"
                                                            class="user-checkbox form-checkbox h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-base font-medium text-gray-900"><?= htmlspecialchars($enseignant->prenom_enseignant) ?> <?= htmlspecialchars($enseignant->nom_enseignant) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-600 flex items-center"><i class="fas fa-envelope mr-2 text-primary"></i><?= htmlspecialchars($enseignant->mail_enseignant) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-700 font-medium">
                                                        <?= htmlspecialchars($enseignant->lib_specialite) ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-base text-gray-700 font-medium"><?= htmlspecialchars($enseignant->lib_fonction) ?></div>
                                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($enseignant->date_occupation) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-base text-gray-700 font-medium"><?= htmlspecialchars($enseignant->lib_grade) ?></div>
                                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($enseignant->date_grade) ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                <?= ($enseignant->type_enseignant === 'Administratif') ? 'bg-accent/10 text-accent' : 'bg-blue-100 text-blue-800' ?>">
                                                            <?= htmlspecialchars($enseignant->type_enseignant) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center text-base">
                                                        <button onclick="showModifyModal('enseignant', <?= $enseignant->id_enseignant ?>); return false;"
                                                            class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition duration-200" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php if ($action === 'add' || ($action === 'edit' && $activeTab === 'pers_admin')): ?>
        <div class="modal-overlay" id="modal-admin" style="display: flex;">
            <div class="modal-container">
                <button type="button" class="modal-close-btn" onclick="window.location.href='?page=gestion_rh&tab=pers_admin'">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-3xl font-bold text-primary mb-8 border-b-2 pb-4 border-primary/20 flex items-center">
                    <i class="fas fa-user-plus mr-4 text-3xl"></i>
                    <?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? 'Modifier le Personnel Administratif' : 'Ajouter un Nouveau Personnel' ?>
                </h3>

                <form action="?page=gestion_rh&tab=pers_admin" method="POST" class="space-y-6">
                    <?php if ($action === 'edit' && isset($pers_admin_a_modifier)): ?>
                        <input type="hidden" name="id_pers_admin" value="<?= htmlspecialchars($pers_admin_a_modifier->id_pers_admin) ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
                            <input type="text" name="nom" id="nom"
                                value="<?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? htmlspecialchars($pers_admin_a_modifier->nom_pers_admin) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                        <div>
                            <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" id="prenom"
                                value="<?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? htmlspecialchars($pers_admin_a_modifier->prenom_pers_admin) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email"
                                value="<?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? htmlspecialchars($pers_admin_a_modifier->email_pers_admin) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                        <div>
                            <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" name="telephone" id="telephone"
                                value="<?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? htmlspecialchars($pers_admin_a_modifier->tel_pers_admin) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="poste" class="block text-sm font-semibold text-gray-700 mb-2">Poste</label>
                            <input type="text" name="poste" id="poste"
                                value="<?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? htmlspecialchars($pers_admin_a_modifier->poste) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                        <div>
                            <label for="date_embauche" class="block text-sm font-semibold text-gray-700 mb-2">Date d'embauche</label>
                            <input type="date" name="date_embauche" id="date_embauche"
                                value="<?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? htmlspecialchars($pers_admin_a_modifier->date_embauche) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" onclick="window.location.href='?page=gestion_rh&tab=pers_admin'"
                            class="px-8 py-3 bg-gray-200 text-gray-800 font-bold rounded-full hover:bg-gray-300 transition-colors duration-200 shadow-md">
                            Annuler
                        </button>
                        <button type="submit"
                            name="<?= ($action === 'edit') ? 'btn_modifier_pers_admin' : 'btn_add_pers_admin' ?>"
                            class="px-8 py-3 bg-primary text-white font-bold rounded-full hover:bg-primary-dark transition-colors duration-200 shadow-md">
                            <?= ($action === 'edit' && isset($pers_admin_a_modifier)) ? 'Modifier' : 'Enregistrer' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($action === 'add' || ($action === 'edit' && $activeTab === 'enseignant')): ?>
        <div class="modal-overlay" id="modal-enseignant" style="display: flex;">
            <div class="modal-container">
                <button type="button" class="modal-close-btn" onclick="window.location.href='?page=gestion_rh&tab=enseignant'">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-3xl font-bold text-primary mb-8 border-b-2 pb-4 border-primary/20 flex items-center">
                    <i class="fas fa-user-plus mr-4 text-3xl"></i>
                    <?= ($action === 'edit' && isset($enseignant_a_modifier)) ? 'Modifier l\'Enseignant' : 'Ajouter un Nouvel Enseignant' ?>
                </h3>

                <form action="?page=gestion_rh&tab=enseignant" method="POST" class="space-y-6">
                    <?php if ($action === 'edit' && isset($enseignant_a_modifier)): ?>
                        <input type="hidden" name="id_enseignant" value="<?= htmlspecialchars($enseignant_a_modifier->id_enseignant) ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom_enseignant" class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
                            <input type="text" name="nom" id="nom_enseignant"
                                value="<?= ($action === 'edit' && isset($enseignant_a_modifier)) ? htmlspecialchars($enseignant_a_modifier->nom_enseignant) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                        <div>
                            <label for="prenom_enseignant" class="block text-sm font-semibold text-gray-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" id="prenom_enseignant"
                                value="<?= ($action === 'edit' && isset($enseignant_a_modifier)) ? htmlspecialchars($enseignant_a_modifier->prenom_enseignant) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email_enseignant" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email_enseignant"
                                value="<?= ($action === 'edit' && isset($enseignant_a_modifier)) ? htmlspecialchars($enseignant_a_modifier->mail_enseignant) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                        <div>
                            <label for="specialite" class="block text-sm font-semibold text-gray-700 mb-2">Spécialité</label>
                            <select name="id_specialite" id="specialite" required
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base">
                                <?php foreach ($listeSpecialites as $specialite): ?>
                                    <option value="<?= htmlspecialchars($specialite->id_specialite) ?>"
                                        <?= ($action === 'edit' && isset($enseignant_a_modifier) && $enseignant_a_modifier->id_specialite == $specialite->id_specialite) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($specialite->lib_specialite) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="fonction" class="block text-sm font-semibold text-gray-700 mb-2">Fonction</label>
                            <select name="id_fonction" id="fonction" required
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base">
                                <?php foreach ($listeFonctions as $fonction): ?>
                                    <option value="<?= htmlspecialchars($fonction->id_fonction) ?>"
                                        <?= ($action === 'edit' && isset($enseignant_a_modifier) && $enseignant_a_modifier->id_fonction == $fonction->id_fonction) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($fonction->lib_fonction) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="date_fonction" class="block text-sm font-semibold text-gray-700 mb-2">Date d'Occupation Fonction</label>
                            <input type="date" name="date_fonction" id="date_fonction"
                                value="<?= ($action === 'edit' && isset($enseignant_a_modifier)) ? htmlspecialchars($enseignant_a_modifier->date_occupation) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="grade" class="block text-sm font-semibold text-gray-700 mb-2">Grade</label>
                            <select name="id_grade" id="grade" required
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base">
                                <?php foreach ($listeGrades as $grade): ?>
                                    <option value="<?= htmlspecialchars($grade->id_grade) ?>"
                                        <?= ($action === 'edit' && isset($enseignant_a_modifier) && $enseignant_a_modifier->id_grade == $grade->id_grade) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($grade->lib_grade) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="date_grade" class="block text-sm font-semibold text-gray-700 mb-2">Date d'Obtention Grade</label>
                            <input type="date" name="date_grade" id="date_grade"
                                value="<?= ($action === 'edit' && isset($enseignant_a_modifier)) ? htmlspecialchars($enseignant_a_modifier->date_grade) : '' ?>"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 text-base"
                                required>
                        </div>
                    </div>
                    <div>
                        <label for="type_enseignant" class="block text-sm font-semibold text-gray-700 mb-2">Type d'Enseignant</label>
                        <select name="type_enseignant" id="type_enseignant" required
                            class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-secondary focus:border-secondary transition-all duration-200 text-base">
                            <option value="Simple"
                                <?php echo ($enseignant_a_modifier && $enseignant_a_modifier->type_enseignant === 'Simple') ? 'selected' : ''; ?>>
                                Simple</option>
                            <option value="Administratif"
                                <?php echo ($enseignant_a_modifier && $enseignant_a_modifier->type_enseignant === 'Administratif') ? 'selected' : ''; ?>>
                                Administratif</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" onclick="window.location.href='?page=gestion_rh&tab=enseignant'"
                            class="px-8 py-3 bg-gray-200 text-gray-800 font-bold rounded-full hover:bg-gray-300 transition-colors duration-200 shadow-md">
                            Annuler
                        </button>
                        <button type="submit"
                            name="<?= ($action === 'edit') ? 'btn_modifier_enseignant' : 'btn_add_enseignant' ?>"
                            class="px-8 py-3 bg-primary text-white font-bold rounded-full hover:bg-primary-dark transition-colors duration-200 shadow-md">
                            <?= ($action === 'edit' && isset($enseignant_a_modifier)) ? 'Modifier' : 'Ajouter' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div id="deleteModal" class="modal-overlay">
        <div class="modal-container">
            <button type="button" class="modal-close-btn" id="cancelDelete">
                <i class="fas fa-times"></i>
            </button>
            <div class="text-center p-4">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                    <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Confirmation de Suppression</h3>
                <p class="text-lg text-gray-600 mb-8">
                    Êtes-vous sûr de vouloir supprimer les éléments sélectionnés ? Cette action est irréversible.
                </p>
                <div class="flex justify-center gap-4">
                    <button type="button" id="confirmDelete"
                        class="px-8 py-3 bg-red-600 text-white font-bold rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                        <i class="fas fa-check mr-3"></i> Confirmer
                    </button>
                    <button type="button" id="cancelDeleteButton"
                        class="px-8 py-3 bg-gray-200 text-gray-800 font-bold rounded-full hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-md">
                        <i class="fas fa-times mr-3"></i> Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="delete-form" method="POST" style="display: none;">
        <input type="hidden" name="selected_ids[]" id="delete_id">
        <input type="hidden" name="delete_type" id="delete_type_input">
    </form>

</body>
<script>
    // Variables globales pour les formulaires et les boutons
    // Note: Re-selecting forms for robustness as per previous fix, closest('form') for accuracy.
    const formListePersAdmin = document.querySelector('#tab_pers_admin table').closest('form');
    const formListeEnseignant = document.querySelector('#tab_enseignant table').closest('form');

    // Variables pour le personnel administratif
    const selectAllCheckboxPersAdmin = document.getElementById('selectAllCheckbox');
    const deleteButtonPersAdmin = document.getElementById('deleteButtonPersAdmin');
    const submitDeletePersHidden = document.getElementById('submitDeletePersHidden');

    // Variables pour les enseignants
    const selectAllCheckboxEnseignant = document.getElementById('selectAllCheckboxEnseignant');
    const deleteButtonEnseignant = document.getElementById('deleteButtonEnseignant');
    const submitDeleteHidden = document.getElementById('submitDeleteHidden');

    // Variables pour les modales
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDeleteButton'); // Corrected ID

    // Track which type (pers_admin or enseignant) delete modal was opened for
    let currentDeleteType = '';

    // Initialisation des checkboxes et de l'état des boutons
    function initializeCheckboxes(selectAllCheckboxElem, deleteButtonElem, formElem) {
        if (selectAllCheckboxElem && deleteButtonElem && formElem) {
            selectAllCheckboxElem.addEventListener('change', function() {
                const checkboxes = formElem.querySelectorAll('input[name="selected_ids[]"]');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                updateDeleteButtonState(deleteButtonElem, formElem);
            });

            formElem.addEventListener('change', function(e) {
                if (e.target.name === 'selected_ids[]') {
                    updateDeleteButtonState(deleteButtonElem, formElem);
                    const allCheckboxes = formElem.querySelectorAll('input[name="selected_ids[]"]');
                    const checkedBoxes = formElem.querySelectorAll('input[name="selected_ids[]"]:checked');
                    selectAllCheckboxElem.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length > 0;
                }
            });
        }
    }

    // Mise à jour de l'état du bouton de suppression
    function updateDeleteButtonState(deleteBtn, form) {
        if (deleteBtn && form) {
            const checkedBoxes = form.querySelectorAll('input[name="selected_ids[]"]:checked');
            deleteBtn.disabled = checkedBoxes.length === 0;
        }
    }

    // Initialisation des deux sections au chargement du DOM
    document.addEventListener('DOMContentLoaded', () => {
        // Initialisation pour Personnel Administratif
        if (selectAllCheckboxPersAdmin && deleteButtonPersAdmin && formListePersAdmin) {
            initializeCheckboxes(selectAllCheckboxPersAdmin, deleteButtonPersAdmin, formListePersAdmin);
            updateDeleteButtonState(deleteButtonPersAdmin, formListePersAdmin);
        }

        // Initialisation pour Enseignants
        if (selectAllCheckboxEnseignant && deleteButtonEnseignant && formListeEnseignant) {
            initializeCheckboxes(selectAllCheckboxEnseignant, deleteButtonEnseignant, formListeEnseignant);
            updateDeleteButtonState(deleteButtonEnseignant, formListeEnseignant);
        }

        // Display modal if action is 'add' or 'edit'
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get('action');
        const tab = urlParams.get('tab');

        if (action === 'add' || action === 'edit') {
            if (tab === 'pers_admin') {
                const modalAdmin = document.getElementById('modal-admin');
                if (modalAdmin) modalAdmin.style.display = 'flex';
            } else if (tab === 'enseignant') {
                const modalEnseignant = document.getElementById('modal-enseignant');
                if (modalEnseignant) modalEnseignant.style.display = 'flex';
            }
        }
    });

    // Gestion de la modale de suppression
    function showDeleteModal(type) {
        currentDeleteType = type; // Set the type for deletion
        const form = type === 'pers_admin' ? formListePersAdmin : formListeEnseignant;
        const checkboxes = form.querySelectorAll('input[name="selected_ids[]"]:checked');

        if (checkboxes.length === 0) {
            alert('Veuillez sélectionner au moins un élément à supprimer');
            return;
        }

        deleteModal.style.display = 'flex';
    }

    // Gestion de la suppression confirmée
    if (confirmDelete) {
        confirmDelete.addEventListener('click', function() {
            const form = currentDeleteType === 'pers_admin' ? formListePersAdmin : formListeEnseignant;

            if (form) {
                // Ensure the correct hidden input for submission is used
                const submitHiddenInput = currentDeleteType === 'pers_admin' ? submitDeletePersHidden : submitDeleteHidden;
                if (submitHiddenInput) {
                    submitHiddenInput.value = '1';
                }

                // Create a temporary form to submit only the checked items for the current type
                const tempForm = document.createElement('form');
                tempForm.method = 'POST';
                tempForm.action = `?page=gestion_rh&tab=${currentDeleteType}`; // Ensure correct tab is targeted

                const selectedCheckboxes = form.querySelectorAll('input[name="selected_ids[]"]:checked');
                selectedCheckboxes.forEach(checkbox => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'selected_ids[]';
                    hiddenInput.value = checkbox.value;
                    tempForm.appendChild(hiddenInput);
                });

                // Add a hidden input to signify this is a multiple deletion request
                const deleteActionInput = document.createElement('input');
                deleteActionInput.type = 'hidden';
                deleteActionInput.name = 'submit_delete_multiple';
                deleteActionInput.value = '1';
                tempForm.appendChild(deleteActionInput);

                document.body.appendChild(tempForm);
                tempForm.submit();
            }
            deleteModal.style.display = 'none';
        });
    }

    // Gestion de l'annulation de suppression
    if (cancelDelete) {
        cancelDelete.addEventListener('click', function() {
            deleteModal.style.display = 'none';
        });
    }

    // Gestion de la modale de modification (direct redirection as per previous logic)
    function showModifyModal(type, id) {
        window.location.href = `?page=gestion_rh&tab=${type}&action=edit&id_${type}=${id}`;
    }

    // Fermer les modales si on clique en dehors
    window.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
        const modalAdmin = document.getElementById('modal-admin');
        const modalEnseignant = document.getElementById('modal-enseignant');

        if (modalAdmin && e.target === modalAdmin) {
            modalAdmin.style.display = 'none';
            window.location.href = '?page=gestion_rh&tab=pers_admin';
        }
        if (modalEnseignant && e.target === modalEnseignant) {
            modalEnseignant.style.display = 'none';
            window.location.href = '?page=gestion_rh&tab=enseignant';
        }
    });

    // Fonction pour exporter vers Excel
    function exportToExcel(type) {
        const table = document.querySelector(`#tab_${type} table`);
        const rows = Array.from(table.querySelectorAll('tr'));

        let csvContent = "data:text/csv;charset=utf-8,";

        const headers = Array.from(rows[0].querySelectorAll('th'))
            .filter(th => th.textContent.trim() !== '' && th.textContent.trim().toLowerCase() !== 'actions') // Filter out checkbox and actions
            .map(th => th.textContent.trim());
        csvContent += headers.join(',') + '\n';

        rows.slice(1).forEach(row => {
            const cells = Array.from(row.querySelectorAll('td'))
                .filter((td, index) => {
                    // Filter out the first column (checkbox) and the last (actions)
                    const headerCells = Array.from(row.closest('table').querySelectorAll('thead th'));
                    return index > 0 && index < headerCells.length - 1;
                })
                .map(td => `"${td.textContent.trim().replace(/"/g, '""')}"`); // Handle commas and quotes
            csvContent += cells.join(',') + '\n';
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `${type === 'pers_admin' ? 'personnel_administratif' : 'enseignants'}_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }


    // Fonction pour imprimer
    function printTable(type) {
        const printWindow = window.open('', '_blank');
        const table = document.querySelector(`#tab_${type} table`);

        const content = `
            <html>
            <head>
                <title>Impression - ${type === 'pers_admin' ? 'Personnel Administratif' : 'Enseignants'}</title>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 20px; color: #333; }
                    table { width: 100%; border-collapse: collapse; margin: 25px 0; font-size: 14px; }
                    th, td { border: 1px solid #e0e0e0; padding: 12px 15px; text-align: left; }
                    th { background-color: #f5f5f5; font-weight: bold; }
                    tr:nth-child(even) { background-color: #f9f9f9; }
                    h1 { text-align: center; color: #157A6E; margin-bottom: 40px; font-size: 28px; }
                    .header-logo { display: block; margin: 0 auto 20px auto; max-width: 150px; }
                    @media print {
                        body { margin: 0; padding: 20px; }
                        table { page-break-inside: auto; }
                        tr { page-break-inside: avoid; page-break-after: auto; }
                    }
                </style>
            </head>
            <body>
                <img src="./images/logo.png" alt="Logo Université" class="header-logo">
                <h1>${type === 'pers_admin' ? 'Liste du Personnel Administratif' : 'Liste des Enseignants'}</h1>
                <table>
                    <thead>
                        <tr>
                            ${Array.from(table.querySelectorAll('thead th'))
                                .filter(th => th.textContent.trim() !== '' && th.textContent.trim().toLowerCase() !== 'actions')
                                .map(th => `<th>${th.textContent}</th>`).join('')}
                        </tr>
                    </thead>
                    <tbody>
                        ${Array.from(table.querySelectorAll('tbody tr')).map(row => `
                            <tr>
                                ${Array.from(row.querySelectorAll('td'))
                                    .filter((td, index) => {
                                        const headerCells = Array.from(table.querySelectorAll('thead th'));
                                        return index > 0 && index < headerCells.length -1;
                                    })
                                    .map(td => `<td>${td.innerHTML}</td>`).join('')
    } <
    /tr>
    `).join('')}
                    </tbody>
                </table>
            </body>
            </html>
        `;

    printWindow.document.write(content);
    printWindow.document.close();
    printWindow.focus();

    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
    }

    // Gestion des messages temporisés
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        function hideMessage(element) {
            if (element) {
                element.style.transition = 'opacity 0.5s ease-out';
                element.style.opacity = '0';
                setTimeout(() => {
                    element.style.display = 'none';
                }, 500);
            }
        }

        if (successMessage) {
            setTimeout(() => hideMessage(successMessage), 4000); // 4 seconds for success
        }
        if (errorMessage) {
            setTimeout(() => hideMessage(errorMessage), 5000); // 5 seconds for error
        }
    });

    // Fonction de recherche
    function searchTable(inputId, type) {
        const input = document.getElementById(inputId);
        const table = document.querySelector(`#tab_${type} table`);
        const filter = input.value.toUpperCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = Array.from(row.querySelectorAll('td')).slice(1, -1); // Exclude checkbox and actions
            let found = false;

            for (let i = 0; i < cells.length; i++) {
                const text = cells[i].textContent || cells[i].innerText;
                if (text.toUpperCase().includes(filter)) {
                    found = true;
                    break;
                }
            }
            row.style.display = found ? "" : "none";
        });

        // Update checkbox states after search
        const selectAllCheckbox = document.getElementById(type === 'pers_admin' ? 'selectAllCheckbox' : 'selectAllCheckboxEnseignant');
        const deleteButton = document.getElementById(type === 'pers_admin' ? 'deleteButtonPersAdmin' : 'deleteButtonEnseignant');
        const form = type === 'pers_admin' ? formListePersAdmin : formListeEnseignant;

        if (selectAllCheckbox && deleteButton && form) {
            const visibleRows = Array.from(form.querySelectorAll('tbody tr')).filter(row => row.style.display !== 'none');
            const visibleCheckboxes = visibleRows.map(row => row.querySelector('input[name="selected_ids[]"]')).filter(checkbox => checkbox !== null);
            const checkedVisibleBoxes = visibleCheckboxes.filter(checkbox => checkbox.checked);

            selectAllCheckbox.checked = (visibleCheckboxes.length > 0 && checkedVisibleBoxes.length === visibleCheckboxes.length);
            deleteButton.disabled = checkedVisibleBoxes.length === 0;
        }
    }

    // Listeners for search inputs
    document.addEventListener('DOMContentLoaded', function() {
        const searchInputPersAdmin = document.getElementById('searchInput');
        const searchInputEnseignant = document.getElementById('searchInputEnseignant');

        if (searchInputPersAdmin) {
            searchInputPersAdmin.addEventListener('keyup', function() {
                searchTable('searchInput', 'pers_admin');
            });
        }
        if (searchInputEnseignant) {
            searchInputEnseignant.addEventListener('keyup', function() {
                searchTable('searchInputEnseignant', 'enseignant');
            });
        }
    });
</script>

</html>