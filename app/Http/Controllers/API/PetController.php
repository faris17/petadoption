<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pet = Pet::with('category')->get();
        $petResource = PetResource::collection($pet);

        return $this->sendResponse($petResource, "Successfull get pets");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePetRequest $request)
    {
        $pet = Pet::create($request->validated());

        if ($request->file('image') != null) {
            $file = $request->file('image');
            $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/file/'), $filename);

            $pet->image = $filename;
            $pet->update();
        }

        return $this->sendResponse('', "Successfull store pet");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        $cek = Pet::with('gallery')->findOrFail($pet->id);
        if (!$cek) {
            abort(404, 'Object not found');
        }

        return $this->sendResponse($cek, "Successfull get category");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'name' => 'required',
                'gender' => 'required',
                'description' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors());
        }

        $dataPet = Pet::findOrFail($pet->id);
        $image = $dataPet->image;

        if ($request->file('image') != '') {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);

            if ($dataPet->image != null) {
                $file = asset('upload/file/' . $dataPet->image);

                if (file_exists($file)) {
                    File::delete(public_path('upload/file/') . $dataPet->image);
                }
            }

            $file = $request->file('image');
            $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/file/'), $filename);
            $image = $filename;
        }

        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'datebirth' => $request->datebirth,
            'weight' => $request->weight,
            'description' => $request->description,
            'image' => $image
        ];

        $pet->update($data);

        $result = new PetResource($pet);

        return $this->sendResponse($result, "Successfull updated pet    ");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return response()->noContent();
    }
}
