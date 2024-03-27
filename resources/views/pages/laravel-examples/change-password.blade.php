<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="change-password"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Đổi mật khẩu'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="assets/img/avatar_user/{{ auth()->user()->avatar}}" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->username }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{auth()->user()->level}}
                            </p>
                        </div>
                    </div>
                    
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Đổi mật khẩu</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        
                        <form method='POST' enctype="multipart/form-data" action='{{ route('change-password') }}' >
                            @csrf
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Mật khẩu cũ:</label>
                            <input type="password" name="password" class="form-control border border-2 p-2" >
                                @error('password')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                                </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Mật khẩu mới:</label>
                                <input type="password" name="newPassword" class="form-control border border-2 p-2" >
                                    @error('newPassword')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Nhập lại mật khẩu mới:</label>
                                <input type="password" name="cnewPassword" class="form-control border border-2 p-2" >
                                    @error('cnewPassword')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                            </div>
                            
                            <button type="submit" class="btn bg-gradient-success ">
                                <i class="material-icons text-lg">save</i>&nbsp;&nbsp;Lưu thay đổi
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
