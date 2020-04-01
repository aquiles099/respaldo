<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Category;

class CategorySeeder extends Seeder
{

	private $data = [
    	[
        'label'       => 'accesorio de toilet',
        'percentage'        => 1
        ],
        [
        'label'       => 'accesorio de cocina',
        'percentage'        => 1
        ],
        [
        'label'       => 'accesorio de vehiculo',
        'percentage'        => 1
        ],
        [
        'label'       => 'accesorio para ejercicios',
        'percentage'        => 1
        ],
        [
        'label'       => 'articulos de pescar',
        'percentage'        => 1
        ],
        [
        'label'       => 'articulos de oficinas',
        'percentage'        => 1
        ],
        [
        'label'       => 'articulos de primera necesidad',
        'percentage'        => 1
        ],
        [
        'label'       => 'articulos deportivos',
        'percentage'        => 1
        ],
        [
        'label'       => 'bicicleta',
        'percentage'        => 1
        ],
        [
        'label'       => 'bisuteria',
        'percentage'        => 1
        ],
        [
        'label'       => 'bolsos',
        'percentage'        => 1
        ],
        [
        'label'       => 'colonia',
        'percentage'        => 1
        ],
        [
        'label'       => 'correspondencia',
        'percentage'        => 1
        ],
        [
        'label'       => 'cosmeticos',
        'percentage'        => 1
        ],
        [
        'label'       => 'decoracion',
        'percentage'        => 1
        ],
        [
        'label'       => 'electrodomesticos',
        'percentage'        => 1
        ],
        [
        'label'       => 'electronicos',
        'percentage'        => 5
        ],
        [
        'label'       => 'herramientas',
        'percentage'        => 1
        ],
        [
        'label'       => 'juguetes',
        'percentage'        => 1
        ],
        [
        'label'       => 'libros',
        'percentage'        => 1
        ],
        [
        'label'       => 'limpieza',
        'percentage'        => 1
        ],
        [
        'label'       => 'maquillaje',
        'percentage'        => 1
        ],
        [
        'label'       => 'maquinaria',
        'percentage'        => 1
        ],
        [
        'label'       => 'materiales de estudio',
        'percentage'        => 1
        ],
        [
        'label'       => 'medicina',
        'percentage'        => 1
        ],
        [
        'label'       => 'medicinal',
        'percentage'        => 1
        ],
        [
        'label'       => 'muebles',
        'percentage'        => 1
        ],
        [
        'label'       => 'musical',
        'percentage'        => 1
        ],
        [
        'label'       => 'perfumes',
        'percentage'        => 1
        ],
        [
        'label'       => 'productos de odontologia',
        'percentage'        => 1
        ],
        [
        'label'       => 'relojeria',
        'percentage'        => 1
        ],
        [
        'label'       => 'repuestos',
        'percentage'        => 1
        ],
        [
        'label'       => 'ropa y calzado',
        'percentage'        => 5
        ],
        [
        'label'       => 'salud y belleza',
        'percentage'        => 1
        ],
        [
        'label'       => 'suplementos',
        'percentage'        => 1
        ],
        [
        'label'       => 'video juego',
        'percentage'        => 1
        ]


    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->data as $row) {
      	$category = Category::create($row);
    	}
    }
}
