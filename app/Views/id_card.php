<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
            size: 85.6mm 54mm landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            color: #333;
        }
        .id-card {
            width: 85.6mm;
            height: 54mm;
            display: flex;
            background: linear-gradient(135deg, #800000 0%, #a00000 100%);
            border-radius: 3mm;
            overflow: hidden;
        }
        .id-left {
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3mm;
            background: rgba(255,255,255,0.1);
        }
        .id-left .photo {
            width: 22mm;
            height: 22mm;
            border-radius: 50%;
            border: 2px solid #fff;
            object-fit: cover;
            display: block;
        }
        .id-left .logo {
            width: 10mm;
            height: 10mm;
            margin-bottom: 2mm;
        }
        .id-left .org-name {
            color: #fff;
            font-size: 6pt;
            font-weight: bold;
            text-align: center;
            margin-top: 2mm;
        }
        .id-right {
            width: 60%;
            padding: 3mm 4mm;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .id-right .field {
            margin-bottom: 1.5mm;
        }
        .id-right .label {
            font-size: 5.5pt;
            color: #800000;
            font-weight: bold;
            text-transform: uppercase;
        }
        .id-right .value {
            font-size: 7pt;
            color: #333;
            border-bottom: 0.5px solid #ddd;
            padding-bottom: 0.5mm;
        }
        .id-right .id-number {
            font-size: 8pt;
            color: #800000;
            font-weight: bold;
            margin-bottom: 2mm;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="id-left">
            <img class="photo" src="<?= FCPATH . 'uploads/' . $user['attach_id'] ?>" alt="Photo" />
            <div class="org-name">ID SERVICE</div>
        </div>
        <div class="id-right">
            <div class="id-number">ID #<?= $user['userId'] ?></div>
            <div class="field">
                <div class="label">Name</div>
                <div class="value"><?= $user['name'] ?></div>
            </div>
            <div class="field">
                <div class="label">Email</div>
                <div class="value"><?= $user['email'] ?></div>
            </div>
            <div class="field">
                <div class="label">Contact</div>
                <div class="value"><?= $user['contact_num'] ?></div>
            </div>
            <div class="field">
                <div class="label">Emergency Contact</div>
                <div class="value"><?= $user['emergency_person'] ?> (<?= $user['emergency_number'] ?>)</div>
            </div>
        </div>
    </div>
</body>
</html>
