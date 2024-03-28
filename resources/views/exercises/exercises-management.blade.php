<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="exercises-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Danh sách bài tập"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"></div>
                        <div class="me-3 my-3 text-end">
                        @if (Auth::user()->level == 'Admin')
                            <button type="button" class="btn bg-gradient-primary mb-0 addExerciseModal" data-bs-toggle="modal" data-bs-target="#addExerciseModal" >
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Thêm bài tập mới
                            </button>
                        @endif    
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TÊN BÀI TẬP</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">MÔ TẢ</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NGÀY HẾT HẠN</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exercises as $key => $exercise)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-sm">{{ $key + 1 }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6> <a href="{{ route('user-profile', ['id' => $exercise->id]) }}" class="mb-0 text-sm">{{ $exercise->name }}</a></h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $exercise->description }}</h6>
                                                    </div>
                                                </td>
                                               
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $exercise->duration }}</span>
                                                </td>
                                                <td class="align-middle ">
                                                    {{-- <button type="button" class="btn btn-success btn-link viewExerciseBtn" data-bs-toggle="modal" data-bs-target="#exerciseModal" data-exercise="{{ json_encode($exercise) }}">
                                                        <i class="material-icons">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </button> --}}
                                                    @if (Auth::user()->level == 'Admin')
                                                    <button type="button" class="btn btn-warning btn-link editExerciseBtn" data-bs-toggle="modal" data-bs-target="#editExerciseModal" data-exercise="{{ json_encode($exercise) }}">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-link deleteExerciseBtn" data-exercise-id="{{ $exercise->id }}">
                                                        <i class="material-icons">close</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $exercises->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<!-- Modal thêm bài mới -->
<div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExerciseModalLabel">Thêm bài tập mới</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addExerciseForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên bài tập:</label>
                        <input type="text" class="form-control border border-2 p-2" id="name" name="name" placeholder="Nhập tên bài tập" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <input type="text" class="form-control border border-2 p-2" id="description" name="description" placeholder="Nhập mô tả bài tập">
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Chọn ngày hết hạn nộp:</label>
                        <input type="date" class="form-control border border-2 p-2" id="duration" name="duration">
                    </div>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file:</label>
                        <input type="file" class="form-control border border-2 p-2" id="file" name="file" accept=".pdf, .docx">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id="addExerciseBtn" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Kết thúc modal thêm bài tập mới -->

<!-- Modal edit bài tập -->
<div class="modal fade" id="editExerciseModal" tabindex="-1" aria-labelledby="editExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExerciseModalLabel">Chỉnh sửa thông tin bài tập</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editExerciseForm" action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="exerciseId" name="exerciseId" value="">
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên bài tập:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editName" name="name" placeholder="Nhập tên bài tập" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editDescription" name="description" placeholder="Nhập mô tả bài tập" required>
                    </div>
                    
                  
                    <div class="mb-3">
                        <label for="duration" class="form-label">Chọn ngày hết hạn nộp:</label>
                        <input type="date" class="form-control border border-2 p-2" id="editDuration" name="duration">
                    </div>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file:</label>
                        <input type="file" class="form-control border border-2 p-2" id="editFile" name="file">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id="editExerciseBtn" class="btn btn-primary">Chỉnh sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Kết thúc Modal edit -->

<script src='https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //Hiển thị thông tin cũ trước khi edit
    document.querySelectorAll('.editExerciseBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy thông tin người dùng từ thuộc tính data-exercise
            const exerciseData = JSON.parse(this.getAttribute('data-exercise'));
            document.getElementById('editName').value = exerciseData.name;
            document.getElementById('editDescription').value = exerciseData.description || '';
            document.getElementById('editDuration').value = exerciseData.duration; 
            document.getElementById('exerciseId').value = exerciseData.id; 
        });
    });

    $(function() {
    // Thêm mới bài tập
    $("#addExerciseForm").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $("#addExerciseBtn").text('Đang thêm...');

        $.ajax({
            url: '{{ route('exercises.store') }}', 
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    Swal.fire(
                        'Thành công!',
                        'Bài mới đã được thêm vào hệ thống!',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });                    
                } else {
                    Swal.fire(
                        'Lỗi!',
                        response.message || 'Có lỗi xảy ra khi thêm bài mới.',
                        'error'
                    );
                }
                $("#addExerciseBtn").text('Thêm');
                $("#addExerciseForm")[0].reset();
                $("#addExerciseModal").modal('hide');
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi AJAX
                Swal.fire(
                    'Đã xảy ra lỗi!',
                    'Có lỗi xảy ra khi thêm bài mới.',
                    'error'
                );
                console.error(xhr.responseText); 
                $("#addExerciseBtn").text('Thêm');
            }
        });
    });

    //Gửi yêu cầu update thông tin bài tập
    $("#editExerciseForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#editExerciseBtn").text('Đang cập nhật...');
        const exerciseId = $("#exerciseId").val();
        fd.append('exerciseId', exerciseId);
        
        $.ajax({
            url: '{{ route('exercises.update') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    Swal.fire(
                        'Thành công',
                        'Thông tin bài tập đã được cập nhật!',
                        'success'
                    ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });    
                }
                $("#editExerciseBtn").text('Cập nhật bài tập');
                $("#editExerciseForm")[0].reset();
                $("#editExerciseModal").modal('hide');
            },
            error: function(xhr, status, error) {
                    // Xử lý lỗi AJAX
                    Swal.fire(
                        'Đã xảy ra lỗi!',
                        'Vui lòng kiểm tra lại thông tin vừa nhập.',
                        'error'
                    );
                    console.error(xhr.responseText);
                    $("#editExerciseBtn").text('Chỉnh sửa');
                }
        });
    });

    // Xử lý sự kiện click nút "Xóa"
    document.querySelectorAll('.deleteExerciseBtn').forEach(button => {
        button.addEventListener('click', function() {
            const exerciseId = this.getAttribute('data-exercise-id');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa bài này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lấy CSRF token từ thẻ meta
                    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                    $.ajax({
                        url: '{{ route('exercises.delete') }}',
                        method: 'DELETE',
                        data: { exerciseId: exerciseId, _token: csrfToken },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire(
                                    'Thành công!',
                                    'Bài tập đã được xóa.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    response.message || 'Có lỗi xảy ra khi xóa bài tập.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Xử lý lỗi Ajax
                            Swal.fire(
                                'Lỗi!',
                                'Có lỗi xảy ra khi xóa bài tập.',
                                'error'
                            );
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    });

});


</script>