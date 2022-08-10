<?php
    function default_user_profile_platform()
    {
        $user = mysql_fetch_array(mysql_query("SELECT * FROM user a, user_category b WHERE a.user_category_id = b.user_category_id AND a.user_id = '".$_SESSION['user_id']."'"));
?>
        
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="../assets/global/img/<?php echo $user['user_photo'] ?>" class="img-responsive" alt=""> </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <?php echo $user['user_name'] ?> </div>
                                            <div class="profile-usertitle-job"> <?php echo $user['user_category_name'] ?> </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN PROFILE CONTENT -->
                                <div class="profile-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Profil Akun</span>
                                                    </div>
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab">Biodata</a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab_1_2" data-toggle="tab">Foto Profil</a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab_1_3" data-toggle="tab">Ubah Password</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- PERSONAL INFO TAB -->
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            <form role="form" action="?connect=user-profile&execute=update-profile" method="POST">
                                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>" />
                                                                <div class="form-group">
                                                                    <label class="control-label">Nama</label>
                                                                    <input type="text" name="user_name" placeholder="Nama" class="form-control" value="<?php echo $user['user_name'] ?>" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Telepon</label>
                                                                    <input type="text" name="user_phone" placeholder="Telepon" class="form-control" value="<?php echo $user['user_phone'] ?>"/> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input type="text" name="user_email" placeholder="Email" class="form-control" value="<?php echo $user['user_email'] ?>"/> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Username</label>
                                                                    <input type="text" name="user_username" placeholder="Username" class="form-control" value="<?php echo $user['user_username'] ?>"/> </div>
                                                               
                                                                <div class="margiv-top-10">
                                                                    <button class="btn blue btn-outline" type="submit">
                                    									<i class="icon-check"></i>
                                    									Simpan
                                    								</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END PERSONAL INFO TAB -->
                                                        <!-- CHANGE AVATAR TAB -->
                                                        <div class="tab-pane" id="tab_1_2">
                                                            <form action="?connect=user-profile&execute=update-foto-profil" role="form" method="POST" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                        <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new"> Select image </span>
                                                                                <span class="fileinput-exists"> Change </span>
                                                                                <input type="file" name="foto-profil"> </span>
                                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="margiv-top-10">
                                                                    <button class="btn blue btn-outline" type="submit">
                                    									<i class="icon-check"></i>
                                    									Simpan
                                    								</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END CHANGE AVATAR TAB -->
                                                        <!-- CHANGE PASSWORD TAB -->
                                                        <div class="tab-pane" id="tab_1_3">
                                                            <form action="?connect=user-profile&execute=update-password" method="POST">
                                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>" />
                                                                <div class="form-group">
                                                                    <label class="control-label">Password saat ini</label>
                                                                    <input type="text" class="form-control" name="password" value="<?php echo $user['user_original_password'] ?>"/> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Password Baru</label>
                                                                    <input type="text" name="new-password" class="form-control" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Konfirmasi Password</label>
                                                                    <input type="text" name="confirm-password" class="form-control" /> </div>
                                                                <div class="margiv-top-10">
                                                                    <button class="btn blue btn-outline" type="submit">
                                    									<i class="icon-check"></i>
                                    									Simpan
                                    								</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END CHANGE PASSWORD TAB -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
    
<?php
    }
?>