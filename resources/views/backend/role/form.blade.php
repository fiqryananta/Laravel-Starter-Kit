@extends('backend.app')

@section('vendor-style')

@endsection

@section('page-style')

@endsection

@section('vendor-script')

@endsection

@section('page-script')

    <script>

        $('#form').on('submit', function (e) {
            e.preventDefault();

            $('#submit-btn').prop('disabled', true);
            $('#spinner').removeClass('d-none');
            $('#icon-submit').addClass('d-none');
            $('#btn-text').text('Loading...');

            $.ajax({
                url: "{{ isset($data) ? route('role.edit', $data->id) : route('role.add') }}",
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

        function toggleGroup(group) {
            const isChecked = $(`#group_${group}`).is(':checked');
            $(`.group-${group}`).prop('checked', isChecked);
        }

        $(document).on('change', '[class^="group-"]', function () {
            const group = $(this).attr('class').split(' ')[0].split('-')[1];
            const all = $(`.group-${group}`);
            const checked = all.filter(':checked').length;
            $(`#group_${group}`).prop('checked', checked === all.length);
        });
        
    </script>

@endsection

@section('content')

    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h3 class="mb-0">Role</h3>

            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center text-decoration-none">
                            <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                            <span class="text-secondary fw-medium hover">Dashboard</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('role.index') }}"><span class="fw-medium">Role</span></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span class="fw-medium">{{ isset($role) ? 'Edit' : 'Tambah' }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card bg-white border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ isset($role) ? 'Edit' : 'Tambah' }} Role</h3>
                    <a href="{{ route('role.index') }}" class="btn bg-secondary bg-opacity-10 fw-medium text-secondary py-2 px-4"><i class="ri-arrow-left-line"></i> Kembali</a>
                </div>

                <form id="form">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="label text-secondary">Nama Role</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark h-55" name="name" value="{{ isset($data) ? $data->name : '' }}" placeholder="Masukkan Nama Role">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="default-table-area style-two all-products">
                                <div class="table-responsive">
                                    <label class="label text-secondary">Permission</label>
                                    <table class="table align-middle">
                                        <tbody>
                                        @foreach($permissions as $group => $items)
                                            <tr>
                                                <td class="text-secondary align-top" style="min-width: 150px;">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="group_{{ $group }}"
                                                            onclick="toggleGroup('{{ $group }}')">
                                                        <label class="form-check-label" for="group_{{ $group }}">
                                                            {{ $group }}
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">
                                                    @foreach($items as $perm)
                                                    @php
                                                        $isChecked = in_array($perm->name, $rolePermissions ?? []);
                                                    @endphp
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input group-{{ $group }}" type="checkbox"
                                                                name="permissions[]" value="{{ $perm->name }}"
                                                                id="perm_{{ $perm->id }}"
                                                                {{ $isChecked ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="perm_{{ $perm->id }}">
                                                                {{ $perm->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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