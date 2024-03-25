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
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Thêm người dùng mới</a>
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
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ $user->id }}</p>
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
                                                <span class="text-secondary text-xs font-weight-bold"> 
                                                    {{$user->level}}
                                                </span>
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

<!-- Script để xử lý sự kiện click và hiển thị modal -->
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
</script>

<!-- Modal edit thông tin -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Chỉnh sửa thông tin người dùng</h5>
                <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" id="editUserForm" action="{{ route('user-profile') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 border-bottom ">
                        <label for="username" class="form-label">Tên đăng nhập:</label>
                        <input type="text" class="form-control border border-2 p-2" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="name" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control border border-2 p-2" id="name" name="name" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control border border-2 p-2" id="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control border border-2 p-2" id="phone" name="phone" placeholder="Nhập số điện thoại">
                    <!-- </div>
                    <div class="mb-3 border-bottom">
                        <label for="editLocation" class="form-label">Nơi ở:</label>
                        <input type="text" class="form-control border border-2 p-2" id="editLocation" name="editLocation" placeholder="Nhập nơi ở">
                    </div>
                    <div class="mb-3 border-bottom">
                        <label for="editAbout" class="form-label">Tiểu sử:</label>
                        <textarea class="form-control border border-2 p-2" id="editAbout" name="editAbout" rows="3" placeholder="Nhập tiểu sử"></textarea>
                    </div> -->
                    <div class="mb-3 border-bottom">
                        <label for="editLevel" class="form-label">Chức vụ:</label>
                        <select class="form-select" id="editLevel" name="editLevel">
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" ">Lưu thay đổi</button>
                    </div>
            </form>
            </div>
            
        </div>
    </div>
</div>

 <!-- Hiển thị thông tin cũ trước khi edit -->
<script>
    document.querySelectorAll('.editUserBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy thông tin người dùng từ thuộc tính data-user
            const userData = JSON.parse(this.getAttribute('data-user'));
            document.getElementById('username').value = userData.username;
            document.getElementById('name').value = userData.name;
            document.getElementById('email').value = userData.email;
            document.getElementById('phone').value = userData.phone || ''; // Nếu không có số điện thoại, để trống
            // document.getElementById('editLocation').value = userData.location || ''; // Nếu không có nơi ở, để trống
            // document.getElementById('editAbout').value = userData.about || ''; // Nếu không có tiểu sử, để trống
            // document.getElementById('editLevel').value = userData.level;
        });
    });
</script>

<script> 

</script>