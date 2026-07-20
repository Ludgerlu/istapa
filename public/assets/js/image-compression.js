// public/assets/js/image-compression.js

/**
 * Compresse une image avant l'upload - Optimisé pour SABC
 * Dimensions maximales : 500x1000px pour un poids minimal
 * Adapté pour les visites PSV sur mobile
 */
function compressImage(file, maxWidth = 500, maxHeight = 1000, quality = 0.8) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        
        reader.onload = function(event) {
            const img = new Image();
            
            img.onload = function() {
                // Créer un canvas pour la compression
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;
                
                // Calculer les nouvelles dimensions en gardant le ratio
                // Optimisé pour portrait (photos prises en vertical sur mobile)
                const ratio = Math.min(maxWidth / width, maxHeight / height);
                
                // Ne pas agrandir les petites images
                if (ratio < 1) {
                    width = Math.round(width * ratio);
                    height = Math.round(height * ratio);
                }
                
                // Définir les dimensions du canvas
                canvas.width = width;
                canvas.height = height;
                
                // Dessiner l'image redimensionnée
                const ctx = canvas.getContext('2d');
                
                // Améliorer la qualité du redimensionnement
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                
                ctx.drawImage(img, 0, 0, width, height);
                
                // Convertir en blob avec compression adaptative
                canvas.toBlob(function(blob) {
                    if (blob) {
                        console.log(`Image compressée: ${width}x${height}, ${(blob.size / 1024).toFixed(2)} KB`);
                        resolve(blob);
                    } else {
                        reject(new Error('Impossible de créer le blob'));
                    }
                }, 'image/jpeg', quality);
            };
            
            img.onerror = function() {
                reject(new Error('Erreur lors du chargement de l\'image'));
            };
            
            // Charger l'image
            img.src = event.target.result;
        };
        
        reader.onerror = function() {
            reject(new Error('Erreur lors de la lecture du fichier'));
        };
        
        // Lire le fichier
        reader.readAsDataURL(file);
    });
}

/**
 * Gère le changement de fichier avec compression optimisée
 * Adapté pour les photos de visite PSV
 */
async function handleImageUpload(inputElement, previewElementId) {
    const file = inputElement.files[0];
    
    if (!file) return;
    
    // Afficher un loader
    const previewElement = document.getElementById(previewElementId);
    const loaderDiv = document.getElementById('upload-loader');
    
    if (previewElement) {
        previewElement.style.opacity = '0.5';
    }
    
    if (loaderDiv) {
        loaderDiv.style.display = 'block';
    }
    
    try {
        // Vérifier le type de fichier
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        
        // Gestion spéciale pour HEIC/HEIF (iPhone)
        if (file.type === 'image/heic' || file.type === 'image/heif' || 
            file.name.toLowerCase().endsWith('.heic') || file.name.toLowerCase().endsWith('.heif')) {
            
            alert('Format HEIC détecté. Pour de meilleures performances, activez le format "Le plus compatible" dans Réglages > Appareil photo > Formats sur votre iPhone.');
            inputElement.value = '';
            if (loaderDiv) loaderDiv.style.display = 'none';
            if (previewElement) previewElement.style.opacity = '1';
            return;
        }
        
        // Vérifier la taille maximale (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('La photo est trop volumineuse (max 10MB). Veuillez prendre une photo avec une résolution plus faible.');
            inputElement.value = '';
            if (loaderDiv) loaderDiv.style.display = 'none';
            if (previewElement) previewElement.style.opacity = '1';
            return;
        }
        
        // Paramètres de compression optimisés pour les visites PSV
        let compressionQuality = 0.8;
        let maxDimension = { width: 500, height: 1000 };
        
        // Compression adaptative selon la taille originale
        if (file.size > 3 * 1024 * 1024) { // > 3MB
            compressionQuality = 0.7;
            console.log('Grande image détectée, compression forte appliquée');
        } else if (file.size > 1 * 1024 * 1024) { // > 1MB
            compressionQuality = 0.75;
            console.log('Image moyenne détectée, compression modérée appliquée');
        }
        
        // Adapter selon la connexion réseau si disponible
        if ('connection' in navigator && navigator.connection) {
            const connection = navigator.connection;
            if (connection.effectiveType === '2g' || connection.effectiveType === 'slow-2g') {
                compressionQuality = 0.6;
                maxDimension = { width: 400, height: 800 };
                console.log('Connexion lente détectée, compression maximale');
            }
        }
        
        console.log('Compression en cours...');
        
        const compressedBlob = await compressImage(
            file, 
            maxDimension.width, 
            maxDimension.height, 
            compressionQuality
        );
        
        // Vérifier que la compression a réussi
        if (!compressedBlob || compressedBlob.size === 0) {
            throw new Error('La compression a échoué');
        }
        
        // Générer un nouveau nom de fichier
        const timestamp = new Date().getTime();
        const originalName = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
        const newFileName = `${originalName}_${timestamp}_compressed.jpg`;
        
        // Créer un nouveau fichier à partir du blob compressé
        const compressedFile = new File([compressedBlob], newFileName, {
            type: 'image/jpeg',
            lastModified: Date.now()
        });
        
        // Remplacer le fichier dans l'input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(compressedFile);
        inputElement.files = dataTransfer.files;
        
        // Afficher les informations de compression
        const reduction = ((1 - (compressedFile.size / file.size)) * 100).toFixed(1);
        const compressionInfo = `
            Taille originale: ${(file.size / 1024).toFixed(0)} KB
            Taille compressée: ${(compressedFile.size / 1024).toFixed(0)} KB
            Réduction: ${reduction}%
        `;
        
        console.log('Compression réussie:', compressionInfo);
        
        // Afficher le détail de compression si l'élément existe
        const compressionDetails = document.getElementById('compression-details');
        if (compressionDetails) {
            compressionDetails.innerHTML = compressionInfo.replace(/\n/g, '<br>');
            document.getElementById('compression-info').style.display = 'block';
        }
        
        // Afficher un message à l'utilisateur
        if (window.showToast) {
            window.showToast(`Photo optimisée: ${(compressedFile.size / 1024).toFixed(0)} KB (-${reduction}%)`, 'success');
        }
        
        // Aperçu de l'image
        if (previewElement) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.opacity = '1';
            };
            reader.readAsDataURL(compressedFile);
        }
        
    } catch (error) {
        console.error('Erreur lors du traitement de l\'image:', error);
        alert('Erreur lors du traitement de l\'image. Veuillez réessayer.');
        inputElement.value = '';
        if (previewElement) {
            previewElement.style.opacity = '1';
        }
    } finally {
        // Cacher le loader
        if (loaderDiv) {
            loaderDiv.style.display = 'none';
        }
    }
}

/**
 * Fonction utilitaire pour afficher des messages toast
 */
window.showToast = function(message, type = 'info') {
    // Créer le toast s'il n'existe pas
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
        document.body.appendChild(toastContainer);
    }
    
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show`;
    toast.style.cssText = 'min-width: 250px; margin-bottom: 10px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto-fermer après 5 secondes
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

/**
 * Fonction de compatibilité avec l'ancien système
 */
function Apercu_image_js(inputId) {
    const input = document.getElementById(inputId);
    const previewId = 'apercu_' + inputId;
    
    if (input && input.files && input.files[0]) {
        handleImageUpload(input, previewId);
    }
}