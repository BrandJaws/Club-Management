<?php
use Illuminate\Database\Seeder;

class CSVGenerator extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $file = fopen("import_members.csv", "w");
        $data = [
            'firstName',
            'lastName',
            'email',
            'phone',
            'relation',
            'parent'
        ];
        fputcsv($file,  $data);
        for ($p = 0; $p < 20; $p ++) {
            $email = $faker->email;
            $data = [
                $faker->firstName,
                $faker->lastName,
                $email,
                $faker->phoneNumber,
                'Parent',
                ''
            ];
            fputcsv($file,  $data);
            for ($i = 0; $i < 3; $i ++) {
                
                $data = [
                    $faker->firstName,
                    $faker->lastName,
                    $faker->email,
                    $faker->phoneNumber,
                    $faker->randomElement(['Child','Spouse']),
                    $email
                ];
                fputcsv($file,  $data);
            }
        }
        fclose($file);
    }
}
