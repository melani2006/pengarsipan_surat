<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Masuk</title>

    <meta name="deskripsi" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('sneat/img/favicon/favicon.ico')}}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('sneat/vendor/fonts/boxicons.css')}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" class="template-customizer-core-css" href="{{asset('sneat/vendor/css/core.css')}}"/>
    <link rel="stylesheet" class="template-customizer-theme-css" href="{{asset('sneat/vendor/css/theme-default.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/css/demo.css')}}"/>

    <!-- Page -->
    <link rel="stylesheet" href="{{asset('sneat/vendor/css/pages/page-auth.css')}}"/>
</head>

<body>
<!-- Content -->

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y" style="max-width: 450px; margin: 0 auto; min-height: 600px;">
        <!-- Register -->
        <div class="card" style="padding: 30px; width: 100%; min-height: 50px;">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                    <a href="{{ route('home') }}" class="app-brand-link gap-2">
                        <img src="{{ asset('pustipanda.png') }}" alt="Pengarsipan Surat" width="150px">
                    </a>
                </div>

                <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                    @csrf
                    <!-- Email Input with Icon on Right -->
                    <div class="mb-3">
                        <div class="input-group input-group-merge">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan email"
                                required
                            />
                            <span class="input-group-text">
                                <i class="bx bx-envelope"></i> <!-- Ikon untuk email -->
                            </span>
                        </div>
                    </div>

                    <!-- Password Input with Icon on Right -->
                    <div class="mb-3">
                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            />
                            <span class="input-group-text">
                                <i class="bx bx-lock"></i> <!-- Ikon untuk password -->
                            </span>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="showPassword">
                            <label class="form-check-label" for="showPassword">
                                Tampilkan password
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-2">
                        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                    </div>
                </form>
            </div>
         </div>
        <!-- /Register -->
    </div>
</div>

<!-- / Content -->

<!-- Show Password Script -->
<script>
    const showPasswordCheckbox = document.getElementById('showPassword');
    const passwordInput = document.getElementById('password');

    showPasswordCheckbox.addEventListener('change', function() {
        passwordInput.type = this.checked ? 'text' : 'password';
    });
</script>
</body>
</html>
