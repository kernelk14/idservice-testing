<?php 

function createInputGroup($label, $name, $type): string {
    $html = <<< EOD
    <div class='input-group'>
        <span class='input-group-text'>$label</span>
        <input type='$type' aria-label='$label' name='$name' class='form-control' required>
    </div>
    EOD;
    return $html;
}

$field_list = [
    ['Name', 'name', 'text'],
    ['Email Address', 'email', 'email'],
    ['Contact Number', 'contact_num', 'text'],
    ['Address', 'address', 'text'],
    ['In case of emergency', 'emergency_person', 'text'],
    ['Emergency contact number', 'emergency_number', 'text'],
    ['Attach a photo of you', 'attach_id', 'file'],
]

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create an ID</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css')?>">
    </head>
    <body>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

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
                        <h5>Create an ID</h5>
                    </li>
                </ul>
                <?php if (auth()->user()->inGroup('superadmin', 'admin')): ?>
                <a href="<?= base_url('requests') ?>" class="btn btn-outline-light">Go Back</a>
                &nbsp;
                <?php endif; ?>
                <a href="<?= base_url('user/logout') ?>" class="btn btn-secondary">Log out</a>
            </div>
        </div>

        <div class="container">
            <h3>Start creating an ID with the fields below.</h3>
            <?php if (auth()->user()->inGroup('superadmin', 'admin')): ?>
            <div class="container">
                 <a href="<?= base_url('requests') ?>" class="btn btn-outline-dark">Go Back</a>
            </div>
            <?php endif; ?>
            <br>
        </div>
        <form action="<?= base_url('user/store') ?>" method="POST" class="form" enctype="multipart/form-data">
            <div class="form-group container">
                <?= createInputGroup($field_list[0][0], $field_list[0][1], $field_list[0][2]) ?>
                <br />
                <?= createInputGroup($field_list[1][0], $field_list[1][1], $field_list[1][2]) ?>
                <br />
                <?= createInputGroup($field_list[2][0], $field_list[2][1], $field_list[2][2]) ?>
                <br />
                <?= createInputGroup($field_list[3][0], $field_list[3][1], $field_list[3][2]) ?>
                <br />
                <?= createInputGroup($field_list[4][0], $field_list[4][1], $field_list[4][2]) ?>
                <br />
                <?= createInputGroup($field_list[5][0], $field_list[5][1], $field_list[5][2]) ?>
                <br />
                <?= createInputGroup($field_list[6][0], $field_list[6][1], $field_list[6][2]) ?>
                <br />  
                <input type="submit" class="btn btn-outline-primary" placeholder="Request ID" aria-placeholder="Request ID">
            </div>
        </form>
    </body>
</html>