<?php
// VOTRE LOGIQUE PHP EST CONSERVÉE À L'IDENTIQUE
$erreurs = $GLOBALS['erreurs'] ?? [];
$isEditMode = $GLOBALS['isEditMode'] ?? false;
$rapport = $GLOBALS['rapport'] ?? null;
$contenuRapport = $GLOBALS['contenuRapport'] ?? '';
$rapportDejaDepose = $GLOBALS['rapportDejaDepose'] ?? false;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditeur de Rapport | Univalid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
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

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(52, 87, 203, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #36865a 0%, #59bf3d 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(54, 134, 90, 0.3);
        }

        .btn-secondary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(54, 134, 90, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
        }

        .btn-gray {
            background: #f1f5f9;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-gray:hover:not(:disabled) {
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

        .form-input:read-only {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Custom styles for TinyMCE */
        .tox-tinymce {
            border-radius: 0 0 12px 12px !important;
            border: 2px solid #e2e8f0 !important;
            border-top: none !important;
        }

        .tox .tox-edit-area__iframe {
            background-color: #ffffff;
        }

        .tox-toolbar__primary {
            background: #f8fafc !important;
            border-bottom: 2px solid #e2e8f0 !important;
            border-radius: 12px 12px 0 0 !important;
        }

        .notification-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-width: 400px;
        }

        .notification {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.1);
            border: 1px solid #e2e8f0;
            border-left: 4px solid;
            transform: translateX(100%);
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            border-left-color: #10b981;
        }

        .notification.error {
            border-left-color: #ef4444;
        }

        .notification.info {
            border-left-color: #3b82f6;
        }

        .notification-icon {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 2px;
            color: #1f2937;
        }

        .notification-message {
            font-size: 13px;
            color: #4b5563;
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

        .loading-spinner {
            display: none;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
        }

        .loading-spinner.show {
            display: flex;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb animate-fade-in-down">
            <a href="?page=gestion_rapports">
                <i class="fas fa-arrow-left mr-2"></i>
                Gestion des rapports
            </a>
            <span class="separator">
                <i class="fas fa-chevron-right"></i>
            </span>
            <span class="text-gray-900 font-medium">
                <?= $rapportDejaDepose ? "Consultation du Rapport" : "Éditeur de Rapport" ?>
            </span>
        </div>

        <!-- Header Section -->
        <div class="header bg-white rounded-3xl p-8 lg:p-12 mb-8 shadow-xl relative overflow-hidden animate-fade-in-down">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                <div class="flex items-center gap-6 md:gap-8">
                    <div class="header-icon bg-gradient-to-br from-primary to-primary-light text-white w-16 h-16 md:w-20 md:h-20 rounded-2xl flex items-center justify-center text-3xl md:text-4xl shadow-lg">
                        <i class="fas fa-<?= $rapportDejaDepose ? 'eye' : 'edit' ?>"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                            <?= $rapportDejaDepose ? "Consultation du Rapport" : "Éditeur de Rapport" ?>
                        </h1>
                        <p class="text-lg text-gray-600 font-normal">
                            <?= $rapportDejaDepose ? "Ce rapport est en lecture seule car il a déjà été déposé." : "Rédigez et mettez en forme votre rapport de stage." ?>
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <?php if (!$rapportDejaDepose): ?>
                        <button id="saveBtn" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Enregistrer</span>
                        </button>
                        <button id="deposerBtn" class="btn btn-warning">
                            <i class="fas fa-paper-plane"></i>
                            <span>Déposer</span>
                        </button>
                    <?php endif; ?>
                    <button id="exportBtn" class="btn btn-secondary">
                        <i class="fas fa-file-pdf"></i>
                        <span>Exporter PDF</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Editor Card -->
        <div class="card animate-scale-in">
            <form id="rapportForm" method="POST">
                <input type="hidden" name="action" value="save_rapport">
                <?php if ($isEditMode && isset($rapport)): ?>
                    <input type="hidden" name="edit_id" value="<?= $rapport['id_rapport'] ?>">
                <?php endif; ?>

                <!-- Form Header -->
                <div class="p-8 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Informations du rapport</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom_rapport" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom du rapport <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nom_rapport" name="nom_rapport" 
                                value="<?= isset($rapport) ? htmlspecialchars($rapport['nom_rapport']) : '' ?>" 
                                class="form-input <?= $rapportDejaDepose ? '' : 'required' ?>" 
                                <?= $rapportDejaDepose ? 'readonly' : 'required' ?>>
                        </div>
                        <div>
                            <label for="theme_rapport" class="block text-sm font-semibold text-gray-700 mb-2">
                                Thème du rapport <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="theme_rapport" name="theme_rapport" 
                                value="<?= isset($rapport) ? htmlspecialchars($rapport['theme_rapport']) : '' ?>" 
                                class="form-input <?= $rapportDejaDepose ? '' : 'required' ?>" 
                                <?= $rapportDejaDepose ? 'readonly' : 'required' ?>>
                        </div>
                    </div>
                </div>
                
                <!-- Toolbar -->
                <div class="p-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button type="button" id="loadTemplateBtn" class="btn btn-gray text-sm" <?= $rapportDejaDepose ? 'disabled' : '' ?>>
                            <i class="fas fa-paste"></i>
                            <span>Charger un modèle</span>
                        </button>
                        <div id="loadingIndicator" class="loading-spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>Chargement...</span>
                        </div>
                    </div>
                    <?php if ($rapportDejaDepose): ?>
                        <div class="flex items-center gap-2 text-sm text-amber-600 bg-amber-50 px-3 py-2 rounded-lg border border-amber-200">
                            <i class="fas fa-lock"></i>
                            <span class="font-medium">Mode lecture seule</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Editor -->
                <div class="border-t-2 border-gray-200">
                    <textarea id="editor" name="contenu_rapport"></textarea>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Notification Container -->
    <div id="notificationContainer" class="notification-container"></div>

    <script>
        // VOTRE JAVASCRIPT EST CONSERVÉ ET ADAPTÉ
        document.addEventListener('DOMContentLoaded', function() {
            const isReadOnly = <?= $rapportDejaDepose ? 'true' : 'false' ?>;
            
            tinymce.init({
                selector: '#editor',
                height: 700,
                menubar: false,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code fullscreen',
                content_style: 'body { font-family: Inter, sans-serif; font-size: 16px; line-height: 1.6; margin: 20px; }',
                readonly: isReadOnly,
                setup: function(editor) {
                    editor.on('init', function() {
                        <?php if ($isEditMode && !empty($contenuRapport)): ?>
                            editor.setContent(<?= json_encode($contenuRapport) ?>);
                            showNotification('info', isReadOnly ? 'Rapport chargé en mode consultation.' : 'Rapport chargé en mode édition.');
                        <?php endif; ?>
                    });
                }
            });

            // Event Listeners
            document.getElementById('loadTemplateBtn')?.addEventListener('click', loadTemplate);
            document.getElementById('saveBtn')?.addEventListener('click', saveData);
            document.getElementById('exportBtn')?.addEventListener('click', exportPdf);
            document.getElementById('deposerBtn')?.addEventListener('click', submitForDeposit);

            function getEditorData() {
                const editor = tinymce.get('editor');
                if (!editor) {
                    showNotification('error', 'L\'éditeur n\'est pas initialisé.');
                    return null;
                }
                const nomRapport = document.getElementById('nom_rapport').value.trim();
                const themeRapport = document.getElementById('theme_rapport').value.trim();
                const content = editor.getContent();

                if (!nomRapport) { showNotification('error', 'Le nom du rapport est requis.'); return null; }
                if (!themeRapport) { showNotification('error', 'Le thème du rapport est requis.'); return null; }
                if (!content || content.trim() === '<p><br></p>' || content.trim() === '') { 
                    showNotification('error', 'Le contenu du rapport ne peut pas être vide.'); 
                    return null; 
                }
                
                return { nomRapport, themeRapport, content };
            }

            function saveData(e) {
                e.preventDefault();
                const data = getEditorData();
                if (!data) return;

                const btn = document.getElementById('saveBtn');
                setButtonLoading(btn, true);

                const formData = new FormData(document.getElementById('rapportForm'));
                formData.set('contenu_rapport', data.content);

                fetch('?page=gestion_rapports&action=save_rapport', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            showNotification('success', result.message || 'Rapport enregistré avec succès !');
                            if (result.new_id && !document.querySelector('input[name="edit_id"]')) {
                                setTimeout(() => window.location.href = `?page=gestion_rapports&action=creer_rapport&edit=${result.new_id}`, 1500);
                            }
                        } else {
                            showNotification('error', result.message || 'Une erreur est survenue.');
                        }
                    })
                    .catch(() => showNotification('error', 'Erreur de communication avec le serveur.'))
                    .finally(() => setButtonLoading(btn, false));
            }

            function exportPdf(e) {
                e.preventDefault();
                const data = getEditorData();
                if (!data) return;

                const btn = document.getElementById('exportBtn');
                setButtonLoading(btn, true);

                const formData = new FormData();
                formData.append('action', 'export_pdf');
                formData.append('contenu_rapport', data.content);
                formData.append('nom_rapport', data.nomRapport);
                formData.append('theme_rapport', data.themeRapport);

                fetch('?page=gestion_rapports&action=export_pdf', { method: 'POST', body: formData })
                    .then(response => {
                        if (response.ok) return response.blob();
                        throw new Error('La génération du PDF a échoué.');
                    })
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = `${data.nomRapport || 'rapport'}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        showNotification('success', 'Le PDF a été généré avec succès.');
                    })
                    .catch(err => showNotification('error', err.message))
                    .finally(() => setButtonLoading(btn, false));
            }
            
            function submitForDeposit(e) {
                e.preventDefault();
                const data = getEditorData();
                if (!data) return;

                if (confirm("Êtes-vous sûr de vouloir déposer ce rapport ? Cette action est définitive et vous ne pourrez plus le modifier.")) {
                    const form = document.getElementById('rapportForm');
                    form.querySelector('input[name="action"]').value = 'deposer_rapport';
                    form.submit();
                }
            }

            function loadTemplate(e) {
                e.preventDefault();
                const btn = e.currentTarget;
                const indicator = document.getElementById('loadingIndicator');
                
                setButtonLoading(btn, true, indicator);
                
                setTimeout(() => {
                    const templateContent = `
                        <h1 style="text-align: center; color: #24407a; margin-bottom: 30px;">Rapport de Stage</h1>
                        <h2 style="color: #3457cb; border-bottom: 2px solid #3457cb; padding-bottom: 5px;">Introduction</h2>
                        <p>Votre introduction ici...</p>
                        <h2 style="color: #3457cb; border-bottom: 2px solid #3457cb; padding-bottom: 5px;">Présentation de l'entreprise</h2>
                        <p>Description de l'entreprise...</p>
                        <h2 style="color: #3457cb; border-bottom: 2px solid #3457cb; padding-bottom: 5px;">Missions effectuées</h2>
                        <p>Détail de vos missions...</p>
                        <h2 style="color: #3457cb; border-bottom: 2px solid #3457cb; padding-bottom: 5px;">Conclusion</h2>
                        <p>Votre conclusion...</p>
                    `;
                    tinymce.get('editor').setContent(templateContent);
                    showNotification('success', 'Modèle de rapport chargé avec succès.');
                    setButtonLoading(btn, false, indicator);
                }, 1000);
            }

            function setButtonLoading(btn, isLoading, indicator = null) {
                if (!btn) return;
                const originalText = btn.dataset.originalText || btn.innerHTML;
                if (!btn.dataset.originalText) btn.dataset.originalText = originalText;
                
                if (isLoading) {
                    btn.disabled = true;
                    if (indicator) {
                        indicator.classList.add('show');
                        btn.style.display = 'none';
                    } else {
                        btn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i>Chargement...`;
                    }
                } else {
                    btn.disabled = false;
                    if (indicator) {
                        indicator.classList.remove('show');
                        btn.style.display = 'inline-flex';
                    } else {
                        btn.innerHTML = originalText;
                    }
                }
            }
            
            function showNotification(type, message, title = null) {
                const container = document.getElementById('notificationContainer');
                const notif = document.createElement('div');
                notif.className = `notification ${type}`;
                
                const typeTitles = { success: 'Succès', error: 'Erreur', info: 'Information' };
                const icons = {
                    success: '<i class="fas fa-check-circle text-green-500"></i>',
                    error: '<i class="fas fa-times-circle text-red-500"></i>',
                    info: '<i class="fas fa-info-circle text-blue-500"></i>'
                };

                notif.innerHTML = `
                    <div class="notification-icon">${icons[type]}</div>
                    <div class="notification-content">
                        <h4 class="notification-title">${title || typeTitles[type]}</h4>
                        <p class="notification-message">${message}</p>
                    </div>
                `;
                container.appendChild(notif);

                setTimeout(() => notif.classList.add('show'), 10);
                setTimeout(() => {
                    notif.classList.remove('show');
                    setTimeout(() => notif.remove(), 300);
                }, 5000);
            }

            // Animation des cartes
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>