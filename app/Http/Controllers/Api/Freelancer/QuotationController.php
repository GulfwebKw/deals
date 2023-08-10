<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Http\Controllers\Admin\Common;
use App\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $quotations = $user->quotations()->with('services')->get();
        return $this->apiResponse(200, ['data' => ['quotations' => $quotations], 'message' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        
        //return json_encode($request->all());
        if ( $request->has('v2') ){
            $this->validate($request, [
                'client_name'=>'required',
                'date'=>'required|date',
                'user_id'=>'required|numeric|exists:users,id',
                'services_name.*'=>'required',
                'services_price.*'=>'required|numeric',
                'installment.*'=>'nullable|numeric',
            ]);
            $services = [] ;
            foreach ($request->services_name as $i => $name ){
                $services[$i] = [
                    'name' => $name,
                    'description' => $request->services_description[$i] ?? "",
                    'quantity' => $request->services_quantity[$i] ?? "",
                    'price' => $request->services_price[$i] ?? "",
                ];
                if ( $request->has('services_base64File.'.$i) )
                    $services[$i]['base64File'] = $request->services_base64File[$i];
            }
        } else {
            $this->validate($request, [
                'client_name' => 'required',
                'date' => 'required|date',
                'user_id' => 'required|numeric|exists:users,id',
                'services.*.name' => 'required',
                'services.*.price' => 'required|numeric',
                'installment.*' => 'nullable|numeric',
            ]);
            $services = $request->services;
        }
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $qutation = $user->quotations()->create($request->except(['services' , 'installment' , 'services_name' , 'services_description' , 'services_quantity' , 'services_base64File' , 'services_price' , 'services_file' , 'v2']));
            $totalPrice = 0 ;
            foreach ( $services as $i => $service ){
                if ( $request->hasFile('services.'.$i.'.file') ) {
                    $cover_image = Common::uploadImage($request, 'services.'.$i.'.file', 'services', 0, 0, 0, 0);
                    unset($service['file']);
                    $service['attachment'] =  '/uploads/services/'.$cover_image;
                }
                if ( $request->hasFile('services_file.'.$i) ) {
                    $cover_image = Common::uploadImage($request, 'services_file.'.$i, 'services', 0, 0, 0, 0);
                    unset($service['file']);
                    $service['attachment'] =  '/uploads/services/'.$cover_image;
                }
                if ( isset($service['base64File']) ) {
                    $cover_image = $this->saveBase64($service['base64File'] ,$i);
                    $service['attachment'] =  '/uploads/services/'.$cover_image;
                }
                unset($service['base64File']);
                $qutation->services()->create($service);
                $totalPrice += $service['price'] ;
            }
            if ( $qutation->payment_type == "Installment" and is_array($request->installment) ){
                foreach ( $request->installment as $index => $installment ){
                    $qutation->installments()->create([
                        'number' => ++$index,
                        'percent' => $request->installment_type == "percent" ? $installment : round( 100 * $installment / $totalPrice),
                        'price' => $request->installment_type == "percent" ? round($totalPrice * $installment / 100) : $installment,
                    ]);
                }
            }
            $user->messages()->create([
                'type' => 'freelancer',
                'status' => '0',
                'user_id' => $request->user_id,
                'message' => $qutation->id ,
                'message_type' => '6' ,
                'file' => null,
                'userRead' => 0,
                'freelancerRead' => 1,
            ]);
            $user->messages()->create([
                'type' => 'freelancer',
                'status' => '0',
                'user_id' => $request->user_id,
                'message' => 'here is my quotation for your reference can you view it and let me know when you are ready' ,
                'message_type' => '1' ,
                'file' => null,
                'userRead' => 0,
                'freelancerRead' => 1,
            ]);
            UserNotification::add($request->user_id, $user->id, ['sendQuotation', "", ""], 'sendQuotation', ['quotation_id' => $qutation->id]);
            DB::commit();
            return $this->apiResponse(200, ['data' => ['quotation' => $qutation], 'message' => [trans('api.sendQuotation')]]);
        } catch (\Exception $e){}
        DB::rollBack();
        return $this->apiResponse(500, ['data' => [$e->getMessage() , $e->getLine() , $e->getFile() , $e->getTrace()], 'message' => [trans('api.unknownError')]]);
        return $this->apiResponse(500, ['data' => [], 'message' => [trans('api.unknownError')]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $quotations = $user->quotations()->with(['services' , 'installments' , 'freelancerAddress.area.city.country' ])->findOrFail($id);
        return $this->apiResponse(200, ['data' => ['quotation' => $quotations], 'message' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'client_name'=>'required',
            'date'=>'required|date',
            'user_id'=>'required|numeric|exists:users,id',
            'services.*.name'=>'required',
            'services.*.price'=>'required|numeric',
            'installment.*'=>'nullable|numeric',
        ]);
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $qutation = $user->quotations()->findOrFail($id);
            $qutation->update($request->except(['services' , 'installment']));
            $totalPrice = 0 ;
            $qutation->services()->delete();
            foreach ( $request->services as $i => $service ){
                if ( $request->hasFile('services.'.$i.'.file') ) {
                    $cover_image = Common::uploadImage($request, 'services.'.$i.'.file', 'services', 0, 0, 0, 0);
                    unset($service['file']);
                    $service['attachment'] = '/uploads/services/'.$cover_image;
                }
                $qutation->services()->create($service);
                $totalPrice += $service['price'] ;
            }
            $qutation->installments()->delete();
            if ( $qutation->payment_type == "Installment" and is_array($request->installment)  ){
                foreach ( $request->installment as $index => $installment ){
                    $qutation->installments()->create([
                        'number' => ++$index,
                        'percent' => $installment,
                        'price' => round($totalPrice * $installment / 100),
                    ]);
                }
            }
            $user->messages()->create([
                'type' => 'freelancer',
                'status' => '0',
                'user_id' => $request->user_id,
                'message' => $qutation->id ,
                'message_type' => '6' ,
                'file' => null,
                'userRead' => 0,
                'freelancerRead' => 1,
            ]);
            DB::commit();
            return $this->apiResponse(200, ['data' => ['quotation' => $qutation], 'message' => [trans('api.sendQuotation')]]);
        } catch (\Exception $e){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => ['message' => [$e->getMessage()]], 'message' => [trans('api.unknownError')]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $quotations = $user->quotations()->findOrFail($id)->delete();
        return $this->apiResponse(200, ['data' => ['quotation' => $quotations], 'message' => []]);
    }
    
    private function saveBase64($data,$name){
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }
            $data = str_replace( ' ', '+', $data );
            $data = base64_decode($data);
        
            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            
            throw new \Exception('did not match data URI with image data ' . $data);
        }
        
        $imageName =  'services-quotationController-'.$name.'-' . md5(time()) . '.' . $type;
        $patch = public_path('uploads/services/'.$imageName);
        if (file_put_contents($patch, $data) === false) {
            throw new \Exception('Can not save files!');
        }
        return $imageName;
    }
}
