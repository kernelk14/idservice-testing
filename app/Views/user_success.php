<html>
    <head>
        <title>Success</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    </head>
    <body>
        <div class="navbar navbar-expand-lg" style="background-color: #800000;">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto">
                    <a href="#" class="navbar-brand ms-2">
                        <img src="<?= base_url('logo-web.png') ?>" width="32" height="32">
                    </a>
                    <li class="navbar-text">
                        <span class="text-light align-items-center align-content-center d-flex me-2">
                            Hello!,&nbsp;
                            <b><?= strtoupper(auth()->user()->username) ?></b>&nbsp;
                            <b>(<?= strtoupper(auth()->user()->getGroups()[0] ?? 'USER') ?>)</b>
                        </span>
                    </li>
                    <li class="navbar-text me-2 text-light"><span>|</span></li>
                    <li class="navbar-text me-2 text-light">
                        <h5>Success</h5>
                    </li>
                </ul>
                <a href="<?= base_url('user/logout') ?>" class="btn btn-secondary">Log out</a>
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