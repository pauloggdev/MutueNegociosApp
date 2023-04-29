<?php

namespace App\Http\Controllers\Estructural\Decorator;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Arr;

class DecoratorController extends Component
{
    public $cart = [];
    public $arrayIngredientes = [];




    public function render(){

        $data['ingredientes'] = DB::table('ingredientes')->get();
//        $arrayIngredientes = [];
//        foreach ($ingredientes as $ingrediente){
//            $arrayIngredientes[] = new Ingrediente($ingrediente->name, $ingrediente->price);
//        }

//
//        $ingrediente1 = new Ingrediente('Massa', 10.00);
//        $ingrediente2 = new Ingrediente('Muzzarela', 20.00);
//        $ingrediente3 = new Ingrediente('Tomate', 5.00);
//        $ingrediente4 = new Ingrediente('Manjericão', 5.00);

//        $pizzaMargarida = new PizzaDaNona(array($ingrediente1, $ingrediente2, $ingrediente3, $ingrediente4));
//        $pizzaMargarida = new PizzaDaNona($arrayIngredientes);
//        $superPizza = new ExtraGrande(new BordaRecheada(new MassaIntegral($pizzaMargarida)));


        return view("Decorator.index", $data);
    }
    private function isCart($item){
        $cart = collect($this->cart);
        $cart = $cart->firstWhere('id', $item['id']);
        return $cart;
    }

    public function addCart($item, $key){

        $isCart = $this->isCart($item);

        if($isCart){
            $this->cart[$key]['qty']++;
        }else{
            $this->cart[]= [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => 1
            ];
        }



//        $arrayIngredientes = [];
//        foreach ($this->cart as $ingrediente){
//            $arrayIngredientes[] = new Ingrediente($ingrediente['name'], $ingrediente['price']);
//        }
//        var_dump($arrayIngredientes);
//        $this->arrayIngredientes = [];
//        $this->arrayIngredientes = $arrayIngredientes;
//        $pizzaMargarida = new PizzaDaNona($arrayIngredientes);
//        $superPizza = new ExtraGrande(new BordaRecheada(new MassaIntegral($pizzaMargarida)));
//
//        dd($superPizza->getPreco());


    }
}
