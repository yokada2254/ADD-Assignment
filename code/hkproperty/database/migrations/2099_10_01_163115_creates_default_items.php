<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesDefaultItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        $i = 1;
        DB::table('areas')->insert([
            ['id' => $i++, 'name' => 'Hong Kong'],
            ['id' => $i++, 'name' => 'Kowloon'],
            ['id' => $i++, 'name' => 'New Territories']
        ]);
        
        function insert($id, $str){
            forEach(explode(",", $str) as $n){
                $n = trim($n);
                // DB::table('sub_districts')->insert(['district_id' => $id, 'name' => $n]);
            };
        }

        $i = 0;
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 1, 'name' => 'Central and Western']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 1, 'name' => 'Wan Chai']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 1, 'name' => 'Eastern']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 1, 'name' => 'Southern']);

        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 2, 'name' => 'Yau Tsim Mong']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 2, 'name' => 'Sham Shui Po']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 2, 'name' => 'Kowloon City']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 2, 'name' => 'Wong Tai Sin']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 2, 'name' => 'Kwun Tong']);

        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Kwai Tsing']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Tsuen Wan']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Tuen Mun']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Yuen Long']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'North']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Tai Po']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Sha Tin']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Sai Kung']);
        DB::table('districts')->insert(['id' => ++$i, 'area_id' => 3, 'name' => 'Islands']);

        $i = 0;
        insert(++$i, "Kennedy Town, Shek Tong Tsui, Sai Ying Pun, Sheung Wan, Central, Admiralty, Mid-levels, Peak ");
        insert(++$i, "Wan Chai, Causeway Bay, Happy Valley, Tai Hang, So Kon Po, Jardine's Lookout");
        insert(++$i, "Tin Hau, Braemar Hill, North Point, Quarry Bay, Sai Wan Ho, Shau Kei Wan, Chai Wan, Siu Sai Wan");
        insert(++$i, "Pok Fu Lam, Aberdeen, Ap Lei Chau, Wong Chuk Hang, Shouson Hill, Repulse Bay, Chung Hom Kok, Stanley, Tai Tam, Shek O");

        insert(++$i, "Tsim Sha Tsui, Yau Ma Tei,West Kowloon Reclamation,King's Park, Mong Kok,Tai Kok Tsui");
        insert(++$i, "Mei Foo, Lai Chi Kok,Cheung Sha Wan,Sham Shui Po, Shek Kip Mei,Yau Yat Tsuen,Tai Wo Ping,Stonecutters Island");
        insert(++$i, "Hung Hom, To Kwa Wan,Ma Tau Kok, Ma Tau Wai,Kai Tak, Kowloon City,Ho Man Tin, Kowloon Tong,Beacon Hill");
        insert(++$i, "San Po Kong, Wong Tai Sin,Tung Tau, Wang Tau Hom,Lok Fu, Diamond Hill,Tsz Wan Shan, Ngau Chi Wan");
        insert(++$i, "Ping Shek, Kowloon Bay,Ngau Tau Kok, Jordan Valley,Kwun Tong, Sau Mau Ping,Lam Tin, Yau Tong,Lei Yue Mun");

        insert(++$i, "Kwai Chung, Tsing Yi");
        insert(++$i, "Tsuen Wan, Lei Muk Shue,Ting Kau, Sham Tseng,Tsing Lung Tau, Ma Wan,Sunny Bay");
        insert(++$i, "Tai Lam Chung,So Kwun Wat,Tuen Mun, Lam Tei");
        insert(++$i, "Hung Shui Kiu, Ha Tsuen,Lau Fau Shan,Tin Shui Wai, Yuen Long,San Tin, Lok Ma Chau,Kam Tin, Shek Kong,Pat Heung ");
        insert(++$i, "Fanling, Luen Wo Hui,Sheung Shui,Shek Wu Hui,Sha Tau Kok, Luk Keng,Wu Kau Tang");
        insert(++$i, "Tai Po Market, Tai Po,Tai Po Kau, Tai Mei Tuk,Shuen Wan,Cheung Muk Tau,Kei Ling Ha");
        insert(++$i, "Tai Wai, Sha Tin,Fo Tan, Ma Liu Shui,Wu Kai Sha,Ma On Shan");
        insert(++$i, "Clear Water Bay, Sai Kung,Tai Mong Tsai,Tseung Kwan O,Hang Hau, Tiu Keng Leng,Ma Yau Tong ");
        insert(++$i, "Cheung Chau, Peng Chau,Lantau Island(including Tung Chung),Lamma Island");
        

        DB::table('contact_types')->insert([
            ['name' => 'Mobile'],
            ['name' => 'E-mail'],
            ['name' => 'Telegram'],
        ]);

        DB::table('estate_types')->insert([
            ['name' => 'Private Housing Estate'],
            ['name' => 'Home Ownership Scheme'],
            ['name' => 'Car Park'],
            ['name' => 'Shop'],
            ['name' => 'Commercial']
        ]);

        DB::table('transaction_types')->insert([
            ['name' => 'Sell(Non-HOS)'],
            ['name' => 'Sell(HOS)'],
            ['name' => 'Rental']
        ]);

        DB::table('people')->insert([
            ['name' => 'Agent-1', 'gender' => 'M'],
            ['name' => 'Agent-2', 'gender' => 'F'],
            ['name' => 'Agent-3', 'gender' => 'M'],
            ['name' => 'Agent-4', 'gender' => 'F'],
        ]);

        DB::table('roles')->insert([
            ['name' => 'Manager'],
            ['name' => 'Agent'],
            ['name' => 'Admin'],
        ]);

        DB::table('privileges')->insert([
            ['id' => 1, 'name' => 'People'],
            ['id' => 2, 'name' => 'Property'],
            ['id' => 3, 'name' => 'Customer'],
            ['id' => 4, 'name' => 'Package'],
            ['id' => 5, 'name' => 'Transaction'],
            ['id' => 6, 'name' => 'Report'],
            ['id' => 7, 'name' => 'System'],
        ]);

        DB::table('privilege_role')->insert([
            ['role_id' => 1, 'privilege_id' => 1],
            ['role_id' => 1, 'privilege_id' => 2],
            ['role_id' => 1, 'privilege_id' => 3],
            ['role_id' => 1, 'privilege_id' => 4],
            ['role_id' => 1, 'privilege_id' => 5],
            ['role_id' => 1, 'privilege_id' => 6],

            ['role_id' => 2, 'privilege_id' => 1],
            ['role_id' => 2, 'privilege_id' => 2],
            ['role_id' => 2, 'privilege_id' => 3],
            ['role_id' => 2, 'privilege_id' => 4],
            ['role_id' => 2, 'privilege_id' => 5],
            
            ['role_id' => 3, 'privilege_id' => 1],
            ['role_id' => 3, 'privilege_id' => 2],
            ['role_id' => 3, 'privilege_id' => 3],
            ['role_id' => 3, 'privilege_id' => 4],
            ['role_id' => 3, 'privilege_id' => 5],
            ['role_id' => 3, 'privilege_id' => 6],
            ['role_id' => 3, 'privilege_id' => 7],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'admin',
                // 'email' => 'yokada.app@gmail.com',
                // 'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('admin'),
                'branch_id' => 1,
                'role_id' => 3,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'manager',
                // 'email' => 'manager@app.com',
                // 'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('manager'),
                'branch_id' => 1,
                'role_id' => 1,
                'remember_token' => Str::random(10),
            ],
        ]);

        
        for($i = 1 ; $i <= 12 ; $i++){
            DB::table('users')->insert([
                'name' => 'agent' . $i,
                // 'email' => 'agent' . $i . '@app.com',
                // 'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('agent' . $i),
                'branch_id' => $i % 3 + 1,
                'role_id' => 2,
                'remember_token' => Str::random(10),
            ]);
        }

        DB::table('branches')->insert([
            ['property_id' => 1, 'manager' => 1, 'name' => '分行-1'],
            ['property_id' => 2, 'manager' => 1, 'name' => '分行-2'],
            ['property_id' => 3, 'manager' => 1, 'name' => '分行-3'],
        ]);

        DB::table('package_statuses')->insert([
            ['name' => 'Onsale'],
            ['name' => 'Sold'],
            ['name' => 'Cancel'],
            ['name' => 'Lost'],
        ]);

        /*
        DB::table('property')->insert([

        ]);
        */

        DB::table('customer_statuses')->insert([
            ['name' => 'Active'],
            ['name' => 'Complete'],
            ['name' => 'Lose'],
            ['name' => 'Lost Contact'],
            ['name' => 'Cancel'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
