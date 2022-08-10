<?php
    function UploadUserPhoto($fupload_name)
    {
        //direktori gambar
        $vdir_upload = "../../alimms-new/assets/layouts/layout6/img/user-photo/";
        $vfile_upload = $vdir_upload . $fupload_name;
      
        //Simpan gambar dalam ukuran sebenarnya
        move_uploaded_file($_FILES["user_photo"]["tmp_name"], $vfile_upload);
      
        //identitas file asli
        $im_src = imagecreatefromjpeg($vfile_upload);
        $src_width = imageSX($im_src);
        $src_height = imageSY($im_src);
      
        //Hapus gambar di memori komputer
        imagedestroy($im_src);
        imagedestroy($im);
    }
    
    function UploadProductDisplay($fupload_name)
    {
        //direktori gambar
        $vdir_upload = "../../alimms-new/assets/layouts/layout6/img/product-display/";
        $vfile_upload = $vdir_upload . $fupload_name;
      
        //Simpan gambar dalam ukuran sebenarnya
        move_uploaded_file($_FILES["product_display_photo"]["tmp_name"], $vfile_upload);
      
        //identitas file asli
        $im_src = imagecreatefromjpeg($vfile_upload);
        $src_width = imageSX($im_src);
        $src_height = imageSY($im_src);
      
        //Hapus gambar di memori komputer
        imagedestroy($im_src);
        imagedestroy($im);
    }
?>