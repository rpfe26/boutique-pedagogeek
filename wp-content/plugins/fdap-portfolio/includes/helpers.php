<?php
/**
 * FDAP Portfolio Helpers
 */

defined('ABSPATH') || exit;

/**
 * Compresse une image vers un poids cible (300KB par défaut)
 * 
 * @param string $file_path Chemin complet du fichier
 * @param string $mime_type Type MIME de l'image
 * @param int $max_size Taille maximum en octets (défaut 300KB)
 * @param int $max_dimension Dimension maximum (défaut 1920px)
 * @return array|bool Résultats de la compression ou false en cas d'erreur
 */
function fdap_compress_image_file($file_path, $mime_type, $max_size = 307200, $max_dimension = 1920) {
    if (!class_exists('Imagick')) {
        return false;
    }

    try {
        $image = new Imagick($file_path);
        $image->autoOrient();
        
        // Conversion forcée en JPEG pour une meilleure compression
        if (in_array($mime_type, ["image/png", "image/webp"])) {
            $image->setImageFormat("jpeg");
            $image->setImageBackgroundColor("white");
            $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        } else {
            $image->setImageFormat("jpeg");
        }
        
        // Redimensionnement si nécessaire
        $geometry = $image->getImageGeometry();
        if ($geometry["width"] > $max_dimension || $geometry["height"] > $max_dimension) {
            $image->resizeImage($max_dimension, $max_dimension, Imagick::FILTER_LANCZOS, 1, true);
        }
        
        $quality = 75; // Qualité de départ
        $min_quality = 40;
        $attempts = 0;
        
        // Boucle de compression progressive
        while ($attempts < 10 && $quality >= $min_quality) {
            $image->setImageCompressionQuality($quality);
            $image->stripImage();
            $image->writeImage($file_path);
            
            if (filesize($file_path) <= $max_size) {
                break;
            }
            
            $quality -= 5;
            $attempts++;
        }
        
        // Si toujours trop lourd, réduire les dimensions de 15%
        if (filesize($file_path) > $max_size) {
            $current = $image->getImageGeometry();
            $new_dim = (int)($current["width"] * 0.85);
            if ($new_dim > 800) { // On ne descend pas en dessous de 800px
                $image->resizeImage($new_dim, $new_dim, Imagick::FILTER_LANCZOS, 1, true);
                $image->setImageCompressionQuality(50);
                $image->stripImage();
                $image->writeImage($file_path);
            }
        }
        
        $final_size = filesize($file_path);
        $image->destroy();
        
        return [
            "success" => true,
            "final_size" => $final_size,
            "quality_applied" => $quality
        ];
        
    } catch (Exception $e) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("[FDAP] Erreur de compression : " . $e->getMessage());
        }
        return false;
    }
}
require_once plugin_dir_path(__FILE__) . 'referentiel-cap.php';

/**
 * Calcule les statistiques de validation pour un texte de compétences donné
 */
function fdap_get_validation_stats($competences_text) {
    $referentiel = fdap_get_referentiel_cap();
    $lines = explode("\n", $competences_text);
    $treated = array_map('trim', array_filter($lines));
    
    $total_sub = 0;
    $treated_sub = 0;
    $poles_data = [];

    foreach ($referentiel as $pole) {
        $pole_total = 0;
        $pole_treated = 0;
        $metas_data = [];

        if (!empty($pole['metaCompetences']) && is_array($pole['metaCompetences'])) {
            foreach ($pole['metaCompetences'] as $meta) {
                $meta_total = (isset($meta['subCompetences']) && is_array($meta['subCompetences'])) ? count($meta['subCompetences']) : 0;
                $meta_treated_count = 0;
                $subs_data = [];

                if ($meta_total > 0) {
                    foreach ($meta['subCompetences'] as $sub) {
                        $is_treated = in_array($sub, $treated);
                        if ($is_treated) {
                            $meta_treated_count++;
                        }
                        $subs_data[] = ['label' => $sub, 'treated' => $is_treated];
                    }
                }


            $total_sub += $meta_total;
            $treated_sub += $meta_treated_count;
            $pole_total += $meta_total;
            $pole_treated += $meta_treated_count;

            $metas_data[] = [
                'id' => $meta['id'],
                'label' => $meta['label'],
                'treated_count' => $meta_treated_count,
                'total_count' => $meta_total,
                'subs' => $subs_data
            ];
        }
    }


        $poles_data[] = [
            'id' => $pole['id'],
            'label' => $pole['label'],
            'treated_count' => $pole_treated,
            'total_count' => $pole_total,
            'metas' => $metas_data
        ];

    }

    return [
        'total' => $total_sub,
        'treated' => $treated_sub,
        'percent' => $total_sub > 0 ? round(($treated_sub / $total_sub) * 100) : 0,
        'poles' => $poles_data
    ];
}

/**
 * Affiche une bannière d'impersonation globale
 */
function fdap_render_impersonation_banner() {
    $original_admin_id = isset($_COOKIE['fdap_original_admin_id']) ? (int) $_COOKIE['fdap_original_admin_id'] : 0;
    if ($original_admin_id) {
        $back_url = add_query_arg('fdap_switch_back', '1', home_url());
        ?>
        <div class="fdap-impersonation-banner" style="background: #6366f1; padding: 20px; border-radius: 12px; margin-bottom: 30px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2); font-family: sans-serif; clear: both;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 2rem; background: rgba(255,255,255,0.2); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                </span>
                <div>
                    <strong style="display: block; font-size: 1.2rem;">Mode Aperçu Élève</strong>
                    <span style="opacity: 0.9;">Vous naviguez actuellement avec le compte de cet élève.</span>
                </div>
            </div>
            <a href="<?php echo esc_url($back_url); ?>" class="fdap-btn-exit-role" style="background: #ef4444; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4); transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg>
                QUITTER LE RÔLE ÉLÈVE
            </a>
            <style>
                .fdap-btn-exit-role:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4); filter: brightness(1.1); }
            </style>
        </div>
        <?php
    }
}


/**
 * Affiche l'avancée des compétences pour un élève (Barre + Blocs + Détails)
 */
function fdap_render_competency_tracker($user_id) {
    global $wpdb;
    
    // Récupérer toutes les fiches de l'élève
    $student_fdaps = $wpdb->get_col($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_author = %d AND post_type = 'fdap' AND post_status IN ('publish', 'controlled')", 
        $user_id
    ));
    
    $all_comp_text = "";
    if ($student_fdaps) {
        foreach ($student_fdaps as $fid) {
            $comp = get_post_meta($fid, '_fdap_competences', true);
            if ($comp) {
                $all_comp_text .= $comp . "\n";
            }
        }
    }
    
    $stats = fdap_get_validation_stats($all_comp_text);
    ?>
    <div class="fdap-student-tracker-v2" style="background: white; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; overflow: hidden; font-family: sans-serif;">
        <!-- Global Header -->
        <div style="padding: 25px; background: #fff; border-bottom: 1px solid #f1f5f9;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 12px;">
                <div>
                    <h3 style="margin: 0; font-size: 1.35rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6366f1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10zm0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/><path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>
                        Mon Avancée Globale
                    </h3>
                    <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Référentiel CAP EPC</p>
                </div>
                <div style="text-align: right;">
                    <span style="display: block; font-size: 1.75rem; font-weight: 900; color: #6366f1; line-height: 1;"><?php echo $stats['percent']; ?>%</span>
                    <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 700;"><?php echo $stats['treated']; ?> / <?php echo $stats['total']; ?> validés</span>
                </div>
            </div>
            <div style="height: 14px; background: #f1f5f9; border-radius: 10px; overflow: hidden; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                <div style="width: <?php echo $stats['percent']; ?>%; height: 100%; background: linear-gradient(90deg, #6366f1, #a855f7); transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1); border-radius: 10px;"></div>
            </div>
        </div>

        <!-- Per-Pole Breakdown -->
        <div class="fdap-poles-grid" style="padding: 20px; background: #f8fafc; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">

            <?php foreach ($stats['poles'] as $pole): 
                $pole_percent = $pole['total_count'] > 0 ? round(($pole['treated_count'] / $pole['total_count']) * 100) : 0;
            ?>
                <details class="fdap-pole-details" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: all 0.2s ease;">
                    <summary style="padding: 15px; list-style: none; cursor: pointer; outline: none;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                            <span style="font-weight: 750; font-size: 0.95rem; color: #1e293b; flex: 1; padding-right: 10px;"><?php echo esc_html($pole['label']); ?></span>
                            <span style="font-weight: 800; color: #6366f1; font-size: 0.9rem;"><?php echo $pole_percent; ?>%</span>
                        </div>
                        <div style="height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                            <div style="width: <?php echo $pole_percent; ?>%; height: 100%; background: #6366f1; border-radius: 3px;"></div>
                        </div>
                        <div style="margin-top: 8px; font-size: 0.75rem; color: #64748b; font-weight: 600; text-align: right;">
                            Voir le détail ▾
                        </div>
                    </summary>
                    <div style="padding: 0 15px 15px 15px; border-top: 1px solid #f1f5f9; max-height: 250px; overflow-y: auto;">
                        <?php foreach ($pole['metas'] as $meta): ?>
                            <div style="margin-top: 15px;">
                                <div style="font-size: 0.85rem; font-weight: 800; color: #475569; margin-bottom: 8px; border-left: 3px solid #6366f1; padding-left: 8px;">
                                    <?php echo esc_html($meta['label']); ?>
                                </div>
                                <ul style="margin: 0; padding: 0; list-style: none;">
                                    <?php foreach ($meta['subs'] as $sub): ?>
                                        <li style="display: flex; align-items: flex-start; gap: 8px; font-size: 0.85rem; padding: 8px 0; border-bottom: 1px solid #f1f5f9; color: <?php echo $sub['treated'] ? '#0f172a' : '#475569'; ?>;">
                                            <span style="flex-shrink: 0; margin-top: 2px;">
                                                <?php if ($sub['treated']): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#10b981" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                                                <?php else: ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e2e8f0" viewBox="0 0 16 16"><circle cx="8" cy="8" r="7" stroke="#cbd5e1" stroke-width="1" fill="none"/></svg>
                                                <?php endif; ?>
                                            </span>
                                            <span style="<?php echo $sub['treated'] ? 'font-weight: 700; color: #1e293b;' : 'font-weight: 500;'; ?>"><?php echo esc_html($sub['label']); ?></span>
                                        </li>

                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
    <style>
        .fdap-pole-details[open] { border-color: #6366f1; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1); }
        .fdap-pole-details[open] summary div:last-child { color: #6366f1; font-weight: 800; transform: translateY(2px); }
        .fdap-pole-details summary::-webkit-details-marker { display: none; }
    </style>
    <?php
}

/**
 * Affiche une note sous forme d'étoiles SVG
 */
function fdap_render_stars($rating, $color = '#fbbf24') {
    $rating = (int) $rating;
    $output = '<div class="fdap-stars-svg" style="display: flex; gap: 2px;">';
    for ($i = 1; $i <= 5; $i++) {
        $fill = ($i <= $rating) ? $color : '#e2e8f0';
        $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" style="fill:'.$fill.';">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>';
    }
    $output .= '</div>';
    return $output;
}



