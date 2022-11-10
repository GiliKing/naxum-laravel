<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Report;
use App\Models\AllInvoice;
use App\Models\NotCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ReportController extends Controller
{    
    // Creating the logic that returns a view
    public function index()
    {

        ini_set('max_execution_time', 180);

        /* this logic is to get invoice, purchaser and distributor */

        // this are the orders made by customers
        $orders = Order::filter(request(['order_date']))->simplepaginate(30);

        // this is a temporary storage that stores the distributor who referred a customer
        $GLOBALS['distributor'] = [];

        // this is a temporary storage that stores the distributor who referred a customer
        $GLOBALS['customers'] = [];

        foreach($orders as $order) {

            // this get the unique distributor
            $users_dist = DB::table('users')->where('id', $order->purchaser_id)->value('referred_by');

            // this get the unique distributor
            $users_cust = DB::table('users')->where('id', $order->purchaser_id)->value('username');

            // this will put th unique distributor line in line to the referred purchaser
            array_push($GLOBALS['distributor'], $users_dist);

            array_push($GLOBALS['customers'], $users_cust);

        }

        /* this logic is to get referred distributor*/

        // Now 
        // let get how many referred distributor the distributor has referred
        // first create you super global to store Referred_dist temporarily
        $GLOBALS['referred_dist'] = [];

        // then loop through you super global distributor array to be able to get each individual distributor
        foreach($GLOBALS['distributor'] as $dist) {

            // this is very important because read the next line
            // this is to course a minute pause to give the 
            // iterator a little bit of time to get all required information
            // from the data base   
            if($dist) {

                // this will get the referred_dist that was referred by a distributor
                $referred_dist = DB::table('users')->where('referred_by', $dist)->get();

                // this will put in the super global array
                array_push($GLOBALS['referred_dist'], $referred_dist);

                // continue the iteration for the rest
                continue;
            }
            
        }

        

        // another super global is need to store the total numeber of referred_dist for a distributor
        $GLOBALS['total_referred_dist'] = [];

        for($i = 0; $i < count($GLOBALS['referred_dist']); $i++) {

            // this will compile the total number and store it in an array
            array_push($GLOBALS['total_referred_dist'], count($GLOBALS['referred_dist'][$i]));

        }


        /* this logic is to get the order total */

        // let create a super global to store the total number of order
        $total_number_orders = [];

        foreach($orders as $order) {

            // this get the unique distributor
            $order_items = DB::table('order_items')->where('order_id', $order->id)->value('qantity');

            // this will put th unique distributor line in line to the referred purchaser
            array_push($total_number_orders, $order_items);
        }

        // for percentage
        $percentage = [];


        for($r = 0; $r < count($GLOBALS['total_referred_dist']); $r++) {

            if($GLOBALS['total_referred_dist'][$r] <= 5) {
                array_push($percentage, '10%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 10) {
                array_push($percentage, '20%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 20) {
                array_push($percentage, '30%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 30) {
                array_push($percentage, '32%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 40) {
                array_push($percentage, '35%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 50) {
                array_push($percentage, '40%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 60) {
                array_push($percentage, '43%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 70) {
                array_push($percentage, '48%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 79) {
                array_push($percentage, '48.4%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 99) {
                array_push($percentage, '49%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 100) {
                array_push($percentage, '50%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 157) {
                array_push($percentage, '70%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 160) {
                array_push($percentage, '80%');
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 200) {
                array_push($percentage, '100%');
            }
        }

        // for commission
        $commission = [];

        for($r = 0; $r < count($GLOBALS['total_referred_dist']); $r++) {
            
            if($GLOBALS['total_referred_dist'][$r] <= 5) {
                $com = (10/100 * $total_number_orders[$r]);
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 10) {
                $com = 20/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 20) {
                $com = 30/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 30) {
                $com = 32/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 40) {
                $com = 35/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 50) {
                $com = 40/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 60) {
                $com = 43/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 70) {
                $com = 48/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 79) {
                $com = 48.4/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 99) {
                $com = 49/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 100) {
                $com = 50/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 157) {
                $com = 70/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 160) {
                $com = 80/100 * $total_number_orders[$r];
                array_push($commission, $com);
            } elseif ($GLOBALS['total_referred_dist'][$r] <= 200) {
                $com = 100/100 * $total_number_orders[$r];
                array_push($commission, $com);
            }
        }

        /* inserting all the information into a table */

        // echo "<pre>";
        // print_r($commission);
        // echo "</pre>";

        // remove data first if it exist 
        Report::truncate();
        
        for($b = 0; $b < count($orders); $b++) {

            Report::create([
                'invoice' => $orders[$b]->invoice_number,
                'purchaser' => $GLOBALS['customers'][$b],
                'distributor' => $GLOBALS['distributor'][$b],
                'num_referred_dist' => $GLOBALS['total_referred_dist'][$b],
                'order_date' => $orders[$b]->order_date,
                'order_total' => $total_number_orders[$b],
                'percentage' => $percentage[$b],
                'commission' => $commission[$b]
            ]);


        }


        
        /* this logic is for show all the required modal */

        // invoice information that contains order id and others
        $order_in = [];

        foreach($orders as $order) {

            if($order->invoice_number) {
                // this get the unique distributor
                $orders_many = DB::table('orders')->where('invoice_number', $order->invoice_number)->get();

                // this will put th unique order_id line in line to the invoice
                array_push($order_in, $orders_many);

                continue;
            }
        }
        
        // echo "<pre>";
        // print_r($order_in);
        // echo "</pre>";


        // getting and cutting out only the order id
        $order_in_id = [];

        for($i = 0; $i < count($order_in); $i++) {

            array_push($order_in_id, $order_in[$i][0]->id);

        }

        // echo "<pre>";
        // print_r($order_in_id);
        // echo "</pre>";


        // order ID gotten from the invoice cut out above from the upper manipulation
        $order_items = [];

        foreach($order_in_id as $ord) {

            if($ord) {
              
                $orders_only = DB::table('order_items')->where('order_id', $ord)->get();
                
                array_push($order_items, $orders_only);

                continue;
            }
        }

        // echo "<pre>";
        // print_r($order_items);
        // echo "</pre>";


        // product_id gotten fron the order id from db order_items
        $product_items = [];

        for($i = 0; $i < count($order_items); $i++) {

            if(count($order_items[$i]) <= 1){

                array_push($product_items, $order_items[$i][0]->product_id);

                continue;

            }

            if(count($order_items[$i]) > 1) {

                for($k = 0; $k < count($order_items[$i]); $k++) {      

                    array_push($product_items, $order_items[$i][$k]->product_id);

                }

                continue;

            }
            
         

        }

        // echo "<pre>";
        // print_r($product_items);
        // echo "</pre>";

        // storing all the matching needed information
        $all = [];

        $all = [
            "invoice" => [],
            "order_id" => [],
            "product_id" => [],
            "quantity" => [],
            "sku" => [],
            "name" => [],
            "price" => [],
        ];

       

        // to get the matching and repeating order_id, product_id, quantity
        for($i = 0; $i < count($order_items); $i++) {

            if(count($order_items[$i]) <= 1){

                array_push($all['product_id'], $order_items[$i][0]->product_id);

                array_push($all['order_id'], $order_items[$i][0]->order_id);

                array_push($all['quantity'], $order_items[$i][0]->qantity);

                continue;

            }

            if(count($order_items[$i]) > 1) {

                for($k = 0; $k < count($order_items[$i]); $k++) {   

                    array_push($all['product_id'], $order_items[$i][$k]->product_id);

                    array_push($all['order_id'], $order_items[$i][$k]->order_id);

                    array_push($all['quantity'], $order_items[$i][$k]->qantity);   


                }

                continue;

            }

        
         

        }

        // to get the matching and repeating invoice
        foreach($all['order_id'] as $all_ord) {

            $get_the_repeting_invoice = DB::table('orders')->where('id', $all_ord)->value('invoice_number');

            array_push($all['invoice'], $get_the_repeting_invoice);
        }

        // now let select all the product with the product id
        foreach($product_items as $prod) {

            $products_sku = DB::table('products')->where('id', $prod)->value('sku');

            $products_name = DB::table('products')->where('id', $prod)->value('name');

            $products_price = DB::table('products')->where('id', $prod)->value('price');


            array_push($all['sku'], $products_sku);

            array_push($all['name'], $products_name);

            array_push($all['price'], $products_price);  

        }

        // remove data first if it exist 
        AllInvoice::truncate();

        for($p = 0; $p < count($all['invoice']); $p++) {

            AllInvoice::create([
                'invoice' => $all['invoice'][$p],
                'order_id' => $all['order_id'][$p],
                'product_id' => $all['product_id'][$p],
                'quantity' => $all['quantity'][$p],
                'sku' => $all['sku'][$p],
                'name' => $all['name'][$p],
                'price' => $all['price'][$p],
            ]);


        }
        



        $reports = Report::all();


        return view('report', [
            'reports' => $reports,
            'orders' => $orders
        ]);


    }

    public function call(Request $request) 
    {

        $data_invoice = $request->all();


        $invoice = DB::table('all_invoice')->where('invoice', $data_invoice['invoice'])->get();

        
        return response()->json(array($invoice), 200);


    }
 
}
