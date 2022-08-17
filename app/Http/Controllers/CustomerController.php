<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use \Stripe\StripeClient;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            return $stripe->customers->all();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            // Validate the request
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);

            // Store data in array
            $data = [
                //
                'name' => $request->name,
                'email' => $request->email,
                'address' => [
                    'city' => $request->city,
                    'country' => $request->country,
                    'line1' => $request->line1,
                    'line2' => $request->line2,
                    'postal_code' => $request->postal_code,
                    'state' => $request->state,
                ],
                'phone' => $request->phone,
            ];

            // Create & return customer with data
            return $stripe->customers->create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            return $stripe->customers->retrieve(
                $id,
                []
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            // Store data in array
            $data = [
                //
                'name' => $request->name,
                'email' => $request->email,
                'address' => [
                    'city' => $request->city,
                    'country' => $request->country,
                    'line1' => $request->line1,
                    'line2' => $request->line2,
                    'postal_code' => $request->postal_code,
                    'state' => $request->state,
                ],
                'phone' => $request->phone,
            ];

            // Update customer with id
            return $stripe->customers->update(
                $id,
                $data,
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            //
            return $stripe->customers->delete(
                $id,
                [],
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
