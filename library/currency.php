<?php
    function currency_format($number)
    {
        $indonesia_currency = number_format($number,0,',','.');
        return $indonesia_currency;
    }
  
    function currency_calculated($number)
    {
        // pastikan kita hanya berususan dengan tipe data numeric
        $number = (float)$number;
         
        // array bilangan 
        // sepuluh dan sebelas merupakan special karena awalan 'se'
        $numeric = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
     
        // pencocokan dimulai dari satuan angka terkecil
        if ($number < 12)
        {
            // mapping angka ke index array $bilangan
            return $numeric[$number];
        }
        elseif ($number < 20)
        {
            // bilangan 'belasan'
            // misal 18 maka 18 - 10 = 8
            return $numeric[$number - 10] . ' belas';
        }
        elseif ($number < 100)
        {
            // bilangan 'puluhan'
            // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
            // untuk mendapatkan sisa bagi gunakan modulus
            // 27 mod 10 = 7 'tujuh'
            $hasil_bagi = (int)($number / 10);
            $hasil_mod = $number % 10;
            return trim(sprintf('%s Puluh %s', $numeric[$hasil_bagi], $numeric[$hasil_mod]));
        }
        elseif ($number < 200)
        {
            // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
            // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
            // daripada menulis ulang rutin kode puluhan maka gunakan
            // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
            return sprintf('Seratus %s', terbilang($number - 100));
        }
        elseif ($number < 1000)
        {
            // bilangan 'ratusan'
            // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
            // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
            $hasil_bagi = (int)($number / 100);
            $hasil_mod = $number % 100;
            return trim(sprintf('%s Ratus %s', $numeric[$hasil_bagi], currency_calculated($hasil_mod)));
        }
        elseif ($number < 2000)
        {
            // bilangan 'seribuan'
            // misal 1250 maka 1250 - 1000 = 250 (ratusan)
            // gunakan rekursif terbilang(250)
            return trim(sprintf('Seribu %s', currency_calculated($number - 1000)));
        }
        elseif ($number < 1000000)
        {
            // bilangan 'ribuan' (sampai ratusan ribu
            $hasil_bagi = (int)($number / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
            $hasil_mod = $number % 1000;
            return sprintf('%s Ribu %s', currency_calculated($hasil_bagi), currency_calculated($hasil_mod));
        }
        else if ($number < 1000000000)
        {
            // bilangan 'jutaan' (sampai ratusan juta)
            // 'satu puluh' => SALAH
            // 'satu ratus' => SALAH
            // 'satu juta' => BENAR 
            // @#$%^ WT*
           
            // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
            $hasil_bagi = (int)($number / 1000000);
            $hasil_mod = $number % 1000000;
            return trim(sprintf('%s Juta %s', currency_calculated($hasil_bagi), currency_calculated($hasil_mod)));
        }
        elseif ($number < 1000000000000)
        {
            // bilangan 'milyaran'
            $hasil_bagi = (int)($number / 1000000000);
            // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
            // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
            $hasil_mod = fmod($number, 1000000000);
            return trim(sprintf('%s Milyar %s', currency_calculated($hasil_bagi), currency_calculated($hasil_mod)));
        }
        elseif ($number < 1000000000000000)
        {
            // bilangan 'triliun'
            $hasil_bagi = $number / 1000000000000;
            $hasil_mod = fmod($number, 1000000000000);
            return trim(sprintf('%s Triliun %s', currency_calculated($hasil_bagi), currency_calculated($hasil_mod)));
        }
        else
        {
            return 'Wow...';
        }
    }
?> 