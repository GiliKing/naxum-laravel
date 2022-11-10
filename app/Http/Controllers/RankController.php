<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Report;
use App\Models\Longest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankController extends Controller
{
    
    //Creating the logic that returns a view
    public function index()
    {
        ini_set('max_execution_time', 180);

        /* this logic is to get invoice, purchaser and distributor */

        // this are the orders made by customers
        $orders = Order::filter(request(['order_date']))->simplepaginate(10);

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

            $report = Report::create([
                'invoice' => $orders[$b]->invoice_number,
                'purchaser' => $GLOBALS['customers'][$b],
                'distributor' => $GLOBALS['distributor'][$b],
                'num_referred_dist' => $GLOBALS['total_referred_dist'][$b],
                'order_date' => $orders[$b]->order_date,
                'order_total' => $total_number_orders[$b],
                'percentage' => $percentage[$b],
                'commission' => $commission[$b]
            ]);

            $report->save();

        }


        $reports = Report::all();

        $good = [];
        $wow = [];

        foreach($reports as $report) {

            $ok = DB::table('reports')->where('distributor', "=", $report->distributor)->sum('order_total');

            $yes = DB::table('reports')->where('distributor', "=", $report->distributor)->value('distributor');


            array_push($good, $ok);

            array_push($wow, $yes);

        }

        $finally = array_combine($wow, $good);

        // echo "<pre>";
        // print_r($finally);
        // echo "</pre>";


        // remove data first 
        Longest::truncate();
        
        foreach($finally as $key => $final) {

            $long = Longest::create([
                'distributor' => $key,
                'total_sales' => $final,
            ]);

            $long->save();

        }

        $longs = Longest::orderBy('total_sales', 'desc')->get();

        return view('rank', [
            'longs' => $longs,
            'orders' => $orders
        ]);


        
    }
    
}
