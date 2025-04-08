<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome for Eye Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-card {
            border-left: 5px solid #1e3a8a;
            /* blue-950 */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
        }

        .google-btn {
            background-color: #ffffff;
            border: 1px solid #ddd;
            color: #1e3a8a;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .google-btn img {
            height: 18px;
            margin-right: 8px;
        }

        .btn-blue-950 {
            background-color: #172b65;
            color: #fff;
        }

        .btn-blue-950:hover {
            background-color: #1e3a8a;
            color: #fff !important;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6 col-lg-4">
            <div class="card login-card p-4">
                <h4 class="mb-4 text-center text-blue-950">Login to Your Account</h4>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form action="<?= route_to('login.attempt') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-blue-950 w-100">Login</button>
                </form>

                <div class="text-center my-3 text-muted">OR</div>

                <a href="<?= site_url('auth/google') ?>" class="btn google-btn w-100 d-flex align-items-center justify-content-center">
                    <img src="<?= base_url(); ?>assets/images/google_cover.jpg" alt="Google Logo">
                    Login with Google
                </a>

                <p class="mt-3 text-center">
                    Don't have an account? <a href="<?= route_to('signup') ?>">Signup</a>
                </p>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const eyeIcon = $('#eyeIcon');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);

            // Toggle eye / eye-slash
            if (type === 'text') {
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>

</body>

</html>