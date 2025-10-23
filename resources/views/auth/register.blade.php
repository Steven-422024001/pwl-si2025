<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <title>Login - Mofu Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-center mb-4">Register</h4>

                        @if(session('success'))
                            <div class="alert alert-success">
                                 {{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                 {{ session('error') }}</div>
                        @endif
                        
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>ERROR AWKWKAKAW</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register.process') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <button class="btn btn-primary w-100">Register</button>
                        </form>
                        <p class="text-center mt-3">
                            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                        </p>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</body>
</html>