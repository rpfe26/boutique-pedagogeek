<?php
/**
 * Template: Affichage single FDAP
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
    $id = get_the_ID();
    $fields = ['nom_prenom', 'date_de_saisie', 'lieu_', 'enseigne_', 'lieu_specifique',
               'domaine', 'competences', 'autonomie', 'materiels',
               'commanditaire', 'contraintes', 'consignes_recues', 'avec_qui_',
               'deroulement', 'resultats_', 'difficulte', 'plaisir_', 'ameliorations'];
    $values = [];
    foreach ($fields as $field) {
        $values[$field] = get_post_meta($id, '_fdap_' . $field, true);
    }
    
    $lieu_labels = [
        'lycee' => 'Au Lycée (Plateau technique)',
        'pfmp' => 'En Entreprise (PFMP)'
    ];
    
    $audio_id = get_post_meta($id, '_fdap_audio', true);
    $video_id = get_post_meta($id, '_fdap_video', true);
    $fichier_id = get_post_meta($id, '_fdap_fichier', true);
    $status = get_post_status($id);
    $fdap_comments = get_post_meta($id, '_fdap_comments', true);
    ?>    <article id="fdap-<?php the_ID(); ?>" class="fdap-main-wrapper fdap-single-container">
    <?php fdap_render_impersonation_banner(); ?>
    
    <div class="fdap-fiche-card">
        <div class="fdap-view">

        
        <?php if ($status === 'controlled'): ?>
        <!-- Bannière Contrôlée -->
        <div class="fdap-controlled-banner">
            <span class="fdap-banner-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
            </span>
            <div class="fdap-banner-text">
                <h3>Cette fiche a été contrôlée</h3>
                <p>Votre professeur a validé cette fiche. Consultez les commentaires ci-dessous.</p>
            </div>
        </div>
        <?php endif; ?>
        
        <?php
        // Affichage des commentaires en haut
        if (!empty($fdap_comments) && is_array($fdap_comments)):
            $fdap_comments = array_reverse($fdap_comments);
        ?>
        <div class="fdap-comments-teacher" style="margin-bottom: 30px; display: block !important; width: 100% !important;">
            <h3 style="display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#f59e0b" viewBox="0 0 16 16"><path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/><path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/></svg>
                Commentaires Du Professeur
            </h3>

            <div class="fdap-comments-list" style="display: block !important; width: 100% !important;">
                <?php foreach ($fdap_comments as $comment): 
                    $date_fmt = isset($comment['date']) ? date('d/m/Y à H:i', strtotime($comment['date'])) : '';
                ?>
                <div class="fdap-comment-entry" style="background: #fff; border-left: 5px solid #f59e0b; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: block !important; width: 100% !important; clear: both !important; box-sizing: border-box !important;">
                    <div class="fdap-comment-date" style="font-size: 12px; color: #888; margin-bottom: 8px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                        <?php echo esc_html($date_fmt); ?>
                    </div>


                    <?php if (!empty($comment['text'])): ?>
                    <div class="fdap-comment-text" style="line-height: 1.5; color: #334155; font-size: 14px; word-wrap: break-word; display: block;"><?php echo nl2br(esc_html($comment['text'])); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($comment['audio_id'])): 
                        $audio_url = wp_get_attachment_url($comment['audio_id']);
                        if ($audio_url):
                    ?>
                    <div class="fdap-comment-audio">
                        <audio controls style="max-width: 100%;"><source src="<?php echo esc_url($audio_url); ?>"></audio>
                    </div>
                    <?php endif; endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <header>
            <h1><?php the_title(); ?></h1>
            <p class="fdap-subtitle">(Fiche d'Activité Professionnelle)</p>
        </header>
        
        <!-- Identité de l'élève -->
        <section class="fdap-section">
            <h3 class="fdap-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-top: -2px;"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/></svg>
                Identité de l'élève
            </h3>

            <div class="fdap-section-content">
                <div class="fdap-field">
                    <label class="fdap-field-label">Nom / Prénom <span class="required">*</span></label>
                    <div class="fdap-field-value"><?php echo esc_html($values['nom_prenom'] ?: '—'); ?></div>
                </div>
                <div class="fdap-field">
                    <label class="fdap-field-label">Date de saisie <span class="required">*</span></label>
                    <div class="fdap-field-value"><?php echo esc_html($values['date_de_saisie'] ?: '—'); ?></div>
                </div>
            </div>
        </section>
        
        <!-- Contexte de réalisation -->
        <section class="fdap-section">
            <h3 class="fdap-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-top: -2px;"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                Contexte de réalisation
            </h3>

            <div class="fdap-section-content">
                <div class="fdap-field">
                    <label class="fdap-field-label">Lieu <span class="required">*</span></label>
                    <div class="fdap-field-value"><?php echo esc_html($lieu_labels[$values['lieu_']] ?? $values['lieu_'] ?: '—'); ?></div>
                </div>
                <?php if (!empty($values['enseigne_'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Enseigne / Entreprise</label>
                    <div class="fdap-field-value"><?php echo esc_html($values['enseigne_']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['lieu_specifique'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Lieu spécifique</label>
                    <div class="fdap-field-value"><?php echo esc_html($values['lieu_specifique']); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- Domaine / Compétences -->
        <section class="fdap-section">
            <h3 class="fdap-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-top: -2px;"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10zm0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/><path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>
                Domaine / Compétences
            </h3>

            <div class="fdap-section-content">
                <?php if (!empty($values['domaine'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Domaine</label>
                    <div class="fdap-field-value"><?php echo esc_html($values['domaine']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['competences'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Compétences mobilisées</label>
                    <div class="fdap-field-value"><?php echo nl2br(esc_html($values['competences'])); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- Conditions et ressources -->
        <section class="fdap-section">
            <h3 class="fdap-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-top: -2px;"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm12.5-2.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 1 .5-.5zm-3 3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5z"/></svg>
                Conditions et ressources
            </h3>

            <div class="fdap-section-content">
                <div class="fdap-field">
                    <label class="fdap-field-label">Autonomie (1-5)</label>
                    <div class="fdap-field-value">
                        <?php echo fdap_render_stars($values['autonomie'] ?? 0); ?>
                    </div>
                </div>
                <?php if (!empty($values['materiels'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Matériels / Logiciels</label>
                    <div class="fdap-field-value"><?php echo nl2br(esc_html($values['materiels'])); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['commanditaire'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Commanditaire</label>
                    <div class="fdap-field-value"><?php echo esc_html($values['commanditaire']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['contraintes'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Contraintes</label>
                    <div class="fdap-field-value"><?php echo esc_html($values['contraintes']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['consignes_recues'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Consignes reçues</label>
                    <div class="fdap-field-value"><?php echo nl2br(esc_html($values['consignes_recues'])); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- Descriptif Détaillé -->
        <section class="fdap-section">
            <h3 class="fdap-section-title"><span>📋</span> Descriptif Détaillé</h3>

            <div class="fdap-section-content">
                <?php if (!empty($values['avec_qui_'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Avec qui ?</label>
                    <div class="fdap-field-value"><?php echo esc_html($values['avec_qui_']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['deroulement'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Déroulement</label>
                    <div class="fdap-field-value"><?php echo nl2br(esc_html($values['deroulement'])); ?></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($values['resultats_'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Résultats obtenus</label>
                    <div class="fdap-field-value"><?php echo nl2br(esc_html($values['resultats_'])); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- Bilan Personnel -->
        <section class="fdap-section">
            <h3 class="fdap-section-title"><span>📊</span> Bilan Personnel</h3>

            <div class="fdap-section-content">
                <div class="fdap-field">
                    <label class="fdap-field-label">Difficulté rencontrée (1-5)</label>
                    <div class="fdap-field-value">
                        <?php echo fdap_render_stars($values['difficulte'] ?? 0); ?>
                    </div>
                </div>
                <div class="fdap-field">
                    <label class="fdap-field-label">Plaisir ressenti (1-5)</label>
                    <div class="fdap-field-value">
                        <?php echo fdap_render_stars($values['plaisir_'] ?? 0, '#10b981'); ?>
                    </div>
                </div>
                <?php if (!empty($values['ameliorations'])): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Améliorations possibles</label>
                    <div class="fdap-field-value"><?php echo nl2br(esc_html($values['ameliorations'])); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- Multimédia -->
        <?php if ($audio_id || $video_id || $fichier_id): ?>
        <section class="fdap-section">
            <h3 class="fdap-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-top: -2px;"><path d="M3.5 6.5A.5.5 0 0 1 4 7v1a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5zM5 8a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 0-1h-1A.5.5 0 0 0 5 8zm3.5-.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8a.5.5 0 0 1 .5-.5z"/><path d="M11.5 13a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zM13 10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z"/><path d="M5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-7 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                Multimédia / Explicitation
            </h3>

            <div class="fdap-section-content">
                <?php if ($audio_id): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Audio</label>
                    <div class="fdap-media">
                        <audio controls style="max-width:100%;"><source src="<?php echo esc_url(wp_get_attachment_url($audio_id)); ?>"></audio>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($video_id): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Vidéo</label>
                    <div class="fdap-media">
                        <video controls style="max-width:100%;"><source src="<?php echo esc_url(wp_get_attachment_url($video_id)); ?>"></video>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($fichier_id): ?>
                <div class="fdap-field">
                    <label class="fdap-field-label">Fichier</label>
                    <div class="fdap-media">
                        <a href="<?php echo esc_url(wp_get_attachment_url($fichier_id)); ?>" target="_blank" class="button">📄 Télécharger le fichier</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- Vos Photos -->
        <?php
        $photos = [];
        for ($i = 1; $i <= 6; $i++) {
            $photo_id = get_post_meta($id, '_fdap_photo_' . $i, true);
            if ($photo_id) {
                $photos[] = $photo_id;
            }
        }
        if (!empty($photos)):
        ?>
        <section class="fdap-section">
            <h3 class="fdap-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-top: -2px;"><path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/><path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/></svg>
                Vos Photos
            </h3>

            <div class="fdap-section-content">
                <div class="fdap-photos">
                    <?php foreach ($photos as $photo_id): ?>
                        <div><?php echo wp_get_attachment_image($photo_id, 'medium', false, ['style' => 'border-radius:8px;']); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- Actions -->
        <div class="fdap-actions">
            <a href="<?php echo get_permalink(get_page_by_path('mes-fdap')); ?>" class="fdap-btn-back">← Retour</a>
            <?php if (current_user_can('edit_others_posts') || get_post_field('post_author', $id) == get_current_user_id()): ?>
            <a href="<?php echo add_query_arg('fdap_id', $id, get_permalink(get_page_by_path('fdap-2'))); ?>" class="fdap-btn-edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 6px;"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/></svg>
                Modifier
            </a>
            <?php endif; ?>
            <a href="?export=html" class="fdap-btn-export">📄 Exporter</a>
        </div>
        
        <footer class="fdap-footer">
            Document généré le <?php echo date('d/m/Y'); ?>
        </footer>
        </div> <!-- .fdap-view -->
    </article> <!-- .fdap-main-wrapper -->
<?php
endwhile;


get_footer();