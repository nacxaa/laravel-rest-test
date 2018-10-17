<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
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
        Product::truncate();

        $faker = \Faker\Factory::create();
        $types = ['t-shirt', 'mug', 'boots', 'phone-case'];
        $colors = ['whitesilver','grey','black','navy','blue','cerulean','sky blue','turquoise','blue-green','azure','teal','cyan','green','lime','chartreuse','live','yellow','gold','amber','orange','brown','orange-red','red','maroon','rose','red-violet','pink','magenta','purple','blue-violet','indigo','violet','peach','apricot','ochre','plum'];
        $sizes = ['xs','s','m','l','xl'];

        // And now, let's create a few prods in our database:
        for ($i = 0; $i < 50; $i++) {

            $prod = Product::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'price' => rand(0, 1000)/10,
                'productType' => $types[array_rand($types)],
                'color' => $colors[array_rand($colors)],
                'size' => $sizes[array_rand($sizes)],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
