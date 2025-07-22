<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rédaction des Comptes Rendus | Mr. Diarra</title>
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
        .editor-toolbar {
            border-bottom: 1px solid #e5e7eb;
        }
        .editor-button {
            transition: all 0.2s ease;
        }
        .editor-button:hover {
            background-color: #f3f4f6;
            transform: scale(1.05);
        }
        .editor-content {
            min-height: 400px;
            font-family: 'Times New Roman', serif;
        }
        .template-section {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }
        .progress-step {
            transition: all 0.3s ease;
        }
        .progress-step.active {
            background-color: #f59e0b;
            color: white;
        }
        .progress-step.completed {
            background-color: #10b981;
            color: white;
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .preview-content {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
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
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-yellow-700 bg-yellow-50">
                            <i class="fas fa-edit mr-3 text-yellow-500"></i>
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
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-archive mr-3 text-gray-500"></i>
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
                    <h1 class="text-xl font-semibold text-gray-800">Rédaction de Compte Rendu</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="saveAsDraft()" class="flex items-center px-3 py-1 text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-save mr-1"></i>Sauvegarder
                    </button>
                    <button onclick="previewReport()" class="flex items-center px-3 py-1 text-sm text-green-600 hover:text-green-800">
                        <i class="fas fa-eye mr-1"></i>Aperçu
                    </button>
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/men/55.jpg" alt="Mr. Diarra">
                            <span class="text-sm font-medium text-gray-700">Mr. Diarra</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="progress-step active flex items-center px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-info-circle mr-2"></i>1. Informations
                        </div>
                        <div class="w-8 h-0.5 bg-gray-300"></div>
                        <div class="progress-step bg-gray-200 text-gray-600 flex items-center px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-users mr-2"></i>2. Évaluations
                        </div>
                        <div class="w-8 h-0.5 bg-gray-300"></div>
                        <div class="progress-step bg-gray-200 text-gray-600 flex items-center px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i>3. Rédaction
                        </div>
                        <div class="w-8 h-0.5 bg-gray-300"></div>
                        <div class="progress-step bg-gray-200 text-gray-600 flex items-center px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-check mr-2"></i>4. Finalisation
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left column - Report selection and info -->
                        <div class="space-y-6">
                            <!-- Report Selection -->
                            <div class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                                    Sélection du rapport
                                </h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rapport à traiter</label>
                                        <select id="reportSelect" onchange="loadReportInfo()" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                            <option value="">Sélectionner un rapport...</option>
                                            <option value="1">IA Diagnostic Médical - Marie Lambert</option>
                                            <option value="2">Blockchain Sécurité - Jean Dupont</option>
                                            <option value="3">Réseaux Neurones - Thomas Moreau</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Report Info -->
                            <div id="reportInfo" class="bg-white rounded-lg shadow p-6 fade-in hidden">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-info-circle text-green-600 mr-2"></i>
                                    Informations du rapport
                                </h3>
                                <div id="reportDetails" class="space-y-3 text-sm">
                                    <!-- Content will be loaded dynamically -->
                                </div>
                            </div>

                            <!-- Evaluations Summary -->
                            <div id="evaluationsSummary" class="bg-white rounded-lg shadow p-6 fade-in hidden">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-users text-purple-600 mr-2"></i>
                                    Résumé des évaluations
                                </h3>
                                <div id="evaluationsContent" class="space-y-3">
                                    <!-- Content will be loaded dynamically -->
                                </div>
                            </div>

                            <!-- Templates -->
                            <div class="template-section rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-template text-yellow-600 mr-2"></i>
                                    Modèles de compte rendu
                                </h3>
                                <div class="space-y-2">
                                    <button onclick="loadTemplate('standard')" class="w-full text-left p-3 border border-yellow-200 rounded-lg hover:bg-yellow-50 transition-colors">
                                        <i class="fas fa-file-alt text-yellow-600 mr-2"></i>
                                        <span class="font-medium">Modèle standard</span>
                                        <p class="text-xs text-gray-600 mt-1">Modèle classique pour rapports académiques</p>
                                    </button>
                                    <button onclick="loadTemplate('detailed')" class="w-full text-left p-3 border border-yellow-200 rounded-lg hover:bg-yellow-50 transition-colors">
                                        <i class="fas fa-file-medical-alt text-yellow-600 mr-2"></i>
                                        <span class="font-medium">Modèle détaillé</span>
                                        <p class="text-xs text-gray-600 mt-1">Pour les rapports nécessitant plus d'analyse</p>
                                    </button>
                                    <button onclick="loadTemplate('synthesis')" class="w-full text-left p-3 border border-yellow-200 rounded-lg hover:bg-yellow-50 transition-colors">
                                        <i class="fas fa-file-contract text-yellow-600 mr-2"></i>
                                        <span class="font-medium">Modèle synthèse</span>
                                        <p class="text-xs text-gray-600 mt-1">Version condensée et synthétique</p>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right column - Editor -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg shadow overflow-hidden fade-in">
                                <!-- Editor Header -->
                                <div class="editor-toolbar px-6 py-3 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <i class="fas fa-edit text-yellow-600 mr-2"></i>
                                            Éditeur de compte rendu
                                        </h3>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-600">Dernière sauvegarde: </span>
                                            <span id="lastSave" class="text-sm text-green-600">--:--</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Toolbar -->
                                <div class="editor-toolbar px-6 py-3 bg-white">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="formatText('bold')" class="editor-button p-2 rounded hover:bg-gray-100" title="Gras">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button onclick="formatText('italic')" class="editor-button p-2 rounded hover:bg-gray-100" title="Italique">
                                            <i class="fas fa-italic"></i>
                                        </button>
                                        <button onclick="formatText('underline')" class="editor-button p-2 rounded hover:bg-gray-100" title="Souligné">
                                            <i class="fas fa-underline"></i>
                                        </button>
                                        <div class="w-px h-6 bg-gray-300 mx-2"></div>
                                        <button onclick="insertList('ul')" class="editor-button p-2 rounded hover:bg-gray-100" title="Liste à puces">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                        <button onclick="insertList('ol')" class="editor-button p-2 rounded hover:bg-gray-100" title="Liste numérotée">
                                            <i class="fas fa-list-ol"></i>
                                        </button>
                                        <div class="w-px h-6 bg-gray-300 mx-2"></div>
                                        <button onclick="insertSection('evaluation')" class="editor-button px-3 py-1 text-sm bg-blue-50 text-blue-700 rounded hover:bg-blue-100">
                                            + Évaluation
                                        </button>
                                        <button onclick="insertSection('recommendation')" class="editor-button px-3 py-1 text-sm bg-green-50 text-green-700 rounded hover:bg-green-100">
                                            + Recommandation
                                        </button>
                                    </div>
                                </div>

                                <!-- Editor Content -->
                                <div class="p-6">
                                    <div id="editorContent" class="editor-content w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" contenteditable="true" style="min-height: 500px;">
                                        <div class="text-center mb-6">
                                            <h1 class="text-2xl font-bold mb-2">COMPTE RENDU D'ÉVALUATION</h1>
                                            <h2 class="text-lg font-semibold text-gray-700">Commission de Validation des Rapports</h2>
                                            <p class="text-gray-600 mt-2">Université Félix Houphouët-Boigny</p>
                                        </div>

                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">I. INFORMATIONS GÉNÉRALES</h3>
                                            <p><strong>Titre du rapport :</strong> [À compléter]</p>
                                            <p><strong>Étudiant(e) :</strong> [À compléter]</p>
                                            <p><strong>Encadrant :</strong> [À compléter]</p>
                                            <p><strong>Date d'évaluation :</strong> [À compléter]</p>
                                            <p><strong>Membres de la commission :</strong> [À compléter]</p>
                                        </div>

                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">II. RÉSUMÉ DU RAPPORT</h3>
                                            <p class="text-gray-500 italic">[Cliquez ici pour ajouter un résumé du rapport...]</p>
                                        </div>

                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">III. ÉVALUATIONS DES MEMBRES</h3>
                                            <p class="text-gray-500 italic">[Les évaluations seront automatiquement insérées ici...]</p>
                                        </div>

                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">IV. SYNTHÈSE ET RECOMMANDATIONS</h3>
                                            <p class="text-gray-500 italic">[Cliquez ici pour ajouter votre synthèse...]</p>
                                        </div>

                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">V. DÉCISION FINALE</h3>
                                            <p class="text-gray-500 italic">[La décision finale sera ajoutée ici...]</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <button onclick="saveAsDraft()" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                                <i class="fas fa-save mr-2"></i>Sauvegarder en brouillon
                                            </button>
                                            <button onclick="autoSave()" class="flex items-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                                                <i class="fas fa-clock mr-2"></i>Sauvegarde auto
                                            </button>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button onclick="previewReport()" class="flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                                <i class="fas fa-eye mr-2"></i>Aperçu
                                            </button>
                                            <button onclick="finalizeReport()" class="flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700">
                                                <i class="fas fa-check mr-2"></i>Finaliser
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity modal-overlay" onclick="closePreviewModal()"></div>
            
            <div class="inline-block w-full max-w-4xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-eye text-green-600 mr-2"></i>
                        Aperçu du compte rendu
                    </h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="printReport()" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            <i class="fas fa-print mr-1"></i>Imprimer
                        </button>
                        <button onclick="exportToPDF()" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </button>
                        <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6 max-h-96 overflow-y-auto">
                    <div id="previewContent" class="preview-content">
                        <!-- Preview content will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let currentReportData = null;
        let autoSaveInterval = null;

        // Données simulées des rapports
        const reportsData = {
            '1': {
                title: 'Intelligence Artificielle dans le Diagnostic Médical',
                student: 'Marie Lambert',
                supervisor: 'Dr. Martin',
                date: '20/05/2025',
                status: 'En évaluation',
                evaluations: [
                    { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Excellent travail, méthodologie rigoureuse' },
                    { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Innovation intéressante, bien documenté' },
                    { evaluator: 'Pr. Assan', decision: 'Validé', comment: 'Contribution significative au domaine' }
                ]
            },
            '2': {
                title: 'Blockchain et Sécurité des Données',
                student: 'Jean Dupont',
                supervisor: 'Pr. Leroy',
                date: '18/05/2025',
                status: 'Décision finale prise',
                evaluations: [
                    { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Approche solide et bien structurée' },
                    { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Bonne maîtrise des concepts' },
                    { evaluator: 'Dr. Bamba', decision: 'Rejeté', comment: 'Quelques lacunes dans l\'analyse' }
                ]
            }
        };

        // Chargement des informations du rapport
        function loadReportInfo() {
            const reportId = document.getElementById('reportSelect').value;
            const reportInfo = document.getElementById('reportInfo');
            const evaluationsSummary = document.getElementById('evaluationsSummary');
            
            if (reportId && reportsData[reportId]) {
                currentReportData = reportsData[reportId];
                
                // Afficher les informations du rapport
                document.getElementById('reportDetails').innerHTML = `
                    <div class="grid grid-cols-1 gap-2">
                        <p><strong>Titre:</strong> ${currentReportData.title}</p>
                        <p><strong>Étudiant:</strong> ${currentReportData.student}</p>
                        <p><strong>Encadrant:</strong> ${currentReportData.supervisor}</p>
                        <p><strong>Date:</strong> ${currentReportData.date}</p>
                        <p><strong>Statut:</strong> 
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                ${currentReportData.status}
                            </span>
                        </p>
                    </div>
                `;
                
                // Afficher le résumé des évaluations
                let evaluationsHTML = '';
                currentReportData.evaluations.forEach(eval => {
                    const bgColor = eval.decision === 'Validé' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
                    const textColor = eval.decision === 'Validé' ? 'text-green-800' : 'text-red-800';
                    
                    evaluationsHTML += `
                        <div class="p-3 border rounded-lg ${bgColor}">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-sm">${eval.evaluator}</span>
                                <span class="px-2 py-1 text-xs rounded-full ${bgColor} ${textColor}">
                                    ${eval.decision}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600">${eval.comment}</p>
                        </div>
                    `;
                });
                
                document.getElementById('evaluationsContent').innerHTML = evaluationsHTML;
                
                reportInfo.classList.remove('hidden');
                evaluationsSummary.classList.remove('hidden');
                
                // Mettre à jour le contenu de l'éditeur
                updateEditorWithReportData();
            } else {
                reportInfo.classList.add('hidden');
                evaluationsSummary.classList.add('hidden');
                currentReportData = null;
            }
        }

        // Mise à jour de l'éditeur avec les données du rapport
        function updateEditorWithReportData() {
            if (!currentReportData) return;
            
            const editor = document.getElementById('editorContent');
            let content = editor.innerHTML;
            
            // Remplacer les placeholders
            content = content.replace('[À compléter]', currentReportData.title);
            content = content.replace('[À compléter]', currentReportData.student);
            content = content.replace('[À compléter]', currentReportData.supervisor);
            content = content.replace('[À compléter]', new Date().toLocaleDateString('fr-FR'));
            content = content.replace('[À compléter]', 'Dr. Kouassi, Dr. Koné, Pr. Assan, Dr. Bamba, Mr. Diarra');
            
            editor.innerHTML = content;
        }

        // Chargement des modèles
        function loadTemplate(templateType) {
            const editor = document.getElementById('editorContent');
            let template = '';
            
            switch(templateType) {
                case 'standard':
                    template = `
                        <div class="text-center mb-6">
                            <h1 class="text-2xl font-bold mb-2">COMPTE RENDU D'ÉVALUATION</h1>
                            <h2 class="text-lg font-semibold text-gray-700">Commission de Validation des Rapports</h2>
                            <p class="text-gray-600 mt-2">Université Félix Houphouët-Boigny</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">I. INFORMATIONS GÉNÉRALES</h3>
                            <p><strong>Titre du rapport :</strong> [À compléter]</p>
                            <p><strong>Étudiant(e) :</strong> [À compléter]</p>
                            <p><strong>Encadrant :</strong> [À compléter]</p>
                            <p><strong>Date d'évaluation :</strong> [À compléter]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">II. RÉSUMÉ DU RAPPORT</h3>
                            <p>[Résumé du contenu du rapport...]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">III. ÉVALUATIONS</h3>
                            <p>[Évaluations des membres de la commission...]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">IV. DÉCISION FINALE</h3>
                            <p>[Décision de la commission...]</p>
                        </div>
                    `;
                    break;
                    
                case 'detailed':
                    template = `
                        <div class="text-center mb-6">
                            <h1 class="text-2xl font-bold mb-2">COMPTE RENDU DÉTAILLÉ D'ÉVALUATION</h1>
                            <h2 class="text-lg font-semibold text-gray-700">Commission de Validation des Rapports</h2>
                            <p class="text-gray-600 mt-2">Université Félix Houphouët-Boigny</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">I. INFORMATIONS GÉNÉRALES</h3>
                            <p><strong>Titre du rapport :</strong> [À compléter]</p>
                            <p><strong>Étudiant(e) :</strong> [À compléter]</p>
                            <p><strong>Niveau d'études :</strong> [À compléter]</p>
                            <p><strong>Encadrant principal :</strong> [À compléter]</p>
                            <p><strong>Co-encadrant :</strong> [À compléter]</p>
                            <p><strong>Date de soumission :</strong> [À compléter]</p>
                            <p><strong>Date d'évaluation :</strong> [À compléter]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">II. CONTEXTE ET OBJECTIFS</h3>
                            <p><strong>Problématique :</strong> [Présentation de la problématique...]</p>
                            <p><strong>Objectifs :</strong> [Objectifs de la recherche...]</p>
                            <p><strong>Méthodologie :</strong> [Approche méthodologique...]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">III. ANALYSE DÉTAILLÉE</h3>
                            <h4 class="font-semibold mb-2">3.1 Qualité du contenu</h4>
                            <p>[Analyse du contenu...]</p>
                            <h4 class="font-semibold mb-2 mt-4">3.2 Méthodologie</h4>
                            <p>[Évaluation de la méthodologie...]</p>
                            <h4 class="font-semibold mb-2 mt-4">3.3 Résultats et discussion</h4>
                            <p>[Analyse des résultats...]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">IV. ÉVALUATIONS INDIVIDUELLES</h3>
                            <p>[Évaluations détaillées par membre...]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">V. SYNTHÈSE ET RECOMMANDATIONS</h3>
                            <p><strong>Points forts :</strong></p>
                            <ul><li>[Point fort 1]</li><li>[Point fort 2]</li></ul>
                            <p><strong>Points à améliorer :</strong></p>
                            <ul><li>[Point à améliorer 1]</li><li>[Point à améliorer 2]</li></ul>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">VI. DÉCISION FINALE</h3>
                            <p>[Décision motivée de la commission...]</p>
                        </div>
                    `;
                    break;
                    
                case 'synthesis':
                    template = `
                        <div class="text-center mb-6">
                            <h1 class="text-2xl font-bold mb-2">SYNTHÈSE D'ÉVALUATION</h1>
                            <h2 class="text-lg font-semibold text-gray-700">Commission de Validation</h2>
                            <p class="text-gray-600 mt-2">Université Félix Houphouët-Boigny</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">RAPPORT ÉVALUÉ</h3>
                            <p><strong>Titre :</strong> [À compléter]</p>
                            <p><strong>Auteur :</strong> [À compléter]</p>
                            <p><strong>Date :</strong> [À compléter]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">SYNTHÈSE DES ÉVALUATIONS</h3>
                            <p><strong>Consensus :</strong> [Résumé du consensus...]</p>
                            <p><strong>Points de divergence :</strong> [Points de désaccord...]</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold border-b border-gray-300 pb-2 mb-3">DÉCISION</h3>
                            <p><strong>Résultat :</strong> [Accepté/Rejeté/Révision]</p>
                            <p><strong>Justification :</strong> [Justification de la décision...]</p>
                        </div>
                    `;
                    break;
            }
            
            editor.innerHTML = template;
            if (currentReportData) {
                updateEditorWithReportData();
            }
        }

        // Fonctions de formatage de texte
        function formatText(command) {
            document.execCommand(command, false, null);
            document.getElementById('editorContent').focus();
        }

        function insertList(type) {
            const command = type === 'ul' ? 'insertUnorderedList' : 'insertOrderedList';
            document.execCommand(command, false, null);
            document.getElementById('editorContent').focus();
        }

        function insertSection(sectionType) {
            const editor = document.getElementById('editorContent');
            const selection = window.getSelection();
            const range = selection.getRangeAt(0);
            
            let sectionHTML = '';
            switch(sectionType) {
                case 'evaluation':
                    sectionHTML = `
                        <div class="mb-4 p-4 border-l-4 border-blue-500 bg-blue-50">
                            <h4 class="font-semibold text-blue-800 mb-2">Évaluation - [Nom de l'évaluateur]</h4>
                            <p><strong>Décision :</strong> [Validé/Rejeté]</p>
                            <p><strong>Commentaire :</strong> [Commentaire détaillé...]</p>
                        </div>
                    `;
                    break;
                case 'recommendation':
                    sectionHTML = `
                        <div class="mb-4 p-4 border-l-4 border-green-500 bg-green-50">
                            <h4 class="font-semibold text-green-800 mb-2">Recommandation</h4>
                            <p>[Votre recommandation...]</p>
                        </div>
                    `;
                    break;
            }
            
            const div = document.createElement('div');
            div.innerHTML = sectionHTML;
            range.insertNode(div.firstChild);
            editor.focus();
        }

        // Fonctions de sauvegarde
        function saveAsDraft() {
            const content = document.getElementById('editorContent').innerHTML;
            const reportId = document.getElementById('reportSelect').value;
            
            // Simuler la sauvegarde
            localStorage.setItem(`draft_${reportId}`, content);
            updateLastSaveTime();
            
            // Notification
            showNotification('Brouillon sauvegardé avec succès', 'success');
        }

        function autoSave() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
                autoSaveInterval = null;
                document.querySelector('[onclick="autoSave()"]').innerHTML = '<i class="fas fa-clock mr-2"></i>Sauvegarde auto';
            } else {
                autoSaveInterval = setInterval(() => {
                    saveAsDraft();
                }, 30000); // Sauvegarde toutes les 30 secondes
                document.querySelector('[onclick="autoSave()"]').innerHTML = '<i class="fas fa-check mr-2"></i>Auto: ON';
            }
        }

        function updateLastSaveTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('lastSave').textContent = timeString;
        }

        // Aperçu du rapport
        function previewReport() {
            const content = document.getElementById('editorContent').innerHTML;
            document.getElementById('previewContent').innerHTML = content;
            document.getElementById('previewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fonctions d'export
        function printReport() {
            const content = document.getElementById('previewContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Compte Rendu d'Évaluation</title>
                    <style>
                        body { font-family: 'Times New Roman', serif; line-height: 1.6; margin: 40px; }
                        h1, h2, h3, h4 { color: #333; }
                        .border-b { border-bottom: 1px solid #ccc; }
                        .mb-6 { margin-bottom: 24px; }
                        .mb-4 { margin-bottom: 16px; }
                        .mb-3 { margin-bottom: 12px; }
                        .mb-2 { margin-bottom: 8px; }
                        .pb-2 { padding-bottom: 8px; }
                        .p-4 { padding: 16px; }
                        .border-l-4 { border-left: 4px solid #3b82f6; }
                        .bg-blue-50 { background-color: #eff6ff; }
                        .bg-green-50 { background-color: #f0fdf4; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                        .font-semibold { font-weight: 600; }
                    </style>
                </head>
                <body>${content}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        function exportToPDF() {
            // Simulation d'export PDF
            showNotification('Export PDF en cours...', 'info');
            setTimeout(() => {
                showNotification('Rapport exporté en PDF avec succès', 'success');
            }, 2000);
        }

        // Finalisation du rapport
        function finalizeReport() {
            const content = document.getElementById('editorContent').innerHTML;
            const reportId = document.getElementById('reportSelect').value;
            
            if (!reportId) {
                showNotification('Veuillez sélectionner un rapport avant de finaliser', 'error');
                return;
            }
            
            if (content.includes('[À compléter]') || content.includes('[Cliquez ici')) {
                if (!confirm('Le rapport contient encore des sections à compléter. Voulez-vous vraiment le finaliser ?')) {
                    return;
                }
            }
            
            if (confirm('Êtes-vous sûr de vouloir finaliser ce compte rendu ? Cette action est irréversible.')) {
                // Simulation de finalisation
                localStorage.setItem(`final_${reportId}`, content);
                localStorage.removeItem(`draft_${reportId}`);
                
                showNotification('Compte rendu finalisé avec succès', 'success');
                
                // Mise à jour des étapes de progression
                updateProgressSteps(4);
            }
        }

        // Mise à jour des étapes de progression
        function updateProgressSteps(currentStep) {
            const steps = document.querySelectorAll('.progress-step');
            steps.forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 < currentStep) {
                    step.classList.add('completed');
                } else if (index + 1 === currentStep) {
                    step.classList.add('active');
                }
            });
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
            // Gestion du menu mobile
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const sidebar = document.querySelector('.hidden.md\\:flex.md\\:flex-shrink-0 > .flex.flex-col.w-64');

            if (mobileMenuButton && sidebar) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('absolute');
                    sidebar.classList.toggle('z-20');
                });
            }

            // Sauvegarde automatique lors de la saisie
            const editor = document.getElementById('editorContent');
            let saveTimeout;
            
            editor.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    if (autoSaveInterval) {
                        saveAsDraft();
                    }
                }, 5000); // Sauvegarde 5 secondes après la dernière modification
            });

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 's':
                            e.preventDefault();
                            saveAsDraft();
                            break;
                        case 'p':
                            e.preventDefault();
                            previewReport();
                            break;
                    }
                }
                
                if (e.key === 'Escape') {
                    closePreviewModal();
                }
            });

            // Charger un brouillon s'il existe
            const reportSelect = document.getElementById('reportSelect');
            reportSelect.addEventListener('change', function() {
                const reportId = this.value;
                if (reportId) {
                    const draft = localStorage.getItem(`draft_${reportId}`);
                    if (draft) {
                        if (confirm('Un brouillon existe pour ce rapport. Voulez-vous le charger ?')) {
                            document.getElementById('editorContent').innerHTML = draft;
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>