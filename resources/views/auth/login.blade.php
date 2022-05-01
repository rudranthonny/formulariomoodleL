<!DOCTYPE html>
<html dir="ltr" lang="es" xml:lang="es">

<head>
    <title>Login Learclass</title>
    <link rel="shortcut icon" href="{{ asset('images/logoico.ico') }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/all.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .btn-thm2 {
            background-color: #ff3057;
            border-color: #ff3057;
        }
        .btn-thm2:hover{
            background-color: #002564;
            border-color: #002564;
            color: white;
        }
    </style>
</head>

<body id="page-login-index"
    class="format-site  path-login chrome dir-ltr lang-es yui-skin-sam yui3-skin-sam aulavirtual-regioncusco-gob-pe pagelayout-login course-1 context-1 notloggedin ccn_no_hero ccn_header_style_1 ccn_footer_style_1 ccn_blog_style_1 ccn_course_list_style_1 ccn_breadcrumb_style_0 role-standard ccn-not-front ccn_header_applies-front  ccn_dashboard_header_sticky  ccn_dashboard_header_gradient   ccn_course_single_v1     ccnUG ccn_context_frontend">
    <div class="preloader ccn_preloader_load"></div>
    <div class="wrapper">
        <div>
            <a class="sr-only sr-only-focusable" href="#maincontent">Salta al contenido principal</a>
        </div>
        <script src="https://aulavirtual.regioncusco.gob.pe/theme/jquery.php/core/jquery-3.5.1.min.js"></script>
        <script src="https://aulavirtual.regioncusco.gob.pe/theme/javascript.php/edumy/1648995320/head"></script>
        <section class="our-log style4">
            <div class="login_box">
                <div class="login_box_inner">
                    <div class="login_form inner_page style3">
                        <span id="maincontent"></span>

                        <form action="{{ route('login') }}" method="post" id="login">
                            @csrf
                            <div class="heading">
                                <h3 class="text-center"><strong>Ingresar a su Cuenta</strong><br><br><img
                                        src='/images/logolargo.png' width='64px'></h3>
                            </div>
                            <x-jet-validation-errors class="mb-4" />

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <input id="anchor" type="hidden" name="anchor" value="">
                            <script>
                                document.getElementById('anchor').value = location.hash;
                            </script>
                            <input type="hidden" name="logintoken" value="ECOHMP4lFGmrgJRSq79jtWhrDRm4Gfcb">
                            <div class="form-group">
                                <x-jet-label for="email" class="sr-only" value="{{ __('Email') }}" />
                                <x-jet-input id="email" class="form-control" type="email" name="email"
                                    :value="old('email')" placeholder="Nombre de usuario" required autofocus />
                            </div>
                            <div class="form-group">
                                <x-jet-label for="password" class="sr-only" value="{{ __('Password') }}" />
                                <x-jet-input id="password" class="form-control" type="password" name="password"
                                    placeholder="{{ __('Password') }}" required autocomplete="current-password" />
                            </div>
                            <div class="form-group custom-control custom-checkbox">
                                <label for="remember_me" class="flex items-center">
                                    <x-jet-checkbox id="remember_me" name="remember" />
                                    <span class="ml-2 text-sm text-gray-600">{{ __('recordar Contraseña') }}</span>
                                </label>
                                <!--@if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif-->
                            </div>

                            <button type="submit" class="btn btn-log btn-block btn-thm2" id="loginbtn">Ingresar</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>