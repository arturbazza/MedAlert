document.addEventListener('DOMContentLoaded', function () {
    const deleteLinks = document.querySelectorAll('.delete-link');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            if (!confirm('Tem certeza de que deseja excluir este item?')) {
                event.preventDefault();
            }
        });
    });
});
