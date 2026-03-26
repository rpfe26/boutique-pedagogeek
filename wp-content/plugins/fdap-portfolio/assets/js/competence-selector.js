/**
 * FDAP Competence Selector
 * Gestion interactive du référentiel CAP EPC
 */

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('fdap-competence-selector');
    if (!container) return;

    const textarea = document.getElementById('fdap_competences');
    const domaineInput = document.getElementById('fdap_domaine');
    const referentiel = window.fdapReferentiel || (window.fdapData ? fdapData.referentiel : []);

    let state = {
        selectedDomaine: domaineInput.value || '',
        competences: textarea.value ? textarea.value.split('\n').map(c => c.trim()).filter(c => c) : [],
        expandedMeta: null,
        showCustomInput: false,
        customInputValue: ''
    };

    function render() {
        const selectedPole = referentiel.find(p => p.label === state.selectedDomaine);

        let html = `
            <div class="fdap-selector-wrap">
                <label class="fdap-label-step">Étape 1 : Choisissez un pôle d'activité</label>
                <div class="fdap-poles-grid">
                    ${referentiel.map(pole => `
                        <button type="button" class="fdap-pole-btn ${state.selectedDomaine === pole.label ? 'active' : ''}" data-label="${pole.label}">
                            <div class="pole-icon">${pole.id === 'P1' ? '📦' : pole.id === 'P2' ? '🏪' : pole.id === 'P3' ? '💁‍♂️' : '➕'}</div>
                            <div class="pole-id">${pole.id}</div>
                            <div class="pole-label">${pole.label.split(':')[1]?.trim() || pole.label}</div>
                        </button>
                    `).join('')}
                </div>

                ${selectedPole ? `
                    <div class="fdap-metas-wrap anim-fade-in">
                        <label class="fdap-label-step" style="margin-top:24px">Étape 2 : Détaillez vos compétences</label>
                        <div class="fdap-metas-list">
                            ${selectedPole.metaCompetences.map(meta => {
                                const isOpen = state.expandedMeta === meta.id;
                                const selectedSubsCount = meta.subCompetences.filter(s => state.competences.includes(s)).length;
                                
                                return `
                                    <div class="fdap-meta-item ${isOpen ? 'is-open' : ''} ${selectedSubsCount > 0 ? 'has-selections' : ''}">
                                        <div class="fdap-meta-header" data-id="${meta.id}">
                                            <div class="fdap-meta-title">
                                                <span class="fdap-meta-status-dot"></span>
                                                <span class="fdap-meta-id-badge">${meta.id}</span>
                                                <span>${meta.label}</span>
                                                ${selectedSubsCount > 0 ? `<span class="fdap-meta-count">${selectedSubsCount}</span>` : ''}
                                            </div>
                                            <span class="fdap-chevron">${isOpen ? '▲' : '▼'}</span>
                                        </div>
                                        <div class="fdap-subs-list" style="display: ${isOpen ? 'block' : 'none'}">
                                            ${meta.subCompetences.map(sub => {
                                                const isAutre = sub === 'Autre (à préciser)...';
                                                return `
                                                    <div class="fdap-sub-row">
                                                        <label class="fdap-sub-label ${state.competences.includes(sub) ? 'active' : ''}">
                                                            <input type="checkbox" class="fdap-sub-cb" ${state.competences.includes(sub) ? 'checked' : ''} data-label="${sub}">
                                                            <span>${sub}</span>
                                                        </label>
                                                        ${isAutre && state.competences.includes(sub) ? `
                                                            <div class="fdap-custom-input-box anim-fade-in">
                                                                <input type="text" id="fdap-new-comp-text" placeholder="Saisir la nouvelle compétence..." value="${state.customInputValue}">
                                                                <button type="button" id="fdap-add-comp-btn">Ajouter au référentiel</button>
                                                            </div>
                                                        ` : ''}
                                                    </div>
                                                `;
                                            }).join('')}
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                ` : `
                    <div class="fdap-empty-state">
                        Veuillez sélectionner un domaine pour afficher les compétences.
                    </div>
                `}

                <div class="fdap-summary-wrap" style="margin-top:24px">
                    <label class="fdap-label-step" style="font-size:0.7rem; color:#94a3b8">📋 Résumé de votre sélection</label>
                    <div class="fdap-summary-content">
                        ${(() => {
                            let summaryHtml = '';
                            let hasAny = false;

                            referentiel.forEach(pole => {
                                pole.metaCompetences.forEach(meta => {
                                    const selectedSubs = meta.subCompetences.filter(s => state.competences.includes(s) && s !== 'Autre (à préciser)...');
                                    
                                    if (selectedSubs.length > 0) {
                                        hasAny = true;
                                        summaryHtml += `
                                            <div class="summary-line is-meta">
                                                <span>📌</span>
                                                <span>${meta.id} - ${meta.label}</span>
                                            </div>
                                            ${selectedSubs.map(sub => `
                                                <div class="summary-line">
                                                    <span>•</span>
                                                    <span>${sub}</span>
                                                </div>
                                            `).join('')}
                                        `;
                                    }
                                });
                            });

                            return hasAny ? summaryHtml : '<span class="empty">Aucune compétence sélectionnée.</span>';
                        })()}
                    </div>
                </div>
            </div>
        `;

        container.innerHTML = html;
        bindEvents();
    }

    function bindEvents() {
        // Clic sur un pôle
        container.querySelectorAll('.fdap-pole-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                state.selectedDomaine = btn.dataset.label;
                domaineInput.value = state.selectedDomaine;
                state.expandedMeta = null;
                render();
            });
        });

        // Toggle accordéon
        container.querySelectorAll('.fdap-meta-header').forEach(header => {
            header.addEventListener('click', (e) => {
                if (e.target.type === 'checkbox') return;
                const id = header.dataset.id;
                state.expandedMeta = state.expandedMeta === id ? null : id;
                render();
            });
        });


        // Checkbox Sous-compétence
        container.querySelectorAll('.fdap-sub-cb').forEach(cb => {
            cb.addEventListener('change', () => {
                const label = cb.dataset.label;
                if (cb.checked) {
                    if (!state.competences.includes(label)) state.competences.push(label);
                } else {
                    state.competences = state.competences.filter(c => c !== label);
                }
                updateFinalValue();
                render();
            });
        });

        // Gestion de l'input dynamique "Autre"
        const customInput = document.getElementById('fdap-new-comp-text');
        if (customInput) {
            customInput.addEventListener('input', (e) => {
                state.customInputValue = e.target.value;
            });
            customInput.focus();
        }

        const addBtn = document.getElementById('fdap-add-comp-btn');
        if (addBtn) {
            addBtn.addEventListener('click', async () => {
                const val = state.customInputValue.trim();
                if (!val) return;

                addBtn.disabled = true;
                addBtn.innerText = 'Enregistrement...';

                try {
                    const response = await fetch(window.fdapData.ajaxUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            action: 'fdap_add_custom_competence',
                            nonce: window.fdapData.nonce,
                            competence: val
                        })
                    });

                    const result = await response.json();
                    if (result.success) {
                        // Ajouter la compétence à l'état actuel
                        state.competences.push(val);
                        // Retirer "Autre" de la sélection pour nettoyer
                        state.competences = state.competences.filter(c => c !== 'Autre (à préciser)...');
                        state.customInputValue = '';
                        
                        // Mettre à jour le référentiel local pour éviter un rechargement
                        const p4 = referentiel.find(p => p.id === 'P4');
                        if (p4) {
                            p4.metaCompetences[0].subCompetences.push(val);
                        }
                        
                        updateFinalValue();
                        render();
                        alert('Compétence ajoutée au référentiel collectif !');
                    } else {
                        alert(result.data.message || 'Erreur lors de l’ajout.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('Erreur réseau.');
                }
            });
        }
    }

    function updateFinalValue() {
        const final = [];
        referentiel.forEach(pole => {
            pole.metaCompetences.forEach(meta => {
                const selectedSubs = meta.subCompetences.filter(s => state.competences.includes(s) && s !== 'Autre (à préciser)...');
                
                if (selectedSubs.length > 0) {
                    final.push(`[Méta] ${meta.id} - ${meta.label}`);
                    selectedSubs.forEach(s => final.push(s));
                }
            });
        });
        
        textarea.value = final.join('\n');
    }

    render();
});
