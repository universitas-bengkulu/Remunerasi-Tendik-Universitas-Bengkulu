<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <title>Siremun Tendik UNIB | Login</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
        <link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href=" {{ asset('css/style_login.css') }} ">
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="particles-js">
            <div class="loginBox">
                <img src=" {{ asset('assets/images/logo.png') }} " class="user">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block" style="font-size:13px;">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Perhatian:</strong> <i>{{ $message }}</i>
                    </div>
                    @else
                    <h6>Login Tenaga Kependidikan</h6>
                    <p style="text-align:center; margin-bottom:20px;">Remunerasi Tenaga Kependidikan Universitas Bengkulu</p>
                @endif
                <form method="post" action="{{ route('tendik.login.submit') }}">
                    @csrf
                    <p>Nomor Induk Pegawai</p>
                    <input type="text" name="nip" placeholder="masukan nip" required>
                    <p>Password</p>
                    <input type="password" name="password" placeholder="••••••" required>

                    <button type="submit" name="submit" style="margin-bottom:10px;r"><i class="fa fa-sign-in"></i>&nbsp; Login</button>
                    <a href="{{ route('login') }}" style="font-weight:100; font-size:12px;" ><i class="fa fa-users"></i>&nbsp; Login Operator</a>
                </form>
            </div>
        </div>
    </body>
    <script type="text/javascript" src=" {{ asset('assets/particles/particles.min.js') }} "></script>
    <script type="text/javascript" src=" {{ asset('assets/particles/app.js') }} "></script>
    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</html>