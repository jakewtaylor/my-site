<?php

use App\Workplace;
use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getWorkplaces() as $workplace) {
            Workplace::create($workplace);
        }
    }

    protected function getWorkplaces()
    {
        return [
            [
                'company' => 'PC Futures',
                'url' => 'https://www.pcfutures.co.uk',
                'role' => 'Full-Stack Web Developer',
                'started' => '2015-08-03',
                'left' => '2018-01-26',
            ],
            [
                'company' => 'GML Consulting',
                'url' => 'https://gmlconsulting.co.uk',
                'role' => 'Full-Stack Web Developer',
                'started' => '2018-02-05',
                'left' => '2018-07-27',
            ],
            [
                'company' => 'John Catt Educational',
                'url' => 'http://johncatt.com',
                'role' => 'Full-Stack Web Developer',
                'started' => '2018-07-30',
                'left' => null,
            ],
        ];
    }
}
