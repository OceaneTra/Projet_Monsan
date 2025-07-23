<?php
// Récupération des données depuis le contrôleur
$cardPGeneraux = $GLOBALS['cardPGeneraux'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres Généraux | Univalid</title>
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
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
            transform: translateY(-8px);
            box-shadow: 0 20px 48px rgba(15, 23, 42, 0.15);
        }

        .param-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            transition: all 0.4s ease;
            overflow: hidden;
            position: relative;
            height: 100%;
        }

        .param-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3457cb 0%, #36865a 50%, #59bf3d 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .param-card:hover::before {
            opacity: 1;
        }

        .param-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 48px rgba(15, 23, 42, 0.15);
        }

        .param-card:hover .param-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 24px rgba(52, 87, 203, 0.3);
        }

        .param-icon {
            transition: all 0.4s ease;
            position: relative;
            z-index: 10;
        }

        .param-icon::before {
            content: '';
            position: absolute;
            inset: -4px;
            background: linear-gradient(135deg, rgba(52, 87, 203, 0.1), rgba(54, 134, 90, 0.1));
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .param-card:hover .param-icon::before {
            opacity: 1;
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

        .btn-accent {
            background: linear-gradient(135deg, #F6C700 0%, #e6b800 100%);
            color: #1a1a1a;
            box-shadow: 0 4px 12px rgba(246, 199, 0, 0.3);
            font-weight: 700;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(246, 199, 0, 0.4);
            background: linear-gradient(135deg, #e6b800 0%, #d4a500 100%);
        }

        .progress-bar {
            height: 6px;
            background: #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3457cb 0%, #36865a 100%);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
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

        .header-gradient {
            background: linear-gradient(135deg, #24407a 0%, #3457cb 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #24407a 0%, #3457cb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Paramètres Généraux</h1>
                    <p class="text-lg text-gray-600 font-normal">Configurez et personnalisez votre environnement système</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.1s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-primary mb-1"><?php echo count($cardPGeneraux); ?></h3>
                        <p class="text-sm font-semibold text-gray-600">Modules Disponibles</p>
                        <p class="text-xs text-green-600 font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Actifs
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.2s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-secondary mb-1">100%</h3>
                        <p class="text-sm font-semibold text-gray-600">Sécurisé</p>
                        <p class="text-xs text-green-600 font-medium">
                            <i class="fas fa-lock mr-1"></i>Protégé
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="stat-card animate-slide-in-right" style="animation-delay: 0.3s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-accent/10 text-yellow-600 rounded-xl flex items-center justify-center text-2xl">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-yellow-600 mb-1">v2.1</h3>
                        <p class="text-sm font-semibold text-gray-600">Version Système</p>
                        <p class="text-xs text-blue-600 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>Mise à jour
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Introduction Section -->
        <div class="card p-8 mb-8 animate-scale-in">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gradient mb-4">Centre de Configuration</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Accédez rapidement aux différents modules de configuration pour personnaliser et optimiser votre expérience utilisateur. 
                    Chaque module offre des options avancées pour répondre à vos besoins spécifiques.
                </p>
            </div>
        </div>

        <!-- Parameters Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 animate-scale-in">
            <?php if (!empty($cardPGeneraux)): ?>
                <?php foreach ($cardPGeneraux as $index => $card): ?>
                <div class="param-card" style="animation-delay: <?php echo ($index * 0.1) ?>s">
                    <div class="relative h-full flex flex-col">
                        <!-- Icon Section -->
                        <div class="flex justify-center pt-8 pb-6">
                            <?php
                            // Déterminer l'icône appropriée basée sur le titre ou le contenu
                            $iconClass = 'fa-cog'; // Icône par défaut
                            $iconColor = 'from-primary to-primary-light'; // Couleur par défaut
                            
                            $title = strtolower($card['title']);
                            if (strpos($title, 'utilisateur') !== false || strpos($title, 'user') !== false) {
                                $iconClass = 'fa-users';
                                $iconColor = 'from-blue-500 to-blue-600';
                            } elseif (strpos($title, 'grade') !== false) {
                                $iconClass = 'fa-graduation-cap';
                                $iconColor = 'from-purple-500 to-purple-600';
                            } elseif (strpos($title, 'fonction') !== false || strpos($title, 'poste') !== false) {
                                $iconClass = 'fa-briefcase';
                                $iconColor = 'from-green-500 to-green-600';
                            } elseif (strpos($title, 'specialite') !== false || strpos($title, 'spécialité') !== false) {
                                $iconClass = 'fa-atom';
                                $iconColor = 'from-orange-500 to-orange-600';
                            } elseif (strpos($title, 'annee') !== false || strpos($title, 'année') !== false || strpos($title, 'academique') !== false) {
                                $iconClass = 'fa-calendar-alt';
                                $iconColor = 'from-indigo-500 to-indigo-600';
                            } elseif (strpos($title, 'ecue') !== false || strpos($title, 'module') !== false || strpos($title, 'cours') !== false) {
                                $iconClass = 'fa-book';
                                $iconColor = 'from-teal-500 to-teal-600';
                            } elseif (strpos($title, 'ue') !== false || strpos($title, 'unite') !== false || strpos($title, 'unité') !== false) {
                                $iconClass = 'fa-layer-group';
                                $iconColor = 'from-red-500 to-red-600';
                            } elseif (strpos($title, 'parcours') !== false || strpos($title, 'filiere') !== false || strpos($title, 'filière') !== false) {
                                $iconClass = 'fa-route';
                                $iconColor = 'from-pink-500 to-pink-600';
                            } elseif (strpos($title, 'niveau') !== false) {
                                $iconClass = 'fa-chart-line';
                                $iconColor = 'from-yellow-500 to-yellow-600';
                            } elseif (strpos($title, 'departement') !== false || strpos($title, 'département') !== false) {
                                $iconClass = 'fa-building';
                                $iconColor = 'from-gray-500 to-gray-600';
                            } elseif (strpos($title, 'action') !== false || strpos($title, 'activite') !== false || strpos($title, 'activité') !== false) {
                                $iconClass = 'fa-tasks';
                                $iconColor = 'from-cyan-500 to-cyan-600';
                            } elseif (strpos($title, 'rapport') !== false || strpos($title, 'document') !== false) {
                                $iconClass = 'fa-file-alt';
                                $iconColor = 'from-emerald-500 to-emerald-600';
                            } elseif (strpos($title, 'soutenance') !== false || strpos($title, 'evaluation') !== false || strpos($title, 'évaluation') !== false) {
                                $iconClass = 'fa-chalkboard-teacher';
                                $iconColor = 'from-violet-500 to-violet-600';
                            } elseif (strpos($title, 'note') !== false || strpos($title, 'resultat') !== false || strpos($title, 'résultat') !== false) {
                                $iconClass = 'fa-star';
                                $iconColor = 'from-amber-500 to-amber-600';
                            } elseif (strpos($title, 'semestre') !== false) {
                                $iconClass = 'fa-calendar-week';
                                $iconColor = 'from-lime-500 to-lime-600';
                            } elseif (strpos($title, 'jury') !== false || strpos($title, 'commission') !== false) {
                                $iconClass = 'fa-gavel';
                                $iconColor = 'from-rose-500 to-rose-600';
                            } elseif (strpos($title, 'session') !== false) {
                                $iconClass = 'fa-clock';
                                $iconColor = 'from-slate-500 to-slate-600';
                            } elseif (strpos($title, 'approuver') !== false || strpos($title, 'approbation') !== false) {
                                $iconClass = 'fa-check-circle';
                                $iconColor = 'from-green-500 to-green-600';
                            } elseif (strpos($title, 'statut') !== false || strpos($title, 'etat') !== false || strpos($title, 'état') !== false) {
                                $iconClass = 'fa-toggle-on';
                                $iconColor = 'from-blue-500 to-blue-600';
                            } elseif (strpos($title, 'config') !== false || strpos($title, 'parametre') !== false || strpos($title, 'paramètre') !== false) {
                                $iconClass = 'fa-sliders-h';
                                $iconColor = 'from-primary to-primary-light';
                            }
                            
                            if (!empty($card['icon']) && file_exists($card['icon'])):
                            ?>
                                <div class="param-icon w-20 h-20 bg-gradient-to-br <?php echo $iconColor; ?> rounded-2xl flex items-center justify-center shadow-lg">
                                    <img src="<?php echo htmlspecialchars($card['icon']); ?>" 
                                         alt="icone" 
                                         class="w-12 h-12 object-cover rounded-xl filter brightness-0 invert">
                                </div>
                            <?php else: ?>
                                <div class="param-icon w-20 h-20 bg-gradient-to-br <?php echo $iconColor; ?> rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas <?php echo $iconClass; ?> text-3xl text-white"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content Section -->
                        <div class="flex-1 px-6 pb-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                <?php echo htmlspecialchars($card['title']); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                <?php echo htmlspecialchars($card['description']); ?>
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-gray-500">Configuration</span>
                                    <span class="text-xs font-bold text-primary">85%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%"></div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="mt-auto">
                                <a href="<?php echo htmlspecialchars($card['link']); ?>" 
                                   class="btn btn-accent w-full justify-center group">
                                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                                    <span>Accéder</span>
                                </a>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            <div class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                Actif
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="card p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-cogs text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-500 mb-2">Aucun paramètre configuré</h3>
                        <p class="text-gray-400 mb-6">Les modules de configuration apparaîtront ici une fois activés</p>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span>Ajouter un module</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Help Section -->
        <div class="mt-12">
            <div class="card p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-1">Besoin d'aide ?</h4>
                            <p class="text-gray-600">Consultez notre documentation ou contactez le support technique</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button class="btn btn-primary">
                            <i class="fas fa-book"></i>
                            <span>Documentation</span>
                        </button>
                        <button class="btn btn-accent">
                            <i class="fas fa-headset"></i>
                            <span>Support</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au chargement
            const cards = document.querySelectorAll('.param-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Effet de hover amélioré pour les cartes
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Animation des barres de progression
            const progressBars = document.querySelectorAll('.progress-fill');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'none';
                        entry.target.offsetHeight; // Force reflow
                        entry.target.style.animation = 'shimmer 2s infinite';
                    }
                });
            });

            progressBars.forEach(bar => observer.observe(bar));

            // Notifications de succès
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-6 right-6 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle mr-2"></i>
                        <span>${message}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Event listeners pour les boutons d'aide
            document.addEventListener('click', function(e) {
                if (e.target.closest('button')) {
                    const btn = e.target.closest('button');
                    const btnText = btn.textContent.trim();
                    
                    if (btnText.includes('Documentation')) {
                        showNotification('Redirection vers la documentation...', 'info');
                    } else if (btnText.includes('Support')) {
                        showNotification('Connexion au support technique...', 'info');
                    }
                }
            });
        });
    </script>
</body>

</html>