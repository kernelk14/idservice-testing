<html>
    <head>
        <title>Success</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    </head>
    <body>
        <div class="container text-center mt-5">
            <?php if (session('message') !== null) : ?>
                <div class="alert alert-success"><?= esc(session('message')) ?></div>
            <?php endif ?>
            <h3>Your ID request has been submitted!</h3>
            <p>Please wait for the admin to process your ID.</p>
        </div>
    </body>
</html>