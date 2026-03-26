<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        body { background: #f1f5f9 !important; padding: 20px !important; margin: 0 !important; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important; }
        .fdap-main-wrapper { max-width: 900px !important; margin: 20px auto !important; }
    </style>
</head>
<body <?php body_class(); ?>>
<?php

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
    ?>
    <article id="fdap-<?php the_ID(); ?>" class="fdap-main-wrapper fdap-single-container">
    <div class="fdap-fiche-card">
        <div class="fdap-view">

            <!-- Actions du haut -->
            <div class="fdap-single-header-actions">
                <div class="fdap-header-left">
                    <a href="<?php echo get_permalink(get_page_by_path('mes-fdap')); ?>" class="fdap-btn-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
                        Retour Dashboard
                    </a>
                </div>
                <div class="fdap-header-right">
                    <?php if (current_user_can('edit_others_posts') || get_post_field('post_author', $id) == get_current_user_id()): ?>
                    <a href="<?php echo add_query_arg('fdap_id', $id, get_permalink(get_page_by_path('fdap-2'))); ?>" class="fdap-header-btn fdap-btn-edit-main">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/></svg>
                        Modifier la fiche
                    </a>
                    <?php endif; ?>
                    <a href="?export=html" class="fdap-header-btn fdap-btn-export-main">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/></svg>
                        Exporter (.html)
                    </a>
                </div>
            </div>

            <?php if ($status === 'controlled'): ?>
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
            
            <?php if (!empty($fdap_comments) && is_array($fdap_comments)): 
                $fdap_comments = array_reverse($fdap_comments);
            ?>
            <div class="fdap-comments-teacher">
                <h3>📝 Commentaires du Professeur</h3>
                <div class="fdap-comments-list">
                    <?php foreach ($fdap_comments as $comment): 
                        $date_fmt = isset($comment['date']) ? date('d/m/Y à H:i', strtotime($comment['date'])) : '';
                    ?>
                    <div class="fdap-comment-entry">
                        <div class="fdap-comment-date">📅 <?php echo esc_html($date_fmt); ?></div>
                        <?php if (!empty($comment['text'])): ?>
                        <div class="fdap-comment-text"><?php echo nl2br(esc_html($comment['text'])); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($comment['audio_id'])): 
                            $audio_url = wp_get_attachment_url($comment['audio_id']);
                            if ($audio_url):
                        ?>
                        <div class="fdap-comment-audio">
                            <audio controls><source src="<?php echo esc_url($audio_url); ?>"></audio>
                        </div>
                        <?php endif; endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <header class="fdap-single-header">
                <h1><?php the_title(); ?></h1>
                <p class="fdap-subtitle">Fiche d'Activité Professionnelle</p>
            </header>
            
            <section class="fdap-section">
                <h3 class="fdap-section-title">👤 Identité de l'élève</h3>
                <div class="fdap-section-content">
                    <div class="fdap-field"><label class="fdap-field-label">Nom / Prénom</label><div class="fdap-field-value"><?php echo esc_html($values['nom_prenom'] ?: '—'); ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Date de saisie</label><div class="fdap-field-value"><?php echo esc_html($values['date_de_saisie'] ?: '—'); ?></div></div>
                </div>
            </section>
            
            <section class="fdap-section">
                <h3 class="fdap-section-title">📍 Contexte de réalisation</h3>
                <div class="fdap-section-content">
                    <div class="fdap-field"><label class="fdap-field-label">Lieu</label><div class="fdap-field-value"><?php echo esc_html($lieu_labels[$values['lieu_']] ?? $values['lieu_'] ?: '—'); ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Enseigne / Entreprise</label><div class="fdap-field-value"><?php echo esc_html($values['enseigne_'] ?: '—'); ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Lieu spécifique</label><div class="fdap-field-value"><?php echo esc_html($values['lieu_specifique'] ?: '—'); ?></div></div>
                </div>
            </section>
            
            <section class="fdap-section">
                <h3 class="fdap-section-title">🎓 Domaine / Compétences</h3>
                <div class="fdap-section-content">
                    <div class="fdap-field"><label class="fdap-field-label">Domaine</label><div class="fdap-field-value"><?php echo esc_html($values['domaine'] ?: '—'); ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Compétences mobilisées</label><div class="fdap-field-value"><?php echo !empty($values['competences']) ? nl2br(esc_html($values['competences'])) : '—'; ?></div></div>
                </div>
            </section>
            
            <section class="fdap-section">
                <h3 class="fdap-section-title">⚡ Conditions et ressources</h3>
                <div class="fdap-section-content">
                    <div class="fdap-field"><label class="fdap-field-label">Autonomie (1-5)</label><div class="fdap-field-value"><?php echo fdap_render_stars($values['autonomie'] ?? 0); ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Matériels / Logiciels</label><div class="fdap-field-value"><?php echo !empty($values['materiels']) ? nl2br(esc_html($values['materiels'])) : '—'; ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Commanditaire</label><div class="fdap-field-value"><?php echo esc_html($values['commanditaire'] ?: '—'); ?></div></div>
                </div>
            </section>
            
            <section class="fdap-section">
                <h3 class="fdap-section-title">📋 Descriptif Détaillé</h3>
                <div class="fdap-section-content">
                    <div class="fdap-field"><label class="fdap-field-label">Déroulement</label><div class="fdap-field-value"><?php echo !empty($values['deroulement']) ? nl2br(esc_html($values['deroulement'])) : '—'; ?></div></div>
                    <div class="fdap-field"><label class="fdap-field-label">Résultats obtenus</label><div class="fdap-field-value"><?php echo !empty($values['resultats_']) ? nl2br(esc_html($values['resultats_'])) : '—'; ?></div></div>
                </div>
            </section>

            <section class="fdap-section">
                <h3 class="fdap-section-title">🎥 Multimédia</h3>
                <div class="fdap-section-content">
                    <?php if ($audio_id): ?><div class="fdap-media"><label class="fdap-field-label">Audio</label><audio controls><source src="<?php echo esc_url(wp_get_attachment_url($audio_id)); ?>"></audio></div><?php endif; ?>
                    <?php if ($video_id): ?><div class="fdap-media"><label class="fdap-field-label">Vidéo</label><video controls style="max-width:100%;"><source src="<?php echo esc_url(wp_get_attachment_url($video_id)); ?>"></video></div><?php endif; ?>
                    <?php if ($fichier_id): ?><div class="fdap-media"><label class="fdap-field-label">Fichier joint</label><br><a href="<?php echo esc_url(wp_get_attachment_url($fichier_id)); ?>" target="_blank" class="fdap-btn-file">📄 Ouvrir le fichier joint</a></div><?php endif; ?>
                    <?php if (!$audio_id && !$video_id && !$fichier_id): ?><div class="fdap-field-value">— Aucun fichier joint</div><?php endif; ?>
                </div>
            </section>
            
            <section class="fdap-section">
                <h3 class="fdap-section-title">📸 Photos de l'activité</h3>
                <div class="fdap-section-content">
                    <?php
                    $photos = [];
                    for ($i = 1; $i <= 6; $i++) {
                        $photo_id = get_post_meta($id, '_fdap_photo_' . $i, true);
                        if ($photo_id) $photos[] = $photo_id;
                    }
                    if (!empty($photos)):
                    ?>
                    <div class="fdap-photos">
                        <?php foreach ($photos as $photo_id): ?>
                            <div><?php echo wp_get_attachment_image($photo_id, 'large'); ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="fdap-field-value">— Aucune photo ajoutée</div>
                    <?php endif; ?>
                </div>
            </section>
        
            <footer class="fdap-footer">
                Document généré le <?php echo date('d/m/Y'); ?>
            </footer>
        </div>
    </div>
    </article>
<?php
endwhile;
wp_footer();
?>
</body>
</html>