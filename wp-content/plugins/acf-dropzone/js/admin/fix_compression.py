#!/usr/bin/env python3
"""
Correction de acf-dropzone.js - Compression avant upload
"""

import re

# Lire le fichier original
with open('/var/www/wordpress/wp-content/plugins/acf-dropzone/js/admin/acf-dropzone.js', 'r') as f:
    content = f.read()

print(f'Taille original: {len(content)} caractères')

# Fonction compressImage - version courte
compress_function = '''compressImage:function(f){return new Promise((r)=>{const e=new FileReader;e.onload=(t)=>{const i=new Image;i.onload=()=>{const o=document.createElement('canvas'),n=o.getContext('2d'),s=screen.width<768?800:1920,a=screen.width<768?0.7:0.8,l=i.width,c=i.height;l>s&&(c=Math.round(c*s/l),l=s),o.width=l,o.height=c,n.drawImage(i,0,0,l,c),o.toBlob((e=>{const n=new File([e],f.name,{type:"image/jpeg",lastModified:Date.now()});r(n)}),'image/jpeg',a)},i.src=e.target.result};e.readAsDataURL(f)})}'''

# Remplacer filesAdded pour attendre compression
old_files_added = 'filesAdded:function(e,t){this.total=t.length;this.done=0;let processedCount=0;t.forEach((file,index)=>{if(file.type.match(/^image\//)){this.compressImage(file).then((compressedFile)=>{t[index]=compressedFile;processedCount++;if(processedCount===this.total){this.trigger(compression-complete);}});}});if(processedCount===0){this.trigger(compression-complete);}}'

new_files_added = '''filesAdded:function(e,t){this.total=t.length;this.done=0;this._pendingFiles=t.length;this._processedFiles=[];var i=this;if(0===this._pendingFiles)return;t.forEach((function(t,o){if(t.type.match(/^image\//))i.compressImage(t).then((function(n){i._processedFiles[o]=n,0===--i._pendingFiles&&(i.filesToUpload=i._processedFiles,i.trigger("compression-done"))}))}))}}'''

content = content.replace(old_files_added, new_files_added)

# Ajouter compressImage si pas présent dans la classe n
if 'n=Backbone.View.extend' in content and 'compressImage' not in content.split('n=Backbone.View.extend')[1].split('})')[0]:
    pattern = r'(n=Backbone\.View\.extend\(\{)([^}]+)(\})'
    match = re.search(pattern, content)
    if match:
        prefix = match.group(1)
        methods = match.group(2)
        suffix = match.group(3)
        new_methods = 'compressImage:' + compress_function + ',' + methods
        content = content.replace(prefix + methods + suffix, prefix + new_methods + suffix)
        print('compressImage ajoutée')

print(f'Taille après modification: {len(content)} caractères')

with open('/var/www/wordpress/wp-content/plugins/acf-dropzone/js/admin/acf-dropzone.js', 'w') as f:
    f.write(content)

print('Mise à jour terminée.')
