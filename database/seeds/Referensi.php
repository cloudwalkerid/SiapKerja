<?php

use Illuminate\Database\Seeder;

class Referensi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 1;
        if (($handle = fopen('resources/data/referensi.csv', "r")) !== FALSE) {
            $pertama = TRUE;
            while (($data = fgetcsv($handle, 100, ";")) !== FALSE) {
                if($pertama){
                    $pertama = FALSE;
                }else{
                    DB::table('siap_kerja_ref_kegiatan_tahapan')->insert([
                        'ref_kode' => $data[0],
                        'nama' => $data[1],
                        'bobot' => $data[2],
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
