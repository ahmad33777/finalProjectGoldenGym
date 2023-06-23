<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{

    public function index()
    {
        $offers = Offer::all();

        foreach ($offers as $offer) {
            $logo_link = Storage::url($offer->image);
            $offer->image = $logo_link;
        }
        // dd($offer->toArray());
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'offer_title' => 'required|string',
                'offer_start' => 'nullable|date',
                'offer_end' => 'nullable|date|after_or_equal:offer_start',
                'offer_description' => 'required|string',
                'offer_image' => 'required|image|max:2048',
            ],
            [
                'offer_title.required' => 'عنوان العرض مطلوب',
                'offer_start.date' => 'يجب أن يكن تاريخ',
                'offer_end.date' => 'يجب أن يكن تاريخ',
                'offer_end.after_or_equal' => 'يجب أن يكون تاريخ انتهاء العرض بعد تاريخ بدء العرض أو مساويًا له',
                'offer_image.required' => 'حقل صورة العرض مطلوب',
                'offer_image.image' => 'يجب أن يكون الملف عبارة عن صورة',
                'offer_description.required' => 'حقل وصف العرض مطلوب',
            ]
        );

        $newOffer = new Offer();
        $newOffer->title = $request->post('offer_title');
        $newOffer->offer_start = $request->post('offer_start', null);
        $newOffer->offer_end = $request->post('offer_end', null);
        $newOffer->description = $request->post('offer_description');
        $newOffer->user_id = \Auth::user()->id;
        if ($request->hasFile('offer_image')) {
            $image = $request->file('offer_image');
            $path = 'uplodes/offers/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $newOffer->image = $path . $name;
        }

        $status = $newOffer->save();
        session()->flash('status', $status);
        return redirect()->route('offer.index');
    }

    public function edit($id)
    {
        $offer = Offer::where('id', $id)->first();
        $logo_link = Storage::url($offer->image);
        $offer->image = $logo_link;
        return view('offers.edit', compact('offer'));
    }


    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'offer_title' => 'required|string',
                'offer_start' => 'nullable|date',
                'offer_end' => 'nullable|date|after_or_equal:offer_start',
                'offer_description' => 'required|string',
                'offer_image' => 'nullable|image|max:2048',
            ],
            [
                'offer_title.required' => 'عنوان العرض مطلوب',
                'offer_start.date' => 'يجب أن يكن تاريخ',
                'offer_end.date' => 'يجب أن يكن تاريخ',
                'offer_end.after_or_equal' => 'يجب أن يكون تاريخ انتهاء العرض بعد تاريخ بدء العرض أو مساويًا له',
                 'offer_image.image' => 'يجب أن يكون الملف عبارة عن صورة',
                'offer_description.required' => 'حقل وصف العرض مطلوب',
            ]
        );

        $newOffer = Offer::where('id', $id)->first();
        $newOffer->title = $request->post('offer_title');
        $newOffer->offer_start = $request->post('offer_start', null);
        $newOffer->offer_end = $request->post('offer_end', null);
        $newOffer->description = $request->post('offer_description');
        $newOffer->user_id = \Auth::user()->id;
        
        if ($request->hasFile('offer_image')) {
            $image = $request->file('offer_image');
            $path = 'uplodes/offers/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $newOffer->image = $path . $name;
        }
        $status = $newOffer->save();
        session()->flash('updateStatus', $status);
        return redirect()->route('offer.index');
    }
    public function destroy($id)
    {
        $offerDestroy = Offer::destroy($id);
        if ($offerDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }
}