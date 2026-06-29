<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css')?>">
        <link rel="shortcut icon" href="<?= base_url('favicon-16x16.png') ?>" type="image/x-icon">
        <style>
            body {
                background-image: url("<?= base_url('bg1.jpg') ?>");
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex justify-content-center align-items-center mt-lg-5 p-5">
            <div class="card col-12 col-md-5 shadow-sm p-3" style="background: rgba(255, 255, 255, 0.5);border-radius: 8px;-webkit-backdrop-filter: blur(8px) saturate(168%); backdrop-filter: blur(8px) saturate(168%);">
                
                <div class="container-fluid justify-content-center align-items-center mb-3 mt-3 d-flex">
                    <div class="d-inline-block me-3">
                        <img src="<?= base_url('logo-web.png') ?>" height="80" />
                    </div>
                    <div class="d-inline-block align-middle">
                        <p class="mb-0 fw-bold text-uppercase">City College of Tagaytay</p>
                        <h5 class="mb-0 fw-bold text-uppercase">Temporary ID Application</h5>
                        <br class="d-md-block d-none" />
                    </div>
                </div>
                <hr />
                <div class="content d-flex justify-content-center align-items-center">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">Login / Sign Up</h5>
                        <p class="text-muted fw-bold">Mag sign in na kayo para makapagrequest kayo ng temp id mga gunggong na walang id</p>

                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
                        <?php endif ?>

                        <?php if (session('message') !== null) : ?>
                            <div class="alert alert-success" role="alert"><?= esc(session('message')) ?></div>
                        <?php endif ?>

                        <!-- <p class="mb-4">Sign in with your Google account</p> -->

                        <a href="<?= base_url('google-auth') ?>" class="btn btn-outline-primary">
                            <svg width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                <path fill="#FBBC05" d="M10.54 28.59A14.5 14.5 0 0 1 9.5 24c0-1.59.28-3.14.76-4.59l-7.98-6.19A23.99 23.99 0 0 0 0 24c0 3.77.87 7.35 2.56 10.56l7.98-5.97z"/>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 5.97C6.51 42.62 14.62 48 24 48z"/>
                            </svg>
                            Sign in with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    </body>
</html>
