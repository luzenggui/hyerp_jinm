<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Poitem;
use App\Models\Purchase\Poitemroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;

class PoitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $poitem = Poitem::findOrFail($id);
        $headId = $poitem->pohead_id;
        return view('purchase.poitems.edit', compact('poitem', 'headId'));
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
        $poitem = Poitem::findOrFail($id);
        $poitem->update($request->all());
        return redirect('purchase/purchaseorders/' . $request->get('pohead_id') . '/detail');
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
        $poitem = Poitem::findOrFail($id);
        $headId = $poitem->pohead_id;
        Poitem::destroy($id);
        return redirect('purchase/purchaseorders/' . $headId . '/detail');
    }

    public function packingstore(Request $request)
    {
        //
        $input = $request->all();
//        dd($input);
        if (strlen($input['items_string']) < 1)
            dd('未设置任何打包数据，保存失败。');

//        $number = Carbon::now()->toDateTimeString();
//        $input['number'] = $number;

//        $asn = Asn::create($input);

        $poitemrolls = json_decode($input['items_string']);
        foreach ($poitemrolls as $poitemroll) {
            $item_array = json_decode(json_encode($poitemroll), true);
//            $item_array['asn_id'] = $asn->id;
            $nextid = 1;
            $last_poitemroll = Poitemroll::orderBy('id', 'desc')->first();
            if (isset($last_poitemroll))
                $nextid = $last_poitemroll->id + 1;
            $nextid = str_pad($nextid, 7, '0', STR_PAD_LEFT);
            $ucc_number = config('custom.edi.ucc_pre') . $nextid;
//            Log::info('ucc number before: ' . $ucc_number);
            $ucc_number .= $this->checksum($ucc_number);
//            Log::info('ucc number after: ' . $ucc_number);
            $item_array['ucc_number'] = $ucc_number;
//            Log::info($item_array);
            Poitemroll::create($item_array);
        }
        return redirect('purchase/purchaseorders');
    }

    // checksum calc method: http://help.loftware.com/display/LPSKB/UCC-128+SSCC+Check+Digit+Calculation
    static public function checksum($ucc_number)
    {
        $code = substr($ucc_number, 2);
        $code = '1' . $code;
        $codeArray = str_split($code, 1);
        $numbered = 0;
        $oddnumbered = 0;
        $i = 1;
        foreach ($codeArray as $c)
        {
            if ($i > 1)
            {
                if ($i % 2 == 0)
                    $numbered += $c;
                else
                    $oddnumbered += $c;
            }
            $i++;
        }
//        Log::info('numbered: ' . $numbered);
//        Log::info('oddnumbered: ' . $oddnumbered);
        $checksum = 10 - ($numbered * 3 + $oddnumbered) % 10;
        if ($checksum == 10)
            $checksum = 0;
//        Log::info('checksum: ' . $checksum);
        return $checksum;
    }

    public function poitemrolls($poitem_id)
    {
        $poitemrolls = Poitemroll::where('poitem_id', $poitem_id)->orderBy('id')->paginate(10);
        return view('purchase.poitemrolls.index', compact('poitemrolls', 'poitem_id'));
    }

    public function getitemsbypoheadid($pohead_id)
    {
        //
        $poitems = Poitem::where('pohead_id', $pohead_id)
            ->leftJoin('poitemcs', 'poitemcs.id', 'poitems.poitemc_id')
            ->select('poitems.*', 'poitemcs.material_code')
            ->paginate(20);
        return $poitems;
    }
}
