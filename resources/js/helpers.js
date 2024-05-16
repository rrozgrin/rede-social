export const isImageOrVideo = (attachment) => {
    let mime = attachment.mime || attachment.type
    mime = mime.split('/')
    const fileType = mime[0].toLowerCase();
    return fileType === 'image' || fileType === 'video';    
}