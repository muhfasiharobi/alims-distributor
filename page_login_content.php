<div class="login-content">
    <h1>Alimms Sistem Login</h1>
    <p>
        Sistem Informasi Manajemen Pabrik AIR AL QODIRI.
        AIR AL QODIRI Adalah Air Berkah Penuh Barokah Yang Terletak Di Kabupaten Jember Yang Didirikan Oleh PT. Tujuh Impian Bersama.
    </p>
    <form action="script_ceklog.php" class="login-form" method="post">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>Masukkan username dan password.</span>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <input autocomplete="off" class="form-control form-control-solid placeholder-no-fix form-group" name="username" placeholder="Username" type="text" required/>
            </div>
            <div class="col-xs-6">
                <input autocomplete="off" class="form-control form-control-solid placeholder-no-fix form-group" name="password" placeholder="Password" type="password" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="rem-password">
                    <p>Ingatkan Saya <input type="checkbox" class="rem-checkbox"/></p>
                </div>
            </div>
            <div class="col-sm-8 text-right">
                <button class="btn blue" type="submit">Login</button>
            </div>
        </div>
    </form>
</div>