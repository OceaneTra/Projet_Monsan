<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processus de Validation | Commission de Validation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .filters { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .filter-grid select, .filter-grid input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .reports { background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .report-item { padding: 20px; border-bottom: 1px solid #eee; }
        .report-item:last-child { border-bottom: none; }
        .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .report-title { font-size: 18px; font-weight: bold; margin: 0; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-en-cours { background: #fff3cd; color: #856404; }
        .status-valide { background: #d4edda; color: #155724; }
        .status-rejete { background: #f8d7da; color: #721c24; }
        .evaluations { margin-top: 15px; }
        .evaluation-item { background: #f8f9fa; padding: 15px; margin-bottom: 10px; border-radius: 6px; }
        .evaluator { display: flex; align-items: center; margin-bottom: 8px; }
        .evaluator img { width: 24px; height: 24px; border-radius: 50%; margin-right: 8px; }
        .decision-valid { color: #28a745; }
        .decision-reject { color: #dc3545; }
        .decision-pending { color: #6c757d; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-list-check"></i> Processus de Validation des Rapports</h1>
            <p>Aperçu de tous les rapports et leurs évaluations par les membres de la commission</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3><i class="fas fa-file-alt"></i> Total rapports</h3>
                <p style="font-size: 24px; font-weight: bold; color: #007bff;">12</p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-clock"></i> En cours d'évaluation</h3>
                <p style="font-size: 24px; font-weight: bold; color: #ffc107;">5</p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-check"></i> Validés</h3>
                <p style="font-size: 24px; font-weight: bold; color: #28a745;">4</p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-times"></i> Rejetés</h3>
                <p style="font-size: 24px; font-weight: bold; color: #dc3545;">3</p>
            </div>
        </div>

        <div class="filters">
            <h3><i class="fas fa-filter"></i> Filtres</h3>
            <div class="filter-grid">
                <div>
                    <label>Statut:</label>
                    <select id="statusFilter" onchange="filterReports()">
                        <option value="">Tous les statuts</option>
                        <option value="en_cours">En cours d'évaluation</option>
                        <option value="valide">Validé</option>
                        <option value="rejete">Rejeté</option>
                    </select>
                </div>
                <div>
                    <label>Membre:</label>
                    <select id="memberFilter" onchange="filterReports()">
                        <option value="">Tous les membres</option>
                        <option value="Dr. Kouassi">Dr. Kouassi</option>
                        <option value="Dr. Koné">Dr. Koné</option>
                        <option value="Pr. Assan">Pr. Assan</option>
                        <option value="Dr. Bamba">Dr. Bamba</option>
                    </select>
                </div>
                <div>
                    <label>Recherche:</label>
                    <input type="text" id="searchFilter" placeholder="Rechercher un rapport..." onkeyup="filterReports()">
                </div>
                <div>
                    <label>&nbsp;</label>
                    <button onclick="resetFilters()" class="btn btn-primary">Réinitialiser</button>
                </div>
            </div>
        </div>

        <div class="reports">
            <div style="padding: 20px; border-bottom: 1px solid #eee;">
                <h3><i class="fas fa-list-check"></i> Rapports en cours de validation</h3>
                <p id="reportCount">12 rapports trouvés</p>
            </div>

            <div class="report-item" data-status="en_cours">
                <div class="report-header">
                    <h3 class="report-title">Intelligence Artificielle dans le Diagnostic Médical</h3>
                    <div>
                        <span class="status-badge status-en-cours">En cours (2/4 votes)</span>
                    </div>
                </div>
                <p><strong>Étudiant:</strong> Marie Lambert • <strong>Encadrant:</strong> Dr. Martin • <strong>Date:</strong> 20/05/2025</p>
                
                <div class="evaluations">
                    <h4>Évaluations des membres :</h4>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. Kouassi">
                            <strong>Dr. Kouassi</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Excellent travail, méthodologie rigoureuse et résultats prometteurs. Le rapport démontre une bonne maîtrise des concepts d'IA."</em></p>
                        <small>Évalué le 22/05/2025 à 14:30</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Dr. Koné">
                            <strong>Dr. Koné</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Innovation intéressante dans l'application de l'IA au diagnostic médical. Bien documenté et structuré."</em></p>
                        <small>Évalué le 23/05/2025 à 09:15</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Pr. Assan">
                            <strong>Pr. Assan</strong>
                            <span class="decision-pending" style="margin-left: auto;">⏳ En attente</span>
                        </div>
                        <p><em>Pas encore évalué</em></p>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/men/78.jpg" alt="Dr. Bamba">
                            <strong>Dr. Bamba</strong>
                            <span class="decision-pending" style="margin-left: auto;">⏳ En attente</span>
                        </div>
                        <p><em>Pas encore évalué</em></p>
                    </div>
                </div>
                
                <div class="actions" style="margin-top: 15px;">
                    <button onclick="viewReport(1)" class="btn btn-primary">👁️ Consulter</button>
                    <button onclick="openEvaluationModal(1)" class="btn btn-success">🗳️ Voter</button>
                </div>
            </div>

            <div class="report-item" data-status="valide">
                <div class="report-header">
                    <h3 class="report-title">Système de Gestion des Ressources Humaines</h3>
                    <div>
                        <span class="status-badge status-valide">Validé (4/4 votes)</span>
                    </div>
                </div>
                <p><strong>Étudiant:</strong> Jean Dupont • <strong>Encadrant:</strong> Dr. Dubois • <strong>Date:</strong> 18/05/2025</p>
                
                <div class="evaluations">
                    <h4>Évaluations des membres :</h4>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. Kouassi">
                            <strong>Dr. Kouassi</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Approche solide et bien structurée. L'analyse des besoins est complète et la solution proposée est pertinente."</em></p>
                        <small>Évalué le 19/05/2025 à 16:45</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Dr. Koné">
                            <strong>Dr. Koné</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Bonne maîtrise des concepts de gestion RH. L'interface utilisateur est intuitive et bien pensée."</em></p>
                        <small>Évalué le 20/05/2025 à 11:20</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Pr. Assan">
                            <strong>Pr. Assan</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Travail de qualité avec une architecture bien conçue. Les tests sont suffisants et la documentation est claire."</em></p>
                        <small>Évalué le 21/05/2025 à 14:10</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/men/78.jpg" alt="Dr. Bamba">
                            <strong>Dr. Bamba</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Excellente implémentation des fonctionnalités demandées. Le code est propre et bien organisé."</em></p>
                        <small>Évalué le 22/05/2025 à 09:30</small>
                    </div>
                </div>
                
                <div class="actions" style="margin-top: 15px;">
                    <button onclick="viewReport(2)" class="btn btn-primary">👁️ Consulter</button>
                    <button onclick="makeFinalDecision(2)" class="btn btn-success">⚖️ Finaliser</button>
                </div>
            </div>

            <div class="report-item" data-status="rejete">
                <div class="report-header">
                    <h3 class="report-title">Application Mobile de Commerce Électronique</h3>
                    <div>
                        <span class="status-badge status-rejete">Rejeté (4/4 votes)</span>
                    </div>
                </div>
                <p><strong>Étudiant:</strong> Sophie Martin • <strong>Encadrant:</strong> Dr. Bernard • <strong>Date:</strong> 15/05/2025</p>
                
                <div class="evaluations">
                    <h4>Évaluations des membres :</h4>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. Kouassi">
                            <strong>Dr. Kouassi</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Interface utilisateur moderne et fonctionnelle. L'architecture est bien pensée."</em></p>
                        <small>Évalué le 16/05/2025 à 15:20</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Dr. Koné">
                            <strong>Dr. Koné</strong>
                            <span class="decision-valid" style="margin-left: auto;">✅ Validé</span>
                        </div>
                        <p><em>"Bonne implémentation des fonctionnalités de base. Le design est attractif."</em></p>
                        <small>Évalué le 17/05/2025 à 10:45</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Pr. Assan">
                            <strong>Pr. Assan</strong>
                            <span class="decision-reject" style="margin-left: auto;">❌ Rejeté</span>
                        </div>
                        <p><em>"L'analyse de sécurité est insuffisante. Les tests de pénétration ne sont pas assez approfondis."</em></p>
                        <small>Évalué le 18/05/2025 à 13:15</small>
                    </div>
                    
                    <div class="evaluation-item">
                        <div class="evaluator">
                            <img src="https://randomuser.me/api/portraits/men/78.jpg" alt="Dr. Bamba">
                            <strong>Dr. Bamba</strong>
                            <span class="decision-reject" style="margin-left: auto;">❌ Rejeté</span>
                        </div>
                        <p><em>"Problèmes de performance identifiés. L'optimisation de la base de données n'est pas satisfaisante."</em></p>
                        <small>Évalué le 19/05/2025 à 16:30</small>
                    </div>
                </div>
                
                <div class="actions" style="margin-top: 15px;">
                    <button onclick="viewReport(3)" class="btn btn-primary">👁️ Consulter</button>
                    <button onclick="makeFinalDecision(3)" class="btn btn-danger">⚖️ Finaliser</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterReports() {
            const statusFilter = document.getElementById('statusFilter').value;
            const memberFilter = document.getElementById('memberFilter').value;
            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
            
            const reports = document.querySelectorAll('.report-item');
            let visibleCount = 0;
            
            reports.forEach(report => {
                let show = true;
                
                if (statusFilter && report.dataset.status !== statusFilter) {
                    show = false;
                }
                
                if (memberFilter && !report.textContent.includes(memberFilter)) {
                    show = false;
                }
                
                if (searchFilter && !report.textContent.toLowerCase().includes(searchFilter)) {
                    show = false;
                }
                
                report.style.display = show ? 'block' : 'none';
                if (show) visibleCount++;
            });
            
            document.getElementById('reportCount').textContent = `${visibleCount} rapports trouvés`;
        }
        
        function resetFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('memberFilter').value = '';
            document.getElementById('searchFilter').value = '';
            
            const reports = document.querySelectorAll('.report-item');
            reports.forEach(report => {
                report.style.display = 'block';
            });
            
            document.getElementById('reportCount').textContent = `${reports.length} rapports trouvés`;
        }
        
        function viewReport(reportId) {
            alert(`Ouverture du rapport ${reportId} en mode consultation...`);
        }
        
        function openEvaluationModal(reportId) {
            window.location.href = '?page=rapport_a_valider&action=vote&id=' + reportId;
        }
        
        function makeFinalDecision(reportId) {
            if (confirm('Êtes-vous sûr de vouloir finaliser la décision pour ce rapport ?')) {
                window.location.href = '?page=rapport_a_valider&action=finaliser&id=' + reportId;
            }
        }
    </script>
</body>
</html> 