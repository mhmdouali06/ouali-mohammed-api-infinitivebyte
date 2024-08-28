<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Property;
use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *   schema="Property",
 *   type="object",
 *   required={"name", "address", "type", "number_units", "price"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="Property Name"),
 *   @OA\Property(property="address", type="string", example="123 Main St, City, Country"),
 *   @OA\Property(property="type", type="string", example="Residential"),
 *   @OA\Property(property="number_units", type="integer", example=10),
 *   @OA\Property(property="price", type="number", format="decimal", example=99.99),
 *   @OA\Property(property="description", type="string", example="Description of the property"),
 * )
 */



class PropertyController extends Controller
{
     

    /**
     * @OA\Get(
     *      tags={"properties"},
    *security={{"bearerAuth":{}}},
     *     path="/api/properties",
     *     summary="List properties",
     *     description="Retrieve a list of properties with optional filtering, sorting, and pagination.",
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         schema={"type": "string", "default": "id"}
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Sort order (asc or desc)",
     *         required=false,
     *         schema={"type": "string", "default": "desc"}
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for filtering properties by name, address, or type",
     *         required=false,
     *         schema={"type": "string"}
     *     ),
     *     @OA\Parameter(
     *         name="items",
     *         in="query",
     *         description="Specify 'paginate' for paginated results or 'all' for all results",
     *         required=false,
     *         schema={"type": "string", "default": "paginate"}
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for paginated results",
     *         required=false,
     *         schema={"type": "integer", "default": 1}
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         schema={"type": "integer", "default": 10}
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of properties",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Property")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $sort = 'id';
        $order = 'desc';
        $search = null;
        $items = 'paginate';
        $items_per_page = 10;

        if ($request->items) {
            $items = $request->items;
        }

        if ($request->order) {
            $order = $request->order;
            $sort = $request->sort;
        }

        if ($request->search) {
            $search = $request->search;
        }

        $query = Property ::where('name', 'like', '%' . $search . '%')
                         ->orWhere('address', 'like', '%' . $search . '%')
                         ->orWhere('type', 'like', '%' . $search . '%')
                         ->orderBy($sort, $order);

        if ($items === 'paginate') {
            $properties = $query->paginate($items_per_page);
        } else if ($items == 'all') {
            $properties = $query->get();
        }
        return  response()->json($properties);
           
    }

   /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *      tags={"properties"},

     *     path="/api/properties",
     *     summary="Create a new property",
     *     description="Add a new property to the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Property created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["string", "required"],
            "address" => ["string", "required"],
            "type" => ["string", "required"],
            "number_units" => ["nullable", "integer"],
            "price" => ["required", "numeric"],
        ]);

        if ($validator->fails()) {
            $arr = $validator->errors();
            $arr = $arr->all();
            $message = '';
            foreach ($arr as $value) {
                $message = $value;
                break;
            }
            return response()->json(["message" => $message], 500);
        }

        $property = new Property();
        $property->name = $request->name;
        $property->address = $request->address;
        $property->type = $request->type;
        $property->number_units = $request->number_units;
        $property->price = $request->price;
        
        $property->save();
        return $property;
    }

    /**
     * @OA\Get(
     * security={{"bearerAuth":{}}},
     *       tags={"properties"},

     *     path="/api/properties/{id}",
     *     summary="Retrieve a specific property",
     *     description="Get detailed information about a specific property by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the property to retrieve",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property details",
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(Property $property)
    {
         

        if ($property) {
            return response()->json($property);
        }

        return response()->json(['message' => 'Property not found'], 404);
    }

    /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *  tags={"properties"},

     *     path="/api/properties/{id}",
     *     summary="Update a specific property",
     *     description="Update details of a specific property by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the property to update",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */  public function update(Request $request, Property $property)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["string"],
            "address" => ["string"],
            "type" => ["string"],
            "number_units" => ["nullable", "integer"],
            "price" => ["nullable", "numeric"],
        ]);

        if ($validator->fails()) {
            $arr = $validator->errors();
            $arr = $arr->all();
            $message = '';
            foreach ($arr as $value) {
                $message = $value;
                break;
            }
            return response()->json(["message" => $message], 500);
        }

        if ($request->has('name')) {
            $property->name = $request->name;
        }

        if ($request->has('address')) {
            $property->address = $request->address;
        }

        if ($request->has('type')) {
            $property->type = $request->type;
        }

        if ($request->has('number_units')) {
            $property->number_units = $request->number_units;
        }

        if ($request->has('price')) {
            $property->price = $request->price;
        }

        $property->save();
        return $property;
    }

     /**
     * @OA\Delete(
     * security={{"bearerAuth":{}}},
     *  tags={"properties"},

     *     path="/api/properties/{id}",
     *     summary="Delete a specific property",
     *     description="Remove a specific property from the database.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the property to delete",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */   public function destroy(Property $property)
    {
        if ($property) {
            $property->delete();
            return response()->json(["message" => "Property deleted successfully"], 200);
        }

        return response()->json(["message" => "Property not found"], 404);
    }
} 
