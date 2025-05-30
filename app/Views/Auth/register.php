<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/logokharisma.png') ?>" />
    <script src="<?= base_url('assets/sciript.js') ?>" defer></script>
</head>
<body>
    <!-- Register Start -->
    <div class="container">
        <div class="row">
            <div class="mx-auto mt-2 text-center">
                <img src="<?= base_url('assets/img/logokharisma.png') ?>" width="8%" alt="Logo Barber" />
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <img class="img-register img-fluid" src="<?= base_url('assets/img/signup.svg') ?>" width="450px" alt="Register Image" />
            </div>
            <div class="col-md-6 mt-3">
                <div class="card shadow-sm p-3">
                    <div class="card-body">
                        <h4><center>Sign Up</center></h4>

                        <form action="<?= base_url('/register') ?>" method="post" class="mt-4">
                            <?= csrf_field() ?>
                            <span id="wrong_pass_alert"></span>

                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
                            <?php endif; ?>

                            <div class="form-group">
                                <input type="text" class="form-control" name="username" required autocomplete="off" placeholder="Username" />
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" class="form-control" name="number" pattern="[0-9]+" maxlength="14" placeholder="Mobile Number" required />
                            </div>
                            <div class="form-group mt-2">
                                <input type="email" name="email" class="form-control" placeholder="Email" required />
                            </div>
                            <div class="input-group mt-2">
                                <input type="password" class="form-control" name="password" placeholder="Password" id="inputPassword" required />
                            </div>
                            <div class="input-group mt-2">
                                <input type="password" class="form-control" placeholder="Confirm Password" id="inputPasswordConfirm" onkeyup="validate_password()" required />
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn mt-2 btn-color-theme" type="submit" id="create" onclick="wrong_pass_alert()">Sign Up</button>
                                <p class="text-center">Sudah punya akun? <a class="text-theme" href="<?= base_url('/login') ?>">Sign In</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register End -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>feather.replace();</script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>AOS.init();</script>
    <script>
        function validate_password() {
            var pass = document.getElementById('inputPassword').value;
            var confirm_pass = document.getElementById('inputPasswordConfirm').value;
            if (pass !== confirm_pass) {
                document.getElementById('wrong_pass_alert').style.color = 'red';
                document.getElementById('wrong_pass_alert').innerHTML = '☒ Samakan Password Anda!!';
                document.getElementById('create').disabled = true;
                document.getElementById('create').style.opacity = (0.4);
            } else {
                document.getElementById('wrong_pass_alert').style.color = 'blue';
                document.getElementById('wrong_pass_alert').innerHTML = '🗹 Password Sama';
                document.getElementById('create').disabled = false;
                document.getElementById('create').style.opacity = (1);
            }
        }
    </script>
</body>
</html>
