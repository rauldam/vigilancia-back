// Initialize Dropzone
Dropzone.autoDiscover = false;

document.addEventListener('DOMContentLoaded', function() {
    new Dropzone("#fileUpload", {
        acceptedFiles: ".pdf,.docx,.xlsx",
        maxFilesize: 10, // MB
        createImageThumbnails: false,
        dictDefaultMessage: "Arrastra archivos aquí o haz clic para subir",
        dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo: {{maxFilesize}}MB.",
        dictInvalidFileType: "No puedes subir archivos de este tipo.",
        init: function() {
            this.on("success", function(file, response) {
                console.log("File uploaded successfully");
                location.reload();
            });
            this.on("error", function(file, response) {
                console.error("Error uploading file:", response);
            });
        }
    });
});

// Delete file function
function deleteFile(fileId) {
    if (confirm("¿Estás seguro de que quieres eliminar este archivo?")) {
        fetch(`php/v1/delete_file.php?id=${fileId}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert("Error al eliminar el archivo");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error al eliminar el archivo");
        });
    }
}