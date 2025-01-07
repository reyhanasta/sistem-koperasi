<!-- jQuery -->
<script src="{{ asset('adminlte/') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/') }}/plugins/select2/js/select2.full.min.js"></script>
<!-- Ekko Lightbox -->
<script src="{{ asset('adminlte/') }}/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="{{ asset('adminlte/') }}/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/') }}/dist/js/adminlte.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('adminlte/') }}/plugins/chart.js/Chart.min.js"></script>
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
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })


    //MENGAMBIL SALDO NASABAH
    $(document).ready(function() {
        $('#selectNasabah').on('change', function() {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: '/saldoNasabah/' + id, // Adjusted URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data[0].balance); // Log the data for debugging
                        $('#balance').val(
                            data[0].balance); // Set the value to the input field
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors for debugging
                    }
                });
            }
        });
    });
   


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
             
                'autoGroup': true,
                'digits': 0,
                'prefix': 'Rp ',
                'removeMaskOnSubmit': true
            }),
            $('[phone-number]').inputmask('9999-9999-999999', {
                "placeholder": " ",
                'alias': 'numeric',
                'removeMaskOnSubmit': true
            }),
            $('#ktp').inputmask('99 99 99 999999 9999', {
                "placeholder": " ",
                'removeMaskOnSubmit': true
            });
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
        document.getElementById('modal-type').textContent = type.charAt(0).toUpperCase() + type.slice(1);
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
<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({
            gutterPixels: 3
        });
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    })
</script>
<script>
    // Pastikan pesan 'success' dari session ada
    @if (session('success'))
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        toastr.success('{{ session('success') }}')
    @endif
    @if (session('error'))
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        toastr.warning('{{ session('error') }}')
    @endif

    $('#deleteData').on('click', function(e) {
        console.log('hey');
        e.preventDefault();
        var form = $(this).parents('form');
        Swal.fire({
            title: 'Apakah yakin akna menghapus data ini?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                ).then(() => {
                    form.submit();
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#nasabah').change(function() {
            var selectedUserId = $(this).val();

            console.log(selectedUserId);
        });
    });
</script>
<script>
    document.getElementById('angsuran-button').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan membayar angsuran!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, bayar!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('angsuran-form').submit();
            }
        })
    });
    
    document.getElementById('lunasi-button').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan melunasi pinjaman!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lunasi!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('lunasi-form').submit();
            }
        })
    });
</script>