<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Masuk</title>

    <meta name="deskripsi" content=""/>

    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/img/favicon/favicon.ico') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('sneat/vendor/fonts/boxicons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('sneat/vendor/css/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('sneat/vendor/css/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('sneat/css/demo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('sneat/vendor/css/pages/page-auth.css') }}"/>
</head>

<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y" style="max-width: 450px; margin: 0 auto; min-height: 600px;">
        <div class="card" style="padding: 30px; width: 100%; min-height: 50px;">
            <div class="card-body">
                <div class="app-brand justify-content-center">
                    <a href="{{ route('home') }}" class="app-brand-link gap-2">
                        <img src="{{ asset('pustipanda.png') }}" alt="Pengarsipan Surat" width="150px">
                    </a>
                </div>

                <!-- Pesan Error -->
                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validasi Form -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-3">
                        <div class="input-group input-group-merge">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email"
                                required
                                value="{{ old('email') }}"
                            />
                            <span class="input-group-text">
                                <i class="bx bx-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="invalid-feedback" id="emailError">Email tidak boleh kosong.</div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password"
                                required
                            />
                            <span class="input-group-text">
                                <i class="bx bx-lock"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="invalid-feedback" id="passwordError">Password tidak boleh kosong.</div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="showPassword">
                            <label class="form-check-label" for="showPassword">
                                Tampilkan password
                            </label>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-primary d-grid w-100" type="submit" onclick="validateForm(event)">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/Hide Password
    const showPasswordCheckbox = document.getElementById('showPassword');
    const passwordInput = document.getElementById('password');

    showPasswordCheckbox.addEventListener('change', function() {
        passwordInput.type = this.checked ? 'text' : 'password';
    });

    // Form Validation Script
    function validateForm(event) {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        let isValid = true;

        // Reset error messages
        emailError.style.display = 'none';
        passwordError.style.display = 'none';

        // Check if email is empty
        if (emailInput.value.trim() === '') {
            emailError.style.display = 'block';
            isValid = false;
        }

        // Check if password is empty
        if (passwordInput.value.trim() === '') {
            passwordError.style.display = 'block';
            isValid = false;
        }

        // Prevent form submission if invalid
        if (!isValid) {
            event.preventDefault();
        }
    }
</script>
</body>
</html>
