<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Quản lí người dùng"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"></div>
                        <div class="me-3 my-3 text-end">
                            <button type="button" class="btn bg-gradient-dark mb-0 addUserModal" data-bs-toggle="modal" data-bs-target="#addUserModal" >
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Thêm người dùng mới
                            </button>
                            
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AVATAR</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TÊN ĐĂNG NHẬP</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">HỌ TÊN</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">EMAIL</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CHỨC VỤ</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $key => $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-sm">{{ $key + 1 }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="assets/img/avatar_user/{{$user->avatar}}" class="avatar avatar-lg me-3 border-radius-lg" alt="{{ $user->name }}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->username }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->level }}</span>
                                                </td>
                                                <td class="align-middle float-end">
                                                    <button type="button" class="btn btn-success btn-link viewUserBtn" data-bs-toggle="modal" data-bs-target="#userModal" data-user="{{ json_encode($user) }}">
                                                        <i class="material-icons">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-link editUserBtn" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user="{{ json_encode($user) }}">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title="">
                                                        <i class="material-icons">close</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<!-- Modal thêm người dùng mới -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <input type="hidden" name="emp_avatar" id="emp_avatar">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập:</label>
                        <input type="text" class="form-control border border-2 p-2" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control border border-2 p-2" id="name" name="name" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu:</label>
                        <input type="password" class="form-control border border-2 p-2" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control border border-2 p-2" id="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control border border-2 p-2" id="phone" name="phone" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="mb-3">
                        <label for="newLevel" class="form-label">Chức vụ:</label>
                        <select class="form-select border border-2 p-2" id="level" name="level">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Chọn avatar</label>
                        <input type="file" class="form-control border border-2 p-2" id="avatar" name="avatar" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id="addUserBtn" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Kết thúc modal thêm user -->

<!-- Modal hiển thị thông tin-->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Thông tin người dùng</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="userInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Kết thúc Modal hiển thị thông tin-->

 <!-- Modal edit thông tin -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Chỉnh sửa thông tin người dùng</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editUserForm" action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="userId" name="userId" value="">
                    <div class="mb-3 border-bottom ">
                        <label for="username" class="form-label">Tên đăng nhập:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editUsername" name="username" placeholder="Nhập tên đăng nhập" required>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="name" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editName" name="name" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control border border-2 p-2" id="editEmail" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editPhone" name="phone" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="editLocation" class="form-label">Nơi ở:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editLocation" name="location" placeholder="Nhập nơi ở">
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="editAbout" class="form-label">Tiểu sử:</label>
                        <textarea class="form-control border border-2 p-2" id="editAbout" name="about" rows="3" placeholder="Nhập tiểu sử"></textarea>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="editLevel" class="form-label">Chức vụ:</label>
                        <select class="form-select" id="editLevel" name="level">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Chọn avatar mới:</label>
                        <input type="file" class="form-control border border-2 p-2" id="editAvatar" name="avatar" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id="editUserBtn"class="btn btn-primary" ">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Kết thúc Modal edit thông tin -->

<!-- Script để xử lý sự kiện click và hiển thị modal -->
<script src='https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Hàm kiểm tra giá trị null và thay thế
    function formatNullOrUndefined(value) {
        return (value === null || value === undefined) ? 'Chưa cập nhật' : value;
    }

    // Bắt sự kiện click trên nút "Xem"
    document.querySelectorAll('.viewUserBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy thông tin người dùng từ thuộc tính data-user
            const userData = JSON.parse(this.getAttribute('data-user'));

            // Chuyển đổi định dạng ngày
            const createdDate = new Date(userData.created_at);
            const formattedDate = `${createdDate.getDate()}/${createdDate.getMonth() + 1}/${createdDate.getFullYear()}`;

            // Hiển thị thông tin người dùng trong modal
            document.getElementById('userInfo').innerHTML = `
                <div class="d-flex justify-content-center">
                    <img src="assets/img/avatar_user/${userData.avatar}" class="w-40 border-radius-lg shadow-sm" alt="${userData.name}">
                </div>
                <div class="d-flex justify-content-center">
                    <div>
                    <p></p>
                    <p><strong>Tên đăng nhập:</strong> ${formatNullOrUndefined(userData.username)}</p>
                    <p><strong>Họ và tên:</strong> ${formatNullOrUndefined(userData.name)}</p>
                    <p><strong>Email:</strong> ${formatNullOrUndefined(userData.email)}</p>
                    <p><strong>Số điện thoại:</strong> ${formatNullOrUndefined(userData.phone)}</p>
                    <p><strong>Nơi ở:</strong> ${formatNullOrUndefined(userData.location)}</p>
                    <p><strong>Tiểu sử:</strong> ${formatNullOrUndefined(userData.about)}</p>
                    <p><strong>Ngày tạo:</strong> ${formattedDate}</p>
                    <p><strong>Chức vụ:</strong> ${formatNullOrUndefined(userData.level)}</p>
                    </div>
                </div>
            `;
        });
    });

    //  <!-- Hiển thị thông tin cũ trước khi edit -->
    document.querySelectorAll('.editUserBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy thông tin người dùng từ thuộc tính data-user
            const userData = JSON.parse(this.getAttribute('data-user'));
            document.getElementById('editUsername').value = userData.username;
            document.getElementById('editName').value = userData.name;
            document.getElementById('editEmail').value = userData.email;
            document.getElementById('editPhone').value = userData.phone || ''; // Nếu không có số điện thoại, để trống
            document.getElementById('editLocation').value = userData.location || ''; // Nếu không có nơi ở, để trống
            document.getElementById('editAbout').value = userData.about || ''; // Nếu không có tiểu sử, để trống
            document.getElementById('editLevel').value = userData.level;
            document.getElementById('userId').value = userData.id; 
        });
    });

    //Gửi yêu cầu thêm mới user
    $(function() {
        // Thêm mới người dùng
        $("#addUserForm").submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $("#addUserBtn").text('Đang thêm...');

            $.ajax({
                url: '{{ route('store') }}',
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
                            'Người dùng mới đã được thêm vào hệ thống!',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('user-management') }}';
                            }
                        });                    
                    } else {
                        Swal.fire(
                            'Lỗi!',
                            response.message || 'Có lỗi xảy ra khi thêm người dùng mới.',
                            'error'
                        );
                    }
                    $("#addUserBtn").text('Thêm');
                    $("#addUserForm")[0].reset();
                    $("#addUserModal").modal('hide');
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi AJAX
                    Swal.fire(
                        'Đã xảy ra lỗi!',
                        'Username hoặc Email đã tồn tại (Độ dài Username tối thiểu 6 kí tự và tối đa 20 kí tự.)',
                        'error'
                    );
                    console.error(xhr.responseText);
                    $("#addUserBtn").text('Thêm');
                }
            });
        });
    });

    //Gửi yêu cầu update thông tin user
    $("#editUserForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#editUserBtn").text('Đang cập nhật...');
        const userId = $("#userId").val();
        fd.append('userId', userId);
        
        $.ajax({
            url: '{{ route('update') }}',
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
                        'Thông tin người dùng đã được cập nhật!',
                        'success'
                    ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('user-management') }}';
                            }
                        });    
                }
                $("#editUserBtn").text('Cập nhật người dùng');
                $("#editUserForm")[0].reset();
                $("#editUserModal").modal('hide');
            },
            error: function(xhr, status, error) {
                    // Xử lý lỗi AJAX
                    Swal.fire(
                        'Đã xảy ra lỗi!',
                        'Username hoặc Email đã tồn tại (Chú ý: Độ dài Username tối thiểu 6 kí tự và tối đa 20 kí tự.)',
                        'error'
                    );
                    console.error(xhr.responseText);
                    $("#editUserBtn").text('Chỉnh sửa');
                }
        });
    });

</script>

