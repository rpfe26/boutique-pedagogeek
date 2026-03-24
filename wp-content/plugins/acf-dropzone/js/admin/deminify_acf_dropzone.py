#!/usr/bin/env python3
import re

with open('/var/www/wordpress/wp-content/plugins/acf-dropzone/js/admin/acf-dropzone.js', 'r') as f:
    content = f.read()

print(f'Taille original: {len(content)} caractères')

compress_function = '''
    compressImage: function(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
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
                    canvas.toBlob((blob) => {
                        const compressedFile = new File([blob], file.name, {type: 'image/jpeg', lastModified: Date.now()});
                        resolve(compressedFile);
                    }, 'image/jpeg', quality);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    },
'''

old_files_added = 'filesAdded:function(e,t){this.total=t.length,this.done=0}'
new_files_added = '''filesAdded:function(e,t){this.total=t.length;this.done=0;let processedCount=0;t.forEach((file,index)=>{if(file.type.match(/^image\//)){this.compressImage(file).then((compressedFile)=>{t[index]=compressedFile;processedCount++;if(processedCount===this.total){this.trigger(compression-complete);}});}});if(processedCount===0){this.trigger(compression-complete);}}'''

content = content.replace(old_files_added, new_files_added)
content = content.replace('filesAdded:function(e,t){', compress_function + 'filesAdded:function(e,t){')

print(f'Taille après modification: {len(content)} caractères')

with open('/var/www/wordpress/wp-content/plugins/acf-dropzone/js/admin/acf-dropzone.js', 'w') as f:
    f.write(content)

print('Mise à jour terminée.')
