<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-card {
            border-left: 5px solid #1e3a8a;
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
                <h4 class="mb-4 text-center text-blue-950">Create an Account</h4>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form action="<?= route_to('signup.register') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" required value="<?= old('name') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" required value="<?= old('email') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                <i class="fa-solid fa-eye" id="eyeIconPassword"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirm_password">
                                <i class="fa-solid fa-eye" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-blue-950 w-100">Signup</button>
                </form>


                <p class="mt-3 text-center">
                    Already have an account? <a href="<?= route_to('login') ?>">Login</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('.toggle-password').on('click', function() {
            const target = $(this).data('target');
            const input = $('#' + target);
            const icon = $(this).find('i');
            const type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);

            icon.toggleClass('fa-eye fa-eye-slash');
        });
    </script>


</body>

</html>