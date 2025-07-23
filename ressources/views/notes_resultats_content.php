<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
// Récupération des données depuis le contrôleur
$etudiant = $GLOBALS['etudiant'] ?? null;
$moyenneGenerale = $GLOBALS['moyenneGenerale'] ?? null;
$nbUeValide = $GLOBALS['nbUeValide'] ?? 0;
$classement = $GLOBALS['classement'] ?? null;
$totalEtudiants = $GLOBALS['totalEtudiants'] ?? 0;
$notes = $GLOBALS['notes'] ?? [];
$semestres = $GLOBALS['semestres'] ?? [];

// Création d'un objet étudiant par défaut pour éviter les erreurs si null
if (!$etudiant) {
    $etudiant = new stdClass();
    $etudiant->nom_etu = 'N/A';
    $etudiant->prenom_etu = '';
    $etudiant->num_etu = 'N/A';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Résultats | Univalid</title>
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
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1);
        }

        .form-select {
            padding: 12px 16px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-right: 48px;
        }

        .form-select:focus {
            outline: none;
            border-color: #3457cb;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 87, 203, 0.1);
        }

        .grade-badge {
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

        .grade-A {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .grade-B {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border: 1px solid #22c55e;
        }

        .grade-C {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .grade-D {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: #9a3412;
            border: 1px solid #ea580c;
        }

        .grade-F {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #ef4444;
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
            transform: scale(1.005);
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3457cb 0%, #24407a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                <div class="student-avatar">
                    <?= strtoupper(substr($etudiant->nom_etu, 0, 1) . substr($etudiant->prenom_etu, 0, 1)) ?>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Mon Portail Académique</h1>
                    <p class="text-lg text-gray-600 font-normal">
                        <?= htmlspecialchars($etudiant->nom_etu . ' ' . $etudiant->prenom_etu); ?> — N° <?= htmlspecialchars($etudiant->num_etu); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.1s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-primary mb-1"><?= $moyenneGenerale !== null ? number_format($moyenneGenerale, 2) : 'N/A' ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Moyenne Générale</p>
                        <p class="text-xs text-blue-600 font-medium">
                            <i class="fas fa-chart-line mr-1"></i>Sur 20
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.2s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-secondary mb-1"><?= $nbUeValide; ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Modules Validés</p>
                        <p class="text-xs text-green-600 font-medium">
                            <i class="fas fa-trophy mr-1"></i>Réussis
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.3s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-warning/10 text-warning rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-warning mb-1"><?= $classement !== null ? $classement . ' / ' . $totalEtudiants : 'N/A'; ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Classement</p>
                        <p class="text-xs text-orange-600 font-medium">
                            <i class="fas fa-users mr-1"></i>Promotion
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card animate-scale-in">
            <!-- Header with controls -->
            <div class="table-header">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Bulletin de Notes</h2>
                        <p class="text-gray-600">Consultez l'ensemble de vos résultats par semestre</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <select id="semesterFilter" class="form-select min-w-[200px]">
                            <option value="all">Tous les semestres</option>
                            <?php if (!empty($semestres)): foreach ($semestres as $semestre): ?>
                                <option value="<?= htmlspecialchars($semestre->lib_semestre); ?>">
                                    <?= htmlspecialchars($semestre->lib_semestre); ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <button id="printBtn" class="btn" title="Imprimer">
                            <i class="fas fa-print"></i>
                            <span>Imprimer</span>
                        </button>
                        <button id="pdfBtn" class="btn" title="Exporter en PDF">
                            <i class="fas fa-file-pdf"></i>
                            <span>PDF</span>
                        </button>
                        <button id="exportBtn" class="btn" title="Exporter en CSV">
                            <i class="fas fa-file-csv"></i>
                            <span>CSV</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full" id="gradesTable">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">📚 Module</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">⭐ Crédits</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">📊 Note</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">💬 Appréciation</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 uppercase tracking-wider">📅 Semestre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($notes)): foreach ($notes as $note): ?>
                            <tr class="table-row">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-primary rounded-full mr-3"></div>
                                        <span class="font-semibold text-gray-900"><?= htmlspecialchars($note->lib_ue); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-star mr-2 text-yellow-500"></i>
                                        <?= htmlspecialchars($note->credit); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="grade-badge grade-<?= $note->moyenne >= 16 ? 'A' : ($note->moyenne >= 14 ? 'B' : ($note->moyenne >= 12 ? 'C' : ($note->moyenne >= 10 ? 'D' : 'F'))); ?>">
                                        <i class="fas fa-<?= $note->moyenne >= 16 ? 'medal' : ($note->moyenne >= 14 ? 'trophy' : ($note->moyenne >= 12 ? 'thumbs-up' : ($note->moyenne >= 10 ? 'check' : 'times'))); ?>"></i>
                                        <?= htmlspecialchars($note->moyenne); ?>/20
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700 font-medium"><?= htmlspecialchars($note->commentaire); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <?= htmlspecialchars($note->lib_semestre ?? 'N/A'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-16">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-chart-bar text-3xl text-gray-400"></i>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-500 mb-2">Aucune note disponible</p>
                                        <p class="text-sm text-gray-400">Les notes apparaîtront ici une fois saisies</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const semesterFilter = document.getElementById('semesterFilter');
            const printBtn = document.getElementById('printBtn');
            const pdfBtn = document.getElementById('pdfBtn');
            const exportBtn = document.getElementById('exportBtn');
            
            // Filtrage par semestre
            if (semesterFilter) {
                semesterFilter.addEventListener('change', function() {
                    const selectedSemester = this.value;
                    const rows = document.querySelectorAll('#gradesTable tbody tr');

                    rows.forEach(row => {
                        // S'assurer qu'on ne cible pas la ligne "Aucune note"
                        if (row.querySelectorAll('td').length > 1) {
                            const semesterCell = row.querySelector('td:last-child');
                            if (selectedSemester === 'all' || semesterCell.textContent.trim().includes(selectedSemester)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                });
            }

            // Bouton Imprimer
            if (printBtn) {
                printBtn.addEventListener('click', () => window.print());
            }

            // Bouton PDF (redirige vers l'action du contrôleur)
            if (pdfBtn) {
                pdfBtn.addEventListener('click', () => window.location.href = '?page=resultats&action=export_pdf');
            }

            // Bouton Exporter CSV
            if (exportBtn) {
                exportBtn.addEventListener('click', exportCSV);
            }

            // Animation des cartes
            const cards = document.querySelectorAll('.stat-card, .card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        function exportCSV() {
            const table = document.getElementById('gradesTable');
            if (!table) return;
            
            let csv = [];
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => `"${th.textContent.trim()}"`);
            csv.push(headers.join(';'));

            const visibleRows = table.querySelectorAll('tbody tr');
            visibleRows.forEach(row => {
                if (row.style.display !== 'none' && row.querySelectorAll('td').length > 1) {
                    const cells = Array.from(row.querySelectorAll('td'));
                    const rowData = cells.map(td => `"${td.textContent.trim().replace(/"/g, '""')}"`);
                    csv.push(rowData.join(';'));
                }
            });

            const csvContent = '\uFEFF' + csv.join('\n'); // \uFEFF pour l'encodage UTF-8 BOM
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'bulletin-notes.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>

</html>