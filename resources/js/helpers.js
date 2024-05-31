export const isImage = (attachment, maxSize = 10) => {
    let mime = attachment.mime || attachment.type;
    mime = mime.split('/');
    const acceptedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const fileExtension = mime[1].toLowerCase();
    const isImageType = mime[0].toLowerCase() === 'image';
    const isValidSize = attachment.size <= maxSize * 1024 * 1024;
    const isAcceptedExtension = acceptedExtensions.includes(fileExtension);

    let errorMessage = '';
    if (!isImageType) {
        errorMessage = 'Arquivo não é uma imagem.';
    } else if (!isValidSize) {
        errorMessage = `Imagem deve ser menor que ${maxSize}MB.`;
    } else if (!isAcceptedExtension) {
        errorMessage = `A extensão ${fileExtension} não é suportada. Apenas ${acceptedExtensions.join(', ')} são permitidas.`;
    }
    return { isValid: isImageType && isValidSize && isAcceptedExtension, error: errorMessage };
}

export const isVideo = (attachment, maxSize = 50) => {
    let mime = attachment.mime || attachment.type;
    mime = mime.split('/');
    const acceptedExtensions = ['avi', 'mp4'];
    const fileExtension = mime[1].toLowerCase();
    const isVideoType = mime[0].toLowerCase() === 'video';
    const isValidSize = attachment.size <= maxSize * 1024 * 1024;
    const isAcceptedExtension = acceptedExtensions.includes(fileExtension);

    let errorMessage = '';
    if (!isVideoType) {
        errorMessage = 'Arquivo não é um vídeo.';
    } else if (!isValidSize) {
        errorMessage = `Vídeo deve ser menor que ${maxSize}MB.`;
    } else if (!isAcceptedExtension) {
        errorMessage = `A extensão ${fileExtension} não é suportada. Apenas ${acceptedExtensions.join(', ')} são permitidas.`;
    }
    return { isValid: isVideoType && isValidSize && isAcceptedExtension, error: errorMessage };

}