<?php

use App\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Let's truncate our existing records to start from scratch.
        Order::truncate();

        $faker = \Faker\Factory::create();
        $types = ['t-shirt', 'mug', 'boots', 'phone-case'];
        $colors = ['whitesilver','grey','black','navy','blue','cerulean','sky blue','turquoise','blue-green','azure','teal','cyan','green','lime','chartreuse','live','yellow','gold','amber','orange','brown','orange-red','red','maroon','rose','red-violet','pink','magenta','purple','blue-violet','indigo','violet','peach','apricot','ochre','plum'];
        $sizes = ['xs','s','m','l','xl'];
        $statuses = ['new', 'in_progress', 'done', 'cancelled'];
        $countries = ['US', 'UK', 'CN', 'IN', 'RU', 'BR', 'LV'];

        $prods = App\Product::all()->toArray();

        // And now, let's create a few orders in our database:
        for ($i = 0; $i < 10; $i++) {
            $order = Order::create([
                'status' => $statuses[array_rand($statuses)],
                'country' => $countries[array_rand($countries)],
            ]);
            $pr_count = rand(1,10);
            for($k = 0; $k<$pr_count; $k++) {
                $order->products()->attach($prods[array_rand($prods)]['id'], ['quantity'=>rand(1,100)]);
            }

            //echo $order->id."\n";
        }
        Schema::enableForeignKeyConstraints();
    }
}
