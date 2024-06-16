<?php

namespace App\Http\Controllers\User;

use App\Helpers\LossGainHelper;
use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use App\Models\LossGainTranscation;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.product.index');
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
        try{
			$this->validate($request, [
				'name' => 'required',
				'purchasing_price' => 'required|numeric',
				'selling_price' => 'required|numeric',
			],[
				'purchasing_price.numeric'=>'Purchasing Price Must be Numeric',
				'selling_price.numeric'=>'Selling Price Must be Numeric',
			]
			);
            $product = Product::create($request->all());
            $account = AccountCategory::where('name','Products')->first();
            DebitCreditAccount::create([
                'name' => $request->name,
                'user_id' => Auth::user()->id,
                'account_category_id' => $account->id,
                'product_id' => $product->id,
            ]);  
            toastr()->success('Product is Created Successfully');
            return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());       
            $account = AccountCategory::where('name','Products')->first();
            return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
      
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $product = Product::find($id); 
        if($request->start_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }else{
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::today();
        }
        $dateRange = CarbonPeriod::create($start_date, $end_date);
        $dates = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
        $url = url('product/pdf?product_id='.$product->id.'&start_date='.$start_date->format('Y-m-d').'&end_date='.$end_date->format('Y-m-d').'&user_id='.Auth::user()->id);
        return view('user.product.show',compact('product','dates','start_date','end_date','url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        $old_amount = 0;
        $old_selling_amount = 0;
        if($request->purchasing_price != $product->purchasing_price)
        {
            $old_amount = $product->purchasing_price;
            $old_selling_amount = $product->selling_price;
        }
        $product->update($request->all());
        if($old_amount > 0)
        {
            LossGainHelper::procceed($old_amount,$product,$old_selling_amount,$request->date);
        }
        toastr()->success('Product Informations Updated successfully');
        $account = AccountCategory::where('name','Products')->first();
        return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
      }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        toastr()->success('Product Deleted Successfully');
        $account = AccountCategory::where('name','Products')->first();
        return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
      }
    public function getPrice(Request $request)
    {
        $product = Product::find($request->id);
        if($product && $request->date)
        {
            $lossGains = LossGainTranscation::where('user_id',Auth::user()->id)
                        ->where('product_id',$product->id)
                        ->orderBy('date','desc')->get()->toArray();
            foreach($lossGains as $key => $lossGain)
            {
                $index = $key+1;
                $lastLossGain = array_key_exists($index, $lossGains) ? $lossGains[$index] : [];
                if($lastLossGain)
                {
                    $date = Carbon::parse($request->date);
                    $lossGainDate = Carbon::parse($lossGain['date']);
                    $lastDate = Carbon::parse($lastLossGain['date']);
                    if($date->lte($lossGainDate) && $date->gt($lastDate))
                    {
                        return response()->json([
                            'purchasing_price' => $lastLossGain['new_price'],
                            'selling_price' => $product?$product->selling_amount:0
                        ]);
                    }
                }
            }
        }
        $purchasing_price = $product?$product->purchasing_price:0;
        $selling_price = $product?$product->selling_amount:0;
        return response()->json([
            'purchasing_price' => $purchasing_price,
            'selling_price' => $selling_price
        ]);
    }
    public function generatePDF(Request $request)
    {
        $product = Product::find($request->product_id); 
        if($request->start_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }else{
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::today();
        }
        $dateRange = CarbonPeriod::create($start_date, $end_date);
        $dates = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
       
        return view('user.pdf.product-ledger',compact('product','dates','start_date','end_date'));
   
    }
}
