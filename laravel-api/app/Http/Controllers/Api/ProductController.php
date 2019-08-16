<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiError;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $data =['data' => $this->product->all()];
        return response()->json($data);
    }

    public function show($id)
    {
        $product =$this->product->find($id);

        if($product) {
            $data =['data' => $product];
            return response()->json($data);

        } else {

            return response()->json(['data' => ['msg' => 'Produto Não Encontrado']],404);;
        }

    }

    public function store(Request $request)
    {
        try{
            $productData = $request->all();
            $this->product->create($productData);
            return response()->json(['msg' => 'Producto Criado com sucesso!'],201);
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(),1010));
            } else {
                return response()->json(ApiError::errorMessage('Houve um erro ao salvar',1010));
            }

        }

    }

    public function update(Request $request,$id)
    {
        try{
            $productData = $request->all();
            $product = $this->product->find($id);
            $product->update($productData);
            return response()->json(['msg' => 'Producto Atualizado com sucesso!'],201);
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(),1011));
            } else {
                return response()->json(ApiError::errorMessage('Houve um erro ao atualizar',1011));
            }

        }

    }

    public function delete(Product $id)
    {
        try{
            $id->delete();
            return response()->json(['data' => 'produto ' . $id->name . ' removido com sucesso.'],200);

        } catch(Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(),1012));
            } else {
                return response()->json(ApiError::errorMessage('Houve um erro ao deletar',1012));
            }

        }


    }
}
