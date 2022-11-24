<?php

use Illuminate\Database\Seeder;

class IndividuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 1;
        if (($handle = fopen('resources/data/Indiviudu.csv', "r")) !== FALSE) {
            $pertama = TRUE;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($pertama){
                    $pertama = FALSE;
                }else{
                    // print_r($data);
                    $seksi = $data[7];
                    if($seksi==""){
                        $seksi = NULL;
                    }
                    // print_r($data);
                    DB::table('users')->insert([
                        'username' => $data[5],
                        'nip_baru' => $data[2],
                        'nip_lama' => $data[4],
                        'nama' => $data[1],
                        'jabatan' => $data[6],
                        'golongan_terakhir' => $data[3],
                        'status_kendaraan' => $data[9],
                        'seksi_id' => $seksi,
                        'is_kasi_plt' => $data[8],
                        'password' => Hash::make($data[4]),
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]);
                    // $url1 = 'https://community.bps.go.id/images/avatar/'.substr($data[4],4).'.jpg'; 
                    // $url2 = 'https://community.bps.go.id/images/avatar/'.substr($data[4],4).'.JPG'; 
                    // $url3 = 'https://community.bps.go.id/images/avatar/'.$data[4].'.jpg'; 
                    // $url4 = 'https://community.bps.go.id/images/avatar/'.$data[4].'.JPG'; 
  
                    // // Use basename() function to return the base name of file  
                    // $file_name = 'public/img/foto/'.$data[4].'.jpg';
   
                    // // Use file_get_contents() function to get the file 
                    // // from url and use file_put_contents() function to 
                    // // save the file by using base name 
                    // try{
                    //     file_put_contents( $file_name,file_get_contents($url1));
                    // }catch(Exception $e){
                       
                    // }
                    // try{
                    //     file_put_contents( $file_name,file_get_contents($url2));
                    // }catch(Exception $e){
                    // }
                    // try{
                    //     file_put_contents( $file_name,file_get_contents($url3));
                    // }catch(Exception $e){
                    // }
                    // try{
                    //     file_put_contents( $file_name,file_get_contents($url4));
                    // }catch(Exception $e){
                    // }
                }
            }
            fclose($handle);
        }
    }
}
