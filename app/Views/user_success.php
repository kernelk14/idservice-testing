<html>
    <head>
        <title>Success</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    </head>
    <body>
        <div class="navbar navbar-expand-lg" style="background-color: #800000;">
            <div class="container-fluid">
                <a href="#" class="navbar-brand ms-2">
                    <img src="<?= base_url('logo-web.png') ?>" width="32" height="32">
                </a>
                <span class="text-light ms-auto">
                    Hello, <b><?= strtoupper(auth()->user()->username) ?></b>&nbsp;
                    <a href="<?= base_url('user/logout') ?>" class="btn btn-secondary btn-sm">Log out</a>
                </span>
            </div>
        </div>
        <div class="container text-center mt-5">
            <?php if (session('message') !== null) : ?>
                <div class="alert alert-success"><?= esc(session('message')) ?></div>
            <?php endif ?>
            <h3>Your ID request has been submitted!</h3>
            <p>Please wait for the admin to process your ID.</p>
        </div>
    </body>
</html>