<!-- jQuery -->
<script src="{{ asset('adminlte/') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/') }}/dist/js/adminlte.min.js"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('adminlte/') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- InputMask -->
<script src="{{ asset('adminlte/') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('adminlte/') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<script>
    $(function() {
        bsCustomFileInput.init();
        //Money Euro
        $('[data-mask]').inputmask({
                'alias': 'numeric',
                'groupSeparator': '.',
                'radixPoint': ',',
                'autoGroup': true,
                'digits': 0,
                'prefix': 'Rp ',
                'removeMaskOnSubmit': true
            }),
            $('[phone-number]').inputmask('9999-9999-999999', {
                "placeholder": " ",
                'alias': 'numeric',
                'removeMaskOnSubmit': true
            })
    });
</script>
<script>
    function trxConfirm() {
        // Tampilkan dialog konfirmasi
        var konfirmasi = alert("Pastikan data yang di isi sudah benar, karena tidak dapat diubah");
    }

    function tampilkanModalKonfirmasiSimpanan() {
        // Ambil data yang diinputkan oleh pengguna
        var amount = document.getElementById('amount').value; // Ganti 'field1' dengan ID input yang sesuai
        var nasabahSelect = document.getElementById('nasabah');
        var nasabah = nasabahSelect.options[nasabahSelect.selectedIndex].getAttribute('data-nama');
        var type = document.getElementById('type').value; // Ganti 'field2' dengan ID input yang sesuai
        var desc = document.getElementById('desc').value; // Ganti 'field2' dengan ID input yang sesuai
        var kode = document.getElementById('kode').value;
        var simpanButton = document.getElementById('simpan');
        var simpanButtonModal = document.getElementById('simpanButton');
        var myForm = document.getElementById('form-simpanan');

        // Tampilkan data di dalam modal konfirmasi
        document.getElementById('modal-kode').textContent = kode;
        document.getElementById('modal-nasabah').textContent = nasabah;
        document.getElementById('modal-jumlah').textContent = amount;
        document.getElementById('modal-type').textContent = type;
        document.getElementById('modal-desc').textContent = desc;

        // Mendengarkan kejadian "keydown" di elemen input
        myForm.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Menghentikan aksi default (pengiriman formulir)
                event.stopPropagation(); // Menghentikan penyebaran event keydown
                simpanButtonModal.click(); // Menekan tombol "Simpan" saat "Enter" ditekan
            }
        });

        // Buka modal konfirmasi
        $('#modal-default').modal('show');
    }
</script>
