<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Trang chủ"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">person</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Tổng số người dùng</p>
                                <h4 class="mb-0 total-users-count">0</h4>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    // Lấy tổng số người dùng
                                    $.ajax({
                                        url: '/total-users-count',
                                        type: 'GET',
                                        success: function(response) {
                                            $('.total-users-count').text(response.total_users_count);
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText); // Xử lý lỗi nếu có
                                        }
                                    });
                                });
                            </script>

                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">group_add</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Người dùng mới hôm nay</p>
                                <h4 class="mb-0 new-users-count">0</h4>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $.ajax({
                                        url: '/new-users-count',
                                        type: 'GET',
                                        success: function(response) {
                                            $('.new-users-count').text(response.new_users_count);
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText); // Xử lý lỗi nếu có
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">assignment</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Tổng số bài tập</p>
                                <h4 class="mb-0 total-exercises-count">0</h4>
                            </div>
                            
                            <script>
                                $(document).ready(function() {
                                    // Lấy tổng số bài tập
                                    $.ajax({
                                        url: '/total-exercises-count',
                                        type: 'GET',
                                        success: function(response) {
                                            $('.total-exercises-count').text(response.total_exercises_count);
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText); // Xử lý lỗi nếu có
                                        }
                                    });
                                });
                            </script>
                            
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            
                        </div>
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</div>
   
</x-layout>


