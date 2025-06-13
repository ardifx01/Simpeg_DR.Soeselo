<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struktur Organisasi RSUD dr. Soeselo Slawi</title>
    <link rel="stylesheet" href="style.css">

    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #fff;
}

.tree-container {
    text-align: center;
    overflow-x: auto;
    padding: 20px;
}

.tree {
    display: inline-block;
    white-space: nowrap;
}

.tree ul {
    padding-top: 20px;
    position: relative;
}

.tree li {
    display: inline-block;
    text-align: center;
    position: relative;
    padding: 20px 5px 0 5px;
}

.tree li::before,
.tree li::after {
    content: '';
    position: absolute;
    top: 0;
    width: 50%;
    height: 20px;
    border-top: 1px solid #ccc;
}

.tree li::before {
    right: 50%;
    border-right: 1px solid #ccc;
}

.tree li::after {
    left: 50%;
    border-left: 1px solid #ccc;
}

.tree li:only-child::before,
.tree li:only-child::after {
    display: none;
}

.tree li:only-child {
    padding-top: 0;
}

.tree li:first-child::before {
    border: none;
}

.tree li:last-child::after {
    border: none;
}

.tree ul ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    height: 20px;
    border-left: 1px solid #ccc;
}

.tree a {
    border: 1px solid #ccc;
    padding: 5px;
    text-decoration: none;
    color: #333;
    font-family: Arial, sans-serif;
    font-size: 11px;
    display: inline-block;
    width: 100px;
    border-radius: 5px;
}

.photo {
    display: block;
    width: 70px;
    height: 80px;
    background-size: cover;
    background-position: center;
    margin: 5px auto;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.sotk-title {
    display: block;
    background-color: #F4F4F4;
    min-height: 50px;
    font-weight: bold;
}

.sotk-nip,
.sotk-nama {
    font-size: 9px;
    background-color: #F4F4F4;
}

.sotk-nip {
    margin-top: 10px;
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="tree-container">
        <div class="tree">
            <ul>
                <li>
                    <a>
                        <span class="sotk-title">RSUD dr. Soeselo Slawi</span>
                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/197003092003121005_1617247601.jpg');"></i>
                        <div class="sotk-nip">197003092003121005</div>
                        <div class="sotk-nama">dr GUNTUR MUHAMMAD TAQWIN, M.Sc.SP.An.</div>
                    </a>
                    <ul>
                        <li>
                            <a>
                                <span class="sotk-title">Wakil Direktur Pelayanan</span>
                                <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/default.png');"></i>
                                <div class="sotk-nip">196709022002121003</div>
                                <div class="sotk-nama">dr JOKO WANTORO, MM</div>
                            </a>
                            <ul>
                                <li>
                                    <a>
                                        <span class="sotk-title">Bidang Pelayanan Medis</span>
                                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/198206162009031002_1620193738.jpg');"></i>
                                        <div class="sotk-nip">198206162009031002</div>
                                        <div class="sotk-nama">dr TEGUH SUKMA WIBOWO, M.M.</div>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="sotk-title">Bidang Pelayanan Medis</span>
                                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/198206162009031002_1620193738.jpg');"></i>
                                        <div class="sotk-nip">198206162009031002</div>
                                        <div class="sotk-nama">dr TEGUH SUKMA WIBOWO, M.M.</div>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="sotk-title">Bidang Pelayanan Medis</span>
                                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/198206162009031002_1620193738.jpg');"></i>
                                        <div class="sotk-nip">198206162009031002</div>
                                        <div class="sotk-nama">dr TEGUH SUKMA WIBOWO, M.M.</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a>
                                <span class="sotk-title">Wakil Direktur Pelayanan</span>
                                <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/default.png');"></i>
                                <div class="sotk-nip">196709022002121003</div>
                                <div class="sotk-nama">dr JOKO WANTORO, MM</div>
                            </a>
                            <ul>
                                <li>
                                    <a>
                                        <span class="sotk-title">Bidang Pelayanan Medis</span>
                                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/198206162009031002_1620193738.jpg');"></i>
                                        <div class="sotk-nip">198206162009031002</div>
                                        <div class="sotk-nama">dr TEGUH SUKMA WIBOWO, M.M.</div>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="sotk-title">Bidang Pelayanan Medis</span>
                                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/198206162009031002_1620193738.jpg');"></i>
                                        <div class="sotk-nip">198206162009031002</div>
                                        <div class="sotk-nama">dr TEGUH SUKMA WIBOWO, M.M.</div>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="sotk-title">Bidang Pelayanan Medis</span>
                                        <i class="photo" style="background-image: url('https://simpeg.tegalkab.go.id/v17/packages/upload/photo/pegawai/198206162009031002_1620193738.jpg');"></i>
                                        <div class="sotk-nip">198206162009031002</div>
                                        <div class="sotk-nama">dr TEGUH SUKMA WIBOWO, M.M.</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    
</body>
</html>
