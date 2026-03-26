/**
 * Fonctions utilitaires pour le formulaire FDAP
 * - Auto-expansion des zones de texte (Textareas)
 */
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.fdap-form textarea');
        
        function autoExpand(textarea) {
            // Sauvegarder la position du scroll pour éviter les sauts
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            textarea.style.height = 'auto';
            const height = textarea.scrollHeight;
            textarea.style.height = (height + 2) + 'px';
            
            // Restaurer le scroll
            if (window.scrollTo) {
                window.scrollTo(0, scrollTop);
            }
        }

        textareas.forEach(textarea => {
            // Ajouter un événement input pour le redimensionnement dynamique
            textarea.addEventListener('input', function() {
                autoExpand(this);
            });
            
            // Redimensionnement initial au chargement
            // On utilise un petit délai pour s'assurer que les styles sont appliqués
            setTimeout(() => autoExpand(textarea), 100);
            
            // On permet aussi le redimensionnement manuel vertical si besoin
            textarea.style.overflowY = 'hidden';
        });

        // Gérer le redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            textareas.forEach(textarea => autoExpand(textarea));
        });
    });
})();
