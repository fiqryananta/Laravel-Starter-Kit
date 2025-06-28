@extends('backend.app')

@section('vendor-style')

@endsection

@section('page-style')

@endsection

@section('vendor-script')

@endsection

@section('page-script')

    <script>

    $('.select2').select2();

    $('#hide-toggle').click(function() {
        var passwordField = $('#password');
        var passwordFieldType = passwordField.attr('type');
        
        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#eye-icon').html('visibility');
        } else {
            passwordField.attr('type', 'password');
            $('#eye-icon').html('visibility_off');
        }
    });

    $(document).ready(function () {
        $('#form').on('submit', function (e) {
            e.preventDefault();

            $('#submit-btn').prop('disabled', true);
            $('#spinner').removeClass('d-none');
            $('#icon-submit').addClass('d-none');
            $('#btn-text').text('Loading...');

            $.ajax({
                url: "{{ isset($data) ? route('user.edit', $data->id) : route('user.add') }}",
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
            <h3 class="mb-0">Pengguna</h3>

            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center text-decoration-none">
                            <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                            <span class="text-secondary fw-medium hover">Dashboard</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('user.index') }}"><span class="fw-medium">Pengguna</span></a>
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
                    <h3 class="mb-0">{{ isset($data) ? 'Edit' : 'Tambah' }} Pengguna</h3>
                    <a href="{{ route('user.index') }}" class="btn bg-secondary bg-opacity-10 fw-medium text-secondary py-2 px-4"><i class="ri-arrow-left-line"></i> Kembali</a>
                </div>

                <form id="form">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Akses</label>
                                <div class="form-group position-relative">
                                    <select class="select2" name="role" style="width: 100% !important;">
                                        <option value="">Pilih Hak Akses</option>
                                        @foreach ($roles as $row)
                                        <option value="{{ $row->id }}" {{ isset($data) && ($data->getRole()->id ?? null) == $row->id ? 'selected' : '' }}>
                                            {{ $row->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Nama</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark h-55" value="{{ isset($data) ? $data->name : '' }}" placeholder="Masukkan Nama" name="name">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Perusahaan</label>
                                <div class="form-group position-relative">
                                    <select class="select2" name="company" style="width: 100% !important;">
                                        <option value="">Pilih Perusahaan</option>
                                        @foreach ($company as $row)
                                        <option value="{{ $row->id }}" {{ isset($data) && $data->getCompany() == $row->id ? 'selected' : '' }}>
                                            {{ $row->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Email</label>
                                <div class="form-group position-relative">
                                    <input type="email" class="form-control text-dark h-55" value="{{ isset($data) ? $data->email : '' }}" placeholder="Masukkan Email" name="email" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Kata Sandi</label>
                                <div class="input-group h-60 form-control p-0">
                                    <input type="password" class="form-control text-dark h-55" value="" placeholder="Masukkan Kata Sandi" name="password" id="password" autocomplete="new-password">
                                    <div class="input-group-text rounded-3 px-3" id="hide-toggle" style="cursor: pointer;">
                                        <i class="material-symbols-outlined" id="eye-icon">visibility</i>
                                    </div>
                                </div>
                                @if (isset($data))
                                <small>Abaikan Jika Tidak Mengubah Kata Sandi</small>
                                @endif
                            </div>
                        </div>
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