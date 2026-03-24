// Compression avant upload - Optimisé mobile
// Ajout dans acf-dropzone.js

n = Backbone.View.extend({
    ...n.prototype,
    
    // Nouvelle méthode de compression
    compressImage: function(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    
                    // Taille max mobile (800px) ou desktop (1920px)
                    const maxWidth = screen.width < 768 ? 800 : 1920;
                    const quality = screen.width < 768 ? 0.7 : 0.8;
                    
                    let width = img.width;
                    let height = img.height;
                    
                    if (width > maxWidth) {
                        height = Math.round((height * maxWidth) / width);
                        width = maxWidth;
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    // Convertir en JPEG
                    canvas.toBlob((blob) => {
                        const compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    }, 'image/jpeg', quality);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
});
