@extends('backend.app')

@section('vendor-style')

@endsection

@section('page-style')

@endsection

@section('vendor-script')

@endsection

@section('page-script')

    <script>

    $(document).ready(function () {
        $('#form').on('submit', function (e) {
            e.preventDefault();

            $('#submit-btn').prop('disabled', true);
            $('#spinner').removeClass('d-none');
            $('#icon-submit').addClass('d-none');
            $('#btn-text').text('Loading...');

            $.ajax({
                url: "{{ isset($data) ? route('permission.edit', $data->id) : route('permission.add') }}",
                method: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {

                    if (response.success) {

                        Swal.fire({
                            icon: "success",
                            title: 'Berhasil',
                            text: response.message || 'Silahkan Klik Untuk Melanjutkan'
                        }).then((result) => {
                            window.location.href = response.data.redirectTo;
                        })

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: 'Gagal',
                            text: response.message || 'Silahkan Coba Lagi',
                        })

                    }

                },
                error: function (xhr) {

                    Swal.fire({
                        icon: "error",
                        title: 'Gagal',
                        html: xhr.responseJSON.message || 'Silahkan Coba Lagi',
                    })
                    
                    $('#submit-btn').prop('disabled', false);
                    $('#spinner').addClass('d-none');
                    $('#icon-submit').removeClass('d-none');
                    $('#btn-text').text('Masuk');

                },
                complete: function () {
                    $('#submit-btn').prop('disabled', false);
                    $('#spinner').addClass('d-none');
                    $('#icon-submit').removeClass('d-none');
                    $('#btn-text').text('Masuk');
                }
            });
        });
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
                        <span class="fw-medium">{{ isset($data) ? 'Edit' : 'Tambah' }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ isset($data) ? 'Edit' : 'Tambah' }} Permission</h3>
                    <a href="{{ route('permission.index') }}" class="btn bg-secondary bg-opacity-10 fw-medium text-secondary py-2 px-4"><i class="ri-arrow-left-line"></i> Kembali</a>
                </div>

                <form id="form">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Nama Permission</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark h-55" value="{{ isset($data) ? $data->name : '' }}" placeholder="Masukkan Nama Permission" name="name">
                                </div>
                            </div>
                        </div>
                        @if (!isset($data))
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="default_permission" id="default_permission">
                                    <label class="form-check-label" for="default_permission">
                                        Default Permission
                                    </label>
                                </div>
                                <p>
                                    - {permission}-index<br>
                                    - {permission}-create<br>
                                    - {permission}-edit<br>
                                    - {permission}-delete<br>
                                </p>
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <button class="btn btn-primary fw-medium py-2 px-3 float-end" id="submit-btn">
                                    <div class="d-flex align-items-center justify-content-center py-1">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="spinner"></span>
                                        <i id="icon-submit" class="material-symbols-outlined text-white fs-20 me-2">send</i>
                                        <span id="btn-text">Simpan</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

@endsection