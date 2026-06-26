<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Process ID Requests</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css')?>">
        <link rel="shortcut icon" href="<?= base_url('favicon-16x16.png') ?>" type="image/x-icon">
        <style>
            .id-preview {
                width: 300px;
                height: 190px;
                display: flex;
                background: linear-gradient(135deg, #800000 0%, #a00000 100%);
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                margin: 0 auto;
            }
            .id-preview .left {
                width: 40%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 10px;
                background: rgba(255,255,255,0.1);
            }
            .id-preview .left .photo {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                border: 2px solid #fff;
                object-fit: cover;
            }
            .id-preview .left .org {
                color: #fff;
                font-size: 10px;
                font-weight: bold;
                text-align: center;
                margin-top: 5px;
            }
            .id-preview .right {
                width: 60%;
                padding: 10px 12px;
                background: #fff;
                display: flex;
                flex-direction: column;
                justify-content: center;
                font-size: 11px;
            }
            .id-preview .right .num {
                font-size: 13px;
                color: #800000;
                font-weight: bold;
                margin-bottom: 6px;
            }
            .id-preview .right .row {
                margin-bottom: 4px;
            }
            .id-preview .right .lbl {
                font-size: 9px;
                color: #800000;
                font-weight: bold;
                text-transform: uppercase;
            }
            .id-preview .right .val {
                color: #333;
                border-bottom: 1px solid #ddd;
                padding-bottom: 2px;
            }
            .preview-wrap {
                display: none;
            }
            .preview-wrap.show {
                display: block;
            }
        </style>
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
                            (<b><?= strtoupper(auth()->user()->getGroups()[0]) ?></b>)
                        </span>
                    </li>
                    <li class="navbar-text me-2 text-light"><span>|</span></li>
                    <li class="navbar-text me-2 text-light">
                        <h5>Process ID Requests</h5>
                    </li>
                </ul>
                <a href="<?= base_url('requests') ?>" class="btn btn-outline-light">Back to List</a>
                &nbsp;
                <a href="<?= base_url('admin/logout') ?>" class="btn btn-secondary">Log out</a>
            </div>
        </div>

        <div class="container-fluid mt-4">
            <?php if(session() && session()->getFlashdata('error')): ?>
                <p class="text-danger"><?= session()->getFlashdata('error') ?></p>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('user/generate-pdf') ?>" class="mb-4">
                <button type="submit" class="btn btn-success">Generate ID</button>
                <small class="text-muted ms-2"><?= count($users) ?> request(s) in queue</small>
            </form>

            <button class="btn btn-info text-white mb-3" id="viewBtn" style="display: none;">View</button>

            <div id="previewContainer" class="preview-wrap">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4" id="previewGrid"></div>
            </div>

            <?php if(!empty($users)): ?>
                <form method="POST" action="<?= base_url('user/generate-pdf') ?>" id="pdfForm">
                    <table class="table table-secondary text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </div>
                                </th>
                                <th>Request No.</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Emergency Contact</th>
                                <th>Emergency Contact Number</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $u): ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox"
                                                name="userIds[]"
                                                value="<?= $u['userId'] ?>"
                                                class="form-check-input row-checkbox"
                                                data-id="<?= $u['userId'] ?>"
                                                data-name="<?= $u['name'] ?>"
                                                data-email="<?= $u['email'] ?>"
                                                data-contact="<?= $u['contact_num'] ?>"
                                                data-address="<?= $u['address'] ?>"
                                                data-emergency-person="<?= $u['emergency_person'] ?>"
                                                data-emergency-number="<?= $u['emergency_number'] ?>"
                                                data-photo="<?= base_url('uploads/' . $u['attach_id']) ?>"
                                            >
                                        </div>
                                    </td>
                                    <td><?= $u['userId'] ?></td>
                                    <td><?= $u['name'] ?></td>
                                    <td><?= $u['email'] ?></td>
                                    <td><?= $u['address'] ?></td>
                                    <td><?= $u['contact_num'] ?></td>
                                    <td><?= $u['emergency_person'] ?></td>
                                    <td><?= $u['emergency_number'] ?></td>
                                    <td><img src="<?= base_url('uploads/' . $u['attach_id']) ?>" width="64" height="64" /></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            <?php else: ?>
                <p>No users selected.</p>
            <?php endif; ?>
        </div>

        <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script>
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const selectAll = document.getElementById('selectAll');
            const viewBtn = document.getElementById('viewBtn');
            const previewContainer = document.getElementById('previewContainer');
            const previewGrid = document.getElementById('previewGrid');

            function updateViewBtn() {
                const checked = document.querySelectorAll('.row-checkbox:checked');
                viewBtn.style.display = checked.length > 0 ? 'inline-block' : 'none';
            }

            function buildPreviewHtml(data) {
                return `<div class="col">
                    <div class="id-preview">
                        <div class="left">
                            <img class="photo" src="${data.photo}" alt="Photo" />
                            <div class="org">ID SERVICE</div>
                        </div>
                        <div class="right">
                            <div class="num">ID #${data.id}</div>
                            <div class="row"><div class="lbl">Name</div><div class="val">${data.name}</div></div>
                            <div class="row"><div class="lbl">Email</div><div class="val">${data.email}</div></div>
                            <div class="row"><div class="lbl">Contact</div><div class="val">${data.contact}</div></div>
                            <div class="row"><div class="lbl">Emergency</div><div class="val">${data.emergencyPerson} (${data.emergencyNumber})</div></div>
                        </div>
                    </div>
                </div>`;
            }

            viewBtn.addEventListener('click', function() {
                const checked = document.querySelectorAll('.row-checkbox:checked');
                previewGrid.innerHTML = '';
                checked.forEach(cb => {
                    previewGrid.innerHTML += buildPreviewHtml({
                        id: cb.dataset.id,
                        name: cb.dataset.name,
                        email: cb.dataset.email,
                        contact: cb.dataset.contact,
                        emergencyPerson: cb.dataset.emergencyPerson,
                        emergencyNumber: cb.dataset.emergencyNumber,
                        photo: cb.dataset.photo
                    });
                });
                previewContainer.classList.add('show');
            });

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateViewBtn();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked) selectAll.checked = false;
                    const all = document.querySelectorAll('.row-checkbox:checked');
                    if (all.length === checkboxes.length) selectAll.checked = true;
                    updateViewBtn();
                });
            });
        </script>
    </body>
</html>
