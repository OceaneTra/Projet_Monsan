<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
$erreurs = $GLOBALS['erreurs'] ?? [];
$typesReclamation = $GLOBALS['typesReclamation'] ?? ['TECH' => 'Problème Technique', 'ADMIN' => 'Question Administrative', 'NOTE' => 'Erreur de Note'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Réclamation | Univalid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
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

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-right: 48px;
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

        .notification {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            border: 1px solid;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.1);
        }

        .notification.success {
            background: linear-gradient(135deg, rgba(54, 134, 90, 0.1) 0%, rgba(89, 191, 61, 0.1) 100%);
            border-color: rgba(54, 134, 90, 0.2);
            color: #36865a;
        }

        .notification.error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .notification.info {
            background: linear-gradient(135deg, rgba(52, 87, 203, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            border-color: rgba(52, 87, 203, 0.2);
            color: #3457cb;
        }

        /* Custom styles for Quill */
        .ql-toolbar.ql-snow {
            border-radius: 12px 12px 0 0;
            border-color: #e2e8f0;
            background: #f8fafc;
        }

        .ql-container.ql-snow {
            border-radius: 0 0 12px 12px;
            border-color: #e2e8f0;
            min-height: 200px;
            font-size: 1rem;
        }

        .ql-editor.ql-blank::before {
            color: #9ca3af;
            font-style: normal;
        }

        .ql-error .ql-toolbar.ql-snow,
        .ql-error .ql-container.ql-snow {
            border-color: #ef4444;
        }

        .character-counter {
            text-align: right;
            font-size: 12px;
            margin-top: 8px;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .character-counter.valid {
            color: #16a34a;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb animate-fade-in-down">
            <a href="?page=reclamations">
                <i class="fas fa-arrow-left mr-2"></i>
                Portail des réclamations
            </a>
            <span class="separator">
                <i class="fas fa-chevron-right"></i>
            </span>
            <span class="text-gray-900 font-medium">Nouvelle réclamation</span>
        </div>

        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex items-center gap-6 md:gap-8 flex-col md:flex-row text-center md:text-left">
                <div class="header-icon bg-gradient-to-br from-warning to-orange-500 text-white w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-4xl md:text-5xl shadow-lg">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="header-text">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight">Nouvelle Réclamation</h1>
                    <p class="text-lg text-gray-600 font-normal">Soumettez votre réclamation en détaillant votre problème ou votre question</p>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="notification <?= $_SESSION['message']['type'] === 'success' ? 'success' : 'error' ?> animate-fade-in-down">
                <div class="flex items-center">
                    <i class="fas fa-<?= $_SESSION['message']['type'] === 'success' ? 'check' : 'exclamation' ?>-circle mr-3 text-lg"></i>
                    <span class="font-semibold"><?= htmlspecialchars($_SESSION['message']['text']); ?></span>
                </div>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div class="notification error animate-fade-in-down">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-3 text-lg mt-1"></i>
                    <div>
                        <h4 class="font-bold mb-2">Veuillez corriger les erreurs suivantes :</h4>
                        <ul class="list-disc list-inside space-y-1">
                            <?php foreach ($erreurs as $erreur): ?>
                                <li><?= htmlspecialchars($erreur); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Form Card -->
        <div class="card animate-scale-in">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Formulaire de réclamation</h2>

                <form method="POST" id="reclamationForm" novalidate>
                    <div class="space-y-6">
                        <!-- Type de réclamation -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Type de réclamation <span class="text-red-500">*</span>
                            </label>
                            <select id="type" name="type" required 
                                class="form-input form-select <?= isset($erreurs['type']) ? 'error' : '' ?>">
                                <option value="">Sélectionnez un type...</option>
                                <?php foreach ($typesReclamation as $key => $label): ?>
                                <option value="<?= htmlspecialchars($key); ?>" 
                                    <?= (isset($_POST['type']) && $_POST['type'] === $key) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($label); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Objet -->
                        <div>
                            <label for="objet" class="block text-sm font-semibold text-gray-700 mb-2">
                                Objet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="objet" name="objet" required 
                                value="<?= htmlspecialchars($_POST['objet'] ?? ''); ?>" 
                                class="form-input <?= isset($erreurs['objet']) ? 'error' : ''; ?>" 
                                placeholder="Ex: Problème d'accès à la plateforme" minlength="5">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="editor" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description détaillée <span class="text-red-500">*</span>
                            </label>
                            <div class="<?= isset($erreurs['description']) ? 'ql-error' : ''; ?>">
                                <div id="editor"><?= $_POST['content'] ?? ''; ?></div>
                            </div>
                            <input type="hidden" name="content" id="content">
                            <div id="charCounter" class="character-counter">0 / 60 caractères min.</div>
                        </div>

                        <!-- Information Box -->
                        <div class="notification info">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle mr-3 text-lg mt-1"></i>
                                <div>
                                    <h4 class="font-bold mb-2">Informations importantes</h4>
                                    <ul class="list-disc list-inside space-y-1 text-sm">
                                        <li>Votre réclamation sera traitée dans les meilleurs délais.</li>
                                        <li>Vous recevrez des notifications par e-mail à chaque étape du traitement.</li>
                                        <li>Les informations fournies resteront confidentielles.</li>
                                        <li>Assurez-vous de fournir tous les détails nécessaires pour un traitement efficace.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="mt-10 pt-8 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end gap-4">
                        <a href="?page=reclamations" class="btn-gray btn">
                            <i class="fas fa-times"></i>
                            <span>Annuler</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            <span>Soumettre la réclamation</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // VOTRE SCRIPT EST CONSERVÉ ET ADAPTÉ
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Quill === 'undefined') {
                console.error('Quill library not found.');
                return;
            }

            const quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['link', 'clean']
                    ]
                },
                placeholder: 'Décrivez votre problème ou votre question aussi précisément que possible...'
            });

            const form = document.getElementById('reclamationForm');
            const contentInput = document.getElementById('content');
            const charCounter = document.getElementById('charCounter');
            
            // Mise à jour du compteur de caractères
            const updateCharCount = () => {
                const textLength = quill.getText().trim().length;
                charCounter.textContent = `${textLength} / 60 caractères min.`;
                charCounter.className = textLength >= 60 ? 'character-counter valid' : 'character-counter';
            };
            
            quill.on('text-change', updateCharCount);
            updateCharCount(); // Appel initial

            if (form) {
                form.addEventListener('submit', function(e) {
                    // Mettre à jour le champ caché avec le contenu de l'éditeur
                    if (contentInput) {
                        contentInput.value = quill.root.innerHTML;
                    }

                    // Validation côté client
                    if (quill.getText().trim().length < 60) {
                        e.preventDefault(); 
                        showNotification('error', 'La description détaillée doit contenir au moins 60 caractères pour assurer un traitement efficace.');
                        const editorContainer = document.querySelector('.ql-container');
                        if(editorContainer) editorContainer.parentElement.classList.add('ql-error');
                        return false;
                    }

                    // Validation du type
                    const typeSelect = document.getElementById('type');
                    if (!typeSelect.value) {
                        e.preventDefault();
                        showNotification('error', 'Veuillez sélectionner un type de réclamation.');
                        typeSelect.classList.add('error');
                        return false;
                    }

                    // Validation de l'objet
                    const objetInput = document.getElementById('objet');
                    if (!objetInput.value.trim() || objetInput.value.trim().length < 5) {
                        e.preventDefault();
                        showNotification('error', 'L\'objet doit contenir au moins 5 caractères.');
                        objetInput.classList.add('error');
                        return false;
                    }
                });
            }

            // Fonction de notification
            function showNotification(type, message) {
                // Créer l'élément de notification
                const notification = document.createElement('div');
                notification.className = `notification ${type} fixed top-6 right-6 z-50 max-w-md transform transition-all duration-300 translate-x-full`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-3 text-lg"></i>
                        <span class="font-semibold">${message}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animer l'entrée
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Supprimer après 5 secondes
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 5000);
            }

            // Supprimer les classes d'erreur lors de la saisie
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('error')) {
                    e.target.classList.remove('error');
                }
            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('error')) {
                    e.target.classList.remove('error');
                }
            });

            // Animation des cartes
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>