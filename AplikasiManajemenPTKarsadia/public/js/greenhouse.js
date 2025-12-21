document.addEventListener('DOMContentLoaded', function() {
    // modal edit
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-name');
            const alamat = this.getAttribute('data-alamat');
            const status = this.getAttribute('data-status');

            // isi value pada form edit

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-alamat').value = alamat;
            document.getElementById('edit-status').value = status;
            const formEdit = document.querySelector('#formEditGH');
            formEdit.action = '/greenhouse/update/' + id;
        });
    });

    // modal hapus
    const hapusButtons = document.querySelectorAll('.delete-btn');
    hapusButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            document.getElementById('hapusId').value = id;

            const formHapus = document.querySelector('#formHapusGH');
            formHapus.action = '/greenhouse/delete/' + id;
        });
    });
});