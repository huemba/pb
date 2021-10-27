<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\ProductOption;

class CartController extends Controller
{
    public function index(Request $request){

        $cartItems = $this->getCartItemsArray($request);

        return view('cart.index', [
            "cartItems" => $cartItems
        ]);
    }

    public function addToCart(Request $request) {
        
        $current_user = $request->user();

        if ($current_user) {

        } else {
            $this->addToCookieCart($request);
        }

        if(empty($request->header('referer'))) {
            return redirect()->route('cart.index');
        } else {
            return redirect()->back();
        }
    }

    public function deleteCartItem(Request $request){
        $current_user = $request->user();

        if ($current_user) {

        } else {
            if ($this->deleteFromCookieCart($request)) {
                return response('success');
            } else {
                return response('failed');
            }
        }
    }

    public function updateCartItems(Request $request){
        $current_user = $request->user();

        if ($current_user) {

        } else {
            $this->updateToCookieCart($request);
        }

        if(empty($request->header('referer'))) {
            return redirect()->route('cart.index');
        } else {
            return redirect()->back();
        }
    }

    private function updateToCookieCart(Request $request){
        if ($request->has('product_options')){
            $product_options = $request->input('product_options');

            if (is_array($product_options)){
                $cookieCart = [];
                foreach($product_options as $productOptionId => $value){
                    if (isset($value['quantity'])){
                        $quantity = intval($value['quantity']);
                        if ($quantity > 0){
                            $product_option = ProductOption::findIfEnabled($productOptionId);
                            if ($product_option) {
                                $cookieCart[$productOptionId] = $quantity;
                            }
                        }
                    }
                }
                $this->saveCookieCart($cookieCart);
            }
        }
    }

    private function deleteFromCookieCart(Request $request){
        if ($request->has('product_option_id')){
            $productOptionId = intval($request->input('product_option_id'));
            $cookieCart = $this->getCartFromCookie();

            if ( isset($cookieCart[$productOptionId]) ){
                unset($cookieCart[$productOptionId]);
                $this->saveCookieCart($cookieCart);
                return true;
            }
        }
        return false;
    }

    private function addToCookieCart(Request $request){
        $cookieCart = $this->getCartFromCookie();

        foreach($request->input() as $key => $value){
            if (preg_match('/^product_option_[0-9]+$/', $key)){
                $quantity = intval($value);
                $productOptionId = intval(str_replace('product_option_', '', $key));
                if ($quantity && $productOptionId){
                    $product_option = ProductOption::findIfEnabled($productOptionId);
                    if ($product_option){
                        if (isset($cookieCart[$productOptionId])){
                            $cookieCart[$productOptionId] += $quantity;
                        } else {
                            $cookieCart[$productOptionId] = $quantity;
                        }
                    }
                }
            }
        }

        $this->saveCookieCart($cookieCart);
    }

    private function getCartFromCookie(){
        $jsonCart = Cookie::get('cart');
        return (!is_null($jsonCart)) ? json_decode($jsonCart, true) : [];
    }

    private function saveCookieCart($cookieCart){
        $cartToJson = empty($cookieCart) ? "{}" : json_encode($cookieCart, true);
        Cookie::queue(
            Cookie::make('cart', $cartToJson, 60 * 24 * 7, null, null, false, false)
        );
    }

    private function getCartItemsArray(Request $request) {
        $current_user = $request->user();
        if ($current_user){

        } else {
            $cookieCart = $this->getCartFromCookie();

            $cartItemsAry = [];
            foreach($cookieCart as $productOptionId => $quantity){
                $productOption = ProductOption::findIfEnabled($productOptionId);
                if ($productOption) {
                    array_push($cartItemsAry, [
                        "productOption" => $productOption,
                        "quantity" => $quantity,
                    ]);
                } else {
                    unset($cookieCart[$productOptionId]);
                }
            }
            $this->saveCookieCart($cookieCart);

            return $cartItemsAry;
        }
    }
}
