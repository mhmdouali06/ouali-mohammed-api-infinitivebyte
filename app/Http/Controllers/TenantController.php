<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Tenant;
use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *   schema="Tenant",
 *   type="object",
 *   required={"first_name", "last_name", "phone", "email", "property_id"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="first_name", type="string", example="John"),
 *   @OA\Property(property="last_name", type="string", example="Doe"),
 *   @OA\Property(property="phone", type="string", example="123-456-7890"),
 *   @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *   @OA\Property(property="address", type="string", example="456 Elm St, City, Country"),
 *   @OA\Property(property="property_id", type="integer", example=1)
 * )
 */

class TenantController extends Controller
{
     
    /**
     * @OA\Get(
     * security={{"bearerAuth":{}}},
     *   tags={"Tenants"},

     *     path="/api/tenants",
     *     summary="List tenants",
     *     description="Retrieve a list of tenants with optional filtering, sorting, and pagination.",
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
     *         description="Search term for filtering tenants by first name, last name, or email",
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
     *         description="List of tenants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tenant")
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

        $query = Tenant::where('first_name', 'like', '%' . $search . '%')
                       ->orWhere('last_name', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%')
                       ->orderBy($sort, $order);

        if ($items === 'paginate') {
            $tenants = $query->paginate($items_per_page);
        } else if ($items == 'all') {
            $tenants = $query->get();
        }
        return response()->json($tenants);
    }

    /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *         tags={"Tenants"},

     *     path="/api/tenants",
     *     summary="Create a new tenant",
     *     description="Add a new tenant to the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Tenant")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tenant created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Tenant")
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
            "first_name" => ["string", "required"],
            "last_name" => ["string", "required"],
            "phone" => ["string", "required"],
            "email" => ["string", "required", "email", "unique:tenants,email"],
            "address" => ["nullable", "string"],
            "property_id" => ["required", "exists:properties,id"]
        ]);

        if ($validator->fails()) {
            $arr = $validator->errors()->all();
            $message = $arr[0] ?? 'Validation error';
            return response()->json(["message" => $message], 400);
        }

        $tenant = new Tenant();
        $tenant->first_name = $request->first_name;
        $tenant->last_name = $request->last_name;
        $tenant->phone = $request->phone;
        $tenant->email = $request->email;
        $tenant->address = $request->address;
        $tenant->property_id = $request->property_id;

        $tenant->save();
        return response()->json($tenant, 201);
    }

    /**
     * @OA\Get(
     * security={{"bearerAuth":{}}},
     *     path="/api/tenants/{id}",
     *  tags={"Tenants"},
     *     summary="Retrieve a specific tenant",
     *     description="Get detailed information about a specific tenant by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tenant to retrieve",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant details",
     *         @OA\JsonContent(ref="#/components/schemas/Tenant")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tenant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(Tenant $tenant)
    {
        if ($tenant) {
            return response()->json($tenant);
        }

        return response()->json(['message' => 'Tenant not found'], 404);
    }

    /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *     path="/api/tenants/{id}",
     *  tags={"Tenants"},
     *     summary="Update a specific tenant",
     *     description="Update details of a specific tenant by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tenant to update",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Tenant")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Tenant")
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
     *         description="Tenant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ["string", "required"],
            "last_name" => ["string", "required"],
            "phone" => ["string", "required"],
            "email" => ["string", "required", "email", "unique:tenants,email," . $tenant->id],
            "address" => ["nullable", "string"],
            "property_id" => ["required", "exists:properties,id"]
        ]);

        if ($validator->fails()) {
            $arr = $validator->errors()->all();
            $message = $arr[0] ?? 'Validation error';
            return response()->json(["message" => $message], 400);
        }

        $tenant->first_name = $request->first_name;
        $tenant->last_name = $request->last_name;
        $tenant->phone = $request->phone;
        $tenant->email = $request->email;
        $tenant->address = $request->address;
        $tenant->property_id = $request->property_id;

        $tenant->save();
        return response()->json($tenant);
    }

    /**
     * @OA\Delete(
     * security={{"bearerAuth":{}}},
     *  tags={"Tenants"},
     *     path="/api/tenants/{id}",
     *     summary="Delete a specific tenant",
     *     description="Remove a tenant from the database by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tenant to delete",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tenant deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tenant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(Tenant $tenant)
    {
        if ($tenant) {
            $tenant->delete();
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'Tenant not found'], 404);
    }
}
