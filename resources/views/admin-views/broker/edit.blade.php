@extends('layouts.admin.app')

@section('title','Update restaurant info')

@push('css_or_js')
<style>
    #map{
        height: 100%;
    }
    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        #map{
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i> {{translate('messages.update')}} {{translate('messages.broker')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.broker.update',[$broker['id']])}}" method="post" class="js-validate"
                      enctype="multipart/form-data" id="vendor_form">
                    @csrf
                    <small class="nav-subtitle text-secondary border-bottom">{{translate('messages.broker')}} {{translate('messages.info')}}</small>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-12">


                            <div class="form-group">
                                <label class="input-label">{{translate('messages.broker')}} {{translate('messages.logo')}}<small style="color: red"> ( {{translate('messages.ratio')}} 1:1 )</small></label>
                                <div class="custom-file">
                                    <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" style="margin-top: auto;margin-bottom: auto;">
                            <div class="form-group" style="margin-bottom:0%;">
                                <center>
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                        src="{{asset("public/storage/broker/$broker->image")}}" alt="{{$broker->f_name}}"/>
                                </center>
                            </div>
                        </div>
                    </div>


                    <br>









                    <small class="nav-subtitle text-secondary border-bottom">{{translate('messages.broker')}} {{translate('messages.info')}}</small>
                    <br>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.first')}} {{translate('messages.name')}}</label>
                                <input type="text" name="f_name" class="form-control" placeholder="{{translate('messages.first')}} {{translate('messages.name')}}" value="{{$broker->f_name}}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.last')}} {{translate('messages.name')}}</label>
                                <input type="text" name="l_name" class="form-control" placeholder="{{translate('messages.last')}} {{translate('messages.name')}}"
                                value="{{$broker->l_name}}"  required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.phone')}}</label>
                                <input type="text" name="phone" class="form-control" placeholder="Ex : 017********"
                                value="{{$broker->phone}}"   required>
                            </div>
                        </div>
                    </div>
                    <br>

                    <small class="nav-subtitle text-secondary border-bottom">{{translate('messages.login')}} {{translate('messages.info')}}</small>
                    <br>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.email')}}</label>
                                <input type="email" name="email" class="form-control" placeholder="Ex : ex@example.com" value="{{$broker->email}}" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrPassword">Password</label>

                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control" name="password" id="signupSrPassword" placeholder="{{translate('messages.password_length_placeholder',['length'=>'6+'])}}" aria-label="6+ characters required"
                                    data-msg="Your password is invalid. Please try again."
                                    data-hs-toggle-password-options='{
                                    "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                    }'>
                                    <div class="js-toggle-password-target-1 input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                            <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrConfirmPassword">Confirm password</label>

                                <div class="input-group input-group-merge">
                                <input type="password" class="js-toggle-password form-control" name="confirmPassword" id="signupSrConfirmPassword" placeholder="{{translate('messages.password_length_placeholder', ['length'=>'6+'])}}" aria-label="6+ characters required"                                      data-msg="Password does not match the confirm password."
                                        data-hs-toggle-password-options='{
                                        "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                        }'>
                                <div class="js-toggle-password-target-2 input-group-append">
                                    <a class="input-group-text" href="javascript:;">
                                    <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">{{translate('messages.submit')}}</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+viewer).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, 'viewer');
        });

        $("#coverImageUpload").change(function () {
            readURL(this, 'coverImageViewer');
        });
    </script>

<script>
      $(document).on('ready', function () {
        // INITIALIZATION OF SHOW PASSWORD
        // =======================================================
        $('.js-toggle-password').each(function () {
          new HSTogglePassword(this).init()
        });


        // INITIALIZATION OF FORM VALIDATION
        // =======================================================
        $('.js-validate').each(function() {
          $.HSCore.components.HSValidation.init($(this), {
            rules: {
              confirmPassword: {
                equalTo: '#signupSrPassword'
              }
            }
          });
        });

      });
    $("#vendor_form").on('keydown', function(e){
        if (e.keyCode === 13) {
            e.preventDefault();
        }
    })
    </script>
@endpush
