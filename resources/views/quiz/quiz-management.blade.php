<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="quiz-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Danh sách câu đố"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"></div>
                        <div class="me-3 my-3 text-end">
                        @if (Auth::user()->level == 'Admin')
                            <button type="button" class="btn bg-gradient-primary mb-0 addQuizModal" data-bs-toggle="modal" data-bs-target="#addQuizModal" >
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Thêm câu đố mới
                            </button>
                        @endif    
                        </div>

                        <div class="card-body px-0 pb-2 ">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 ">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TÊN CÂU ĐỐ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">GỢI Ý</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quizs as $key => $quiz)
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
                                                        <h6 class="mb-0 text-sm viewQuizBtn" data-bs-toggle="modal" data-bs-target="#quizModal" data-quiz="{{ json_encode($quiz) }}">{{ $quiz->name }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $quiz->description }}</h6>
                                                    </div>
                                                </td>
                                               
                                                <td class="align-middle">
                                                    <button type="button" class="btn btn-success btn-link viewQuizBtn" data-bs-toggle="modal" data-bs-target="#quizModal" data-quiz="{{ json_encode($quiz) }}">
                                                        <i class="material-icons">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </button> 
                                                    @if (Auth::user()->level == 'Admin')
                                                    <button type="button" class="btn btn-warning btn-link editQuizBtn" data-bs-toggle="modal" data-bs-target="#editQuizModal" data-quiz="{{ json_encode($quiz) }}">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-link deleteQuizBtn" data-quiz-id="{{ $quiz->id }}">
                                                        <i class="material-icons">delete</i>
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
                        {{ $quizs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<!-- Modal thêm câu đố mới -->
<div class="modal fade" id="addQuizModal" tabindex="-1" aria-labelledby="addQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuizModalLabel">Thêm câu đố mới</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addQuizForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên câu đố:</label>
                        <input type="text" class="form-control border border-2 p-2" id="name" name="name" placeholder="Nhập tên câu đố" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Gợi ý:</label>
                        <input type="text" class="form-control border border-2 p-2" id="description" name="description" placeholder="Nhập mô tả câu đố">
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file:</label>
                        <input type="file" class="form-control border border-2 p-2" id="file" name="file" accept=".txt">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id="addQuizBtn" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Kết thúc modal thêm câu đố -->

<!-- Modal hiển thị thông tin-->
<div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizModalLabel">Thông tin câu đố</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="quizInfo"></div>
                <form method="POST" id="submitQuizForm" action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="quizId" name="quizId" value="">
                    <p><strong>Nhập đán án:</strong>     
                    <p></p>               
                    <input type="text" class="form-control border border-2 p-2" id="answer" name="answer">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success" id="submitQuizBtn">Gửi đáp án</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- Kết thúc Modal hiển thị thông tin-->

<!-- Modal edit thông tin -->
@if (Auth::user()->level === 'Admin')
<div class="modal fade" id="editQuizModal" tabindex="-1" aria-labelledby="editQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuizModalLabel">Chỉnh sửa thông tin câu đố</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editQuizForm" action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="quizId" name="quizId" value="">
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên câu đố:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editName" name="name" placeholder="Nhập tên câu đố" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Gợi ý:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editDescription" name="description" placeholder="Nhập mô tả câu đố" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file:</label>
                        <input type="file" class="form-control border border-2 p-2" id="file" name="file" accept=".txt">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id="editQuizBtn" class="btn btn-primary">Chỉnh sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
 <!-- Kết thúc Modal edit -->

<script src='https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function formatNullOrUndefined(value) {
        return (value === null || value === undefined) ? 'Chưa cập nhật' : value;
    }
    document.querySelectorAll('.viewQuizBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy thông tin người dùng từ thuộc tính data-quiz
            const quizData = JSON.parse(this.getAttribute('data-quiz'));

            // Hiển thị thông tin câu đố trong modal
            document.getElementById('quizInfo').innerHTML = `
                <div class="d-flex justify-content">
                    <div>
                    <p></p>
                    <p><strong>Tên câu đố:</strong> ${formatNullOrUndefined(quizData.name)}</p>
                    <p><strong>Gợi ý:</strong> ${formatNullOrUndefined(quizData.description)}</p>
                    </div>
                </div>
            `;
            document.getElementById('quizId').value = quizData.id;
        });
    });
    $(function() {
            // Thêm mới câu đố
            $("#addQuizForm").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $("#addQuizBtn").text('Đang thêm...');
                $.ajax({
                    url: '{{ route('quiz.store') }}', 
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
                                'Câu đố đã được thêm vào hệ thống!',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });                    
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                response.message || 'Có lỗi xảy ra khi thêm câu đố mới. Vui lòng kiếm tra lại định dạng các trường đã nhập!!',
                                'error'
                            );
                        }
                        $("#addQuizBtn").text('Thêm');
                        $("#addQuizForm")[0].reset();
                        $("#addQuizModal").modal('hide');
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi AJAX
                        Swal.fire(
                            'Đã xảy ra lỗi!',
                            'Có lỗi xảy ra khi thêm câu đố mới.',
                            'error'
                        );
                        console.error(xhr.responseText); 
                        $("#addQuizBtn").text('Thêm');
                    }
                });
            });

            //Gửi yêu cầu update thông tin bài tập
            $("#editQuizForm").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#editQuizBtn").text('Đang cập nhật...');
                const quizId = $("#quizId").val();
                fd.append('quizId', quizId);
                
                $.ajax({
                    url: '{{ route('quiz.update') }}',
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
                                'Thông tin câu đố đã được cập nhật!',
                                'success'
                            ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });    
                        }
                        $("#editQuizBtn").text('Cập nhật câu đố');
                        $("#editQuizForm")[0].reset();
                        $("#editQuizModal").modal('hide');
                    },
                    error: function(xhr, status, error) {
                            // Xử lý lỗi AJAX
                            Swal.fire(
                                'Đã xảy ra lỗi!',
                                'Vui lòng kiểm tra lại định dạng các trường đã nhập!!',
                                'error'
                            );
                            console.error(xhr.responseText);
                            $("#editQuizBtn").text('Chỉnh sửa');
                        }
                });
            });

            // Xử lý sự kiện click nút "Xóa"
            document.querySelectorAll('.deleteQuizBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const quizId = this.getAttribute('data-quiz-id');
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa câu đố này?',
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
                                url: '{{ route('quiz.delete') }}',
                                method: 'DELETE',
                                data: { quizId: quizId, _token: csrfToken },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status == 200) {
                                        Swal.fire(
                                            'Thành công!',
                                            'Câu đố đã được xóa.',
                                            'success'
                                        ).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire(
                                            'Lỗi!',
                                            response.message || 'Có lỗi xảy ra khi xóa câu đố.',
                                            'error'
                                        );
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Xử lý lỗi Ajax
                                    Swal.fire(
                                        'Lỗi!',
                                        'Có lỗi xảy ra khi xóa câu đố.',
                                        'error'
                                    );
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                });
            });

           
            // Gửi yêu cầu submit đáp án
            $("#submitQuizForm").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $("#submitQuizBtn").text('Đang nộp...');
                const quizId = $("#quizId").val();
                formData.append('quizId', quizId);

                $.ajax({
                    url: '{{ route('quiz.submit') }}', 
                    method: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            // Hiển thị thông báo đáp án chính xác kèm nội dung của file
                            Swal.fire({
                                title: 'Đáp án chính xác!!',
                                html: '<pre>' + '<strong>Nội dung:<strong><p></p>' + response.content ,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire(
                                'Đáp án sai!',
                                response.message || 'Vui lòng thử lại với đáp án khác.',
                                'error'
                            );
                        }
                        $("#submitQuizBtn").text('Gửi đáp án');
                        $("#answer").val(''); // Xóa nội dung trường nhập đáp án
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi AJAX
                        Swal.fire(
                            'Đáp án sai!',
                            'Hãy thử lại lần nữa!!',
                            'error'
                        );
                        console.error(xhr.responseText);
                        $("#submitQuizBtn").text('Gửi đáp án');
                    }
                });
            });


        });

        //Hiển thị thông tin cũ trước khi edit
        document.querySelectorAll('.editQuizBtn').forEach(button => {
            button.addEventListener('click', function() {
                const quizData = JSON.parse(this.getAttribute('data-quiz'));
                document.getElementById('editName').value = quizData.name;
                document.getElementById('editDescription').value = quizData.description || '';
                document.getElementById('quizId').value = quizData.id; 
            });
        }); 
</script>