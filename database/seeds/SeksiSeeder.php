<?php

use Illuminate\Database\Seeder;

class SeksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 1;
        if (($handle = fopen('resources/data/Seksi.csv', "r")) !== FALSE) {
            $pertama = TRUE;
            while (($data = fgetcsv($handle, 100, ";")) !== FALSE) {
                if($pertama){
                    $pertama = FALSE;
                }else{
                    DB::table('seksi')->insert([
                        'id' => $data[0],
                        'nama' => $data[1],
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
