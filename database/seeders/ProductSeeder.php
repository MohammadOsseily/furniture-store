<?php

// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get the four specific categories
        $featured3DCategory = Category::where('name', 'Featured 3D Products')->first();
        $chairCategory = Category::where('name', 'Chair')->first();
        $sofaCategory = Category::where('name', 'Sofa')->first();
        $tableCategory = Category::where('name', 'Table')->first();

        // Featured 3D Products
        Product::insert([
            [
                'name' => '3D Printed Modern Lamp',
                'description' => 'A unique 3D printed lamp that adds a modern touch to your home decor.',
                'price' => 79.99,
                'stock' => 12,
                'category_id' => $featured3DCategory->id,
                'image' => '3d-lamp',
                'color' => 'White',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3D Sculpted Wall Art',
                'description' => 'This 3D sculpted wall art features intricate geometric designs for modern homes.',
                'price' => 149.99,
                'stock' => 8,
                'category_id' => $featured3DCategory->id,
                'image' => '3d-wall-art',
                'color' => 'Silver',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3D Geometric Coffee Table',
                'description' => 'A stylish coffee table made using 3D printing technology for an edgy look.',
                'price' => 299.99,
                'stock' => 5,
                'category_id' => $featured3DCategory->id,
                'image' => '3d-coffee-table',
                'color' => 'Black',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3D Printed Vase',
                'description' => 'A stunning vase crafted using 3D technology, perfect for modern interiors.',
                'price' => 49.99,
                'stock' => 15,
                'category_id' => $featured3DCategory->id,
                'image' => '3d-vase',
                'color' => 'Blue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3D Hexagonal Shelf',
                'description' => 'A modern wall shelf designed with a 3D hexagonal pattern.',
                'price' => 89.99,
                'stock' => 10,
                'category_id' => $featured3DCategory->id,
                'image' => '3d-shelf',
                'color' => 'Gray',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Chair Category
        Product::insert([
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'An ergonomic chair designed for maximum comfort and lumbar support.',
                'price' => 199.99,
                'stock' => 25,
                'category_id' => $chairCategory->id,
                'image' => 'office-chair',
                'color' => 'Black',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vintage Wooden Chair',
                'description' => 'A classic wooden chair perfect for any dining room or study.',
                'price' => 89.99,
                'stock' => 30,
                'category_id' => $chairCategory->id,
                'image' => 'wooden-chair',
                'color' => 'Brown',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modern Plastic Chair',
                'description' => 'A modern plastic chair designed for both indoor and outdoor use.',
                'price' => 59.99,
                'stock' => 50,
                'category_id' => $chairCategory->id,
                'image' => 'plastic-chair',
                'color' => 'White',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kids Rocking Chair',
                'description' => 'A fun and safe rocking chair designed for kids.',
                'price' => 39.99,
                'stock' => 20,
                'category_id' => $chairCategory->id,
                'image' => 'kids-rocking-chair',
                'color' => 'Blue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Outdoor Lounge Chair',
                'description' => 'A durable outdoor lounge chair for relaxing in the garden or by the pool.',
                'price' => 149.99,
                'stock' => 40,
                'category_id' => $chairCategory->id,
                'image' => 'lounge-chair',
                'color' => 'Gray',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sofa Category
        Product::insert([
            [
                'name' => 'Leather Sectional Sofa',
                'description' => 'A luxurious sectional sofa made from premium leather.',
                'price' => 999.99,
                'stock' => 8,
                'category_id' => $sofaCategory->id,
                'image' => 'sectional-sofa',
                'color' => 'Brown',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fabric Recliner Sofa',
                'description' => 'A comfortable recliner sofa perfect for family movie nights.',
                'price' => 799.99,
                'stock' => 10,
                'category_id' => $sofaCategory->id,
                'image' => 'recliner-sofa',
                'color' => 'Gray',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Convertible Sofa Bed',
                'description' => 'A sofa that easily converts into a bed for overnight guests.',
                'price' => 599.99,
                'stock' => 12,
                'category_id' => $sofaCategory->id,
                'image' => 'sofa-bed',
                'color' => 'Blue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vintage Velvet Sofa',
                'description' => 'A beautiful velvet sofa with a vintage design.',
                'price' => 699.99,
                'stock' => 6,
                'category_id' => $sofaCategory->id,
                'image' => 'velvet-sofa',
                'color' => 'Green',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compact Sofa',
                'description' => 'A compact sofa perfect for small spaces or apartments.',
                'price' => 499.99,
                'stock' => 20,
                'category_id' => $sofaCategory->id,
                'image' => 'compact-sofa',
                'color' => 'Beige',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Table Category
        Product::insert([
            [
                'name' => 'Modern Glass Dining Table',
                'description' => 'A sleek dining table with a glass top and steel frame.',
                'price' => 599.99,
                'stock' => 10,
                'category_id' => $tableCategory->id,
                'image' => 'glass-dining-table',
                'color' => 'Black',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Wooden Coffee Table',
                'description' => 'A traditional wooden coffee table with carved legs.',
                'price' => 249.99,
                'stock' => 15,
                'category_id' => $tableCategory->id,
                'image' => 'wooden-coffee-table',
                'color' => 'Brown',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compact Side Table',
                'description' => 'A minimalist side table, perfect for small spaces.',
                'price' => 149.99,
                'stock' => 20,
                'category_id' => $tableCategory->id,
                'image' => 'compact-side-table',
                'color' => 'White',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Outdoor Patio Table',
                'description' => 'A sturdy outdoor table designed for patios and gardens.',
                'price' => 299.99,
                'stock' => 12,
                'category_id' => $tableCategory->id,
                'image' => 'patio-table',
                'color' => 'Gray',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rustic Farmhouse Dining Table',
                'description' => 'A large wooden dining table with a rustic farmhouse design.',
                'price' => 799.99,
                'stock' => 8,
                'category_id' => $tableCategory->id,
                'image' => 'farmhouse-dining-table',
                'color' => 'Natural',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
