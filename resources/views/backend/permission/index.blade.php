@extends('backend.app')

@section('vendor-style')

@endsection

@section('page-style')

@endsection

@section('vendor-script')

@endsection

@section('page-script')

    <script>

        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: "{{ route('permission.index') }}",
                type: 'POST'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'group', name: 'group', orderable: false, searchable: false },
                { data: 'detail', name: 'detail' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.delete-btn', function () {

            Swal.fire({
                title: 'Hapus Data',
                text: "Anda Yakin Untuk Hapus Data Ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.showLoading();
                            
                    let id = $(this).data('id');
                    let url = '{{ route("permission.delete", ":id") }}';
                    url = url.replace(':id', id);
                    
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {

                                Swal.fire({
                                    icon: "success",
                                    title: 'Berhasil',
                                    text: response.message || 'Data Berhasil Dihapus'
                                }).then((result) => {
                                    $('#table').DataTable().ajax.reload();
                                })

                            } else {

                                Swal.fire({
                                    icon: "error",
                                    title: 'Data Gagal Dihapus',
                                    text: response.message || 'Silahkan Coba Lagi',
                                })
                            }

                        },
                        error: function (xhr) {

                            Swal.fire({
                                icon: "error",
                                title: 'Data Gagal Dihapus',
                                html: xhr.responseJSON.message || 'Silahkan Coba Lagi',
                            })

                        }
                    });

                }
            })

        });

    </script>

@endsection

@section('content')

    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h3 class="mb-0">Permission</h3>

            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center text-decoration-none">
                            <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                            <span class="text-secondary fw-medium hover">Dashboard</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('permission.index') }}"><span class="fw-medium">Permission</span></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span class="fw-medium">List</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">List Permission</h3>
                    <a href="{{ route('permission.add') }}" class="btn btn-primary fw-medium text-white py-2 px-4"><i class="ri-add-line"></i> Tambah</a>
                </div>

                <div class="default-table-area all-products">
                    <div class="app-datatable-default overflow-auto">
                        <table class="display app-data-table default-data-table" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Grup</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection