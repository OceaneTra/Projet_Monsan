<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Rendu de Soutenance | Univalid</title>
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

        .status-badge {
            padding: 8px 20px;
            border-radius: 24px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .status-accepte {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 2px solid #10b981;
        }

        .status-refuse {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 2px solid #ef4444;
        }

        .status-en-attente {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 2px solid #f59e0b;
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: #f1f5f9;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            border-radius: 6px;
            transition: width 0.8s ease;
            position: relative;
        }

        .progress-fill.technique {
            background: linear-gradient(90deg, #3457cb 0%, #60a5fa 100%);
        }

        .progress-fill.presentation {
            background: linear-gradient(90deg, #36865a 0%, #59bf3d 100%);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            color: #64748b;
            font-size: 14px;
        }

        .breadcrumb a {
            color: #3457cb;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb a:hover {
            color: #24407a;
            text-decoration: underline;
        }

        .breadcrumb .separator {
            color: #cbd5e1;
        }

        .section-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb animate-fade-in-down">
            <a href="?page=candidature_soutenance">
                <i class="fas fa-arrow-left mr-2"></i>
                Candidature à la soutenance
            </a>
            <span class="separator">
                <i class="fas fa-chevron-right"></i>
            </span>
            <span class="text-gray-900 font-medium">Compte rendu</span>
        </div>

        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                <div class="header-icon bg-gradient-to-br from-secondary to-secondary-light text-white w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Compte Rendu de Soutenance</h1>
                    <p class="text-lg text-gray-600 font-normal">Résultats et évaluation de votre présentation</p>
                </div>
            </div>
        </div>

        <div class="space-y-6 animate-scale-in">
            <!-- Statut de la candidature -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon bg-primary/10 text-primary">
                        <i class="fas fa-flag"></i>
                    </div>
                    <span>Statut de la candidature</span>
                </div>
                <div class="flex items-center">
                    <span class="status-badge <?php 
                        echo $compte_rendu['statut'] === 'accepté' ? 'status-accepte' : 
                            ($compte_rendu['statut'] === 'refusé' ? 'status-refuse' : 'status-en-attente'); 
                    ?>">
                        <i class="fas fa-<?php 
                            echo $compte_rendu['statut'] === 'accepté' ? 'check-circle' : 
                                ($compte_rendu['statut'] === 'refusé' ? 'times-circle' : 'clock'); 
                        ?>"></i>
                        <?php echo ucfirst($compte_rendu['statut']); ?>
                    </span>
                </div>
            </div>

            <!-- Date de la soutenance -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon bg-accent/10 text-accent">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span>Date de la soutenance</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-calendar text-accent"></i>
                    <span class="text-lg font-semibold text-gray-700">
                        <?php echo date('d/m/Y', strtotime($compte_rendu['date_soutenance'])); ?>
                    </span>
                </div>
            </div>

            <!-- Évaluation technique -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon bg-primary/10 text-primary">
                        <i class="fas fa-code"></i>
                    </div>
                    <span>Évaluation technique</span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-medium">Qualité du travail</span>
                        <span class="text-2xl font-bold text-primary"><?php echo $compte_rendu['note_technique']; ?>/20</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill technique" 
                             style="width: <?php echo ($compte_rendu['note_technique']/20)*100; ?>%"></div>
                    </div>
                    <div class="text-sm text-gray-600">
                        Note obtenue : <?php echo $compte_rendu['note_technique']; ?> points sur 20
                    </div>
                </div>
            </div>

            <!-- Évaluation de la présentation -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon bg-secondary/10 text-secondary">
                        <i class="fas fa-presentation"></i>
                    </div>
                    <span>Évaluation de la présentation</span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-medium">Qualité de la présentation</span>
                        <span class="text-2xl font-bold text-secondary"><?php echo $compte_rendu['note_presentation']; ?>/20</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill presentation" 
                             style="width: <?php echo ($compte_rendu['note_presentation']/20)*100; ?>%"></div>
                    </div>
                    <div class="text-sm text-gray-600">
                        Note obtenue : <?php echo $compte_rendu['note_presentation']; ?> points sur 20
                    </div>
                </div>
            </div>

            <!-- Note globale -->
            <div class="card p-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-accent to-orange-400 text-white rounded-full text-3xl font-bold mb-4 shadow-lg">
                        <?php 
                        $note_globale = ($compte_rendu['note_technique'] + $compte_rendu['note_presentation']) / 2;
                        echo number_format($note_globale, 1);
                        ?>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Note Globale</h3>
                    <p class="text-gray-600">Moyenne des évaluations technique et présentation</p>
                </div>
            </div>

            <!-- Commentaires -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon bg-purple-100 text-purple-600">
                        <i class="fas fa-comments"></i>
                    </div>
                    <span>Commentaires du jury</span>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-purple-400">
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line m-0">
                            <?php echo nl2br(htmlspecialchars($compte_rendu['commentaires'])); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <a href="?page=candidature_soutenance" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300 gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
                <button onclick="window.print()" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-primary-light hover:from-primary-light hover:to-primary text-white font-semibold rounded-xl transition-all duration-300 gap-2 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-print"></i>
                    <span>Imprimer</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes
            const cards = document.querySelectorAll('.section-card, .card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate-slide-in-right');
            });

            // Animation des barres de progression
            setTimeout(() => {
                const progressBars = document.querySelectorAll('.progress-fill');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 500);
                });
            }, 800);
        });
    </script>
</body>

</html>