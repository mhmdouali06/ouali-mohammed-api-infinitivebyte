<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceived;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Schema(
 *   schema="Payment",
 *   type="object",
 *   required={"tenant_id", "payment_date", "amount"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="tenant_id", type="integer", example=1),
 *   @OA\Property(property="payment_date", type="string", format="date", example="2024-08-27"),
 *   @OA\Property(property="amount", type="number", format="decimal", example=299.99),
 *   @OA\Property(property="settled", type="boolean", example=false)
 * )
 */

class PaymentController extends Controller
{
   

    /**
     * @OA\Get(
     * security={{"bearerAuth":{}}},
     *  tags={"Payments"},
     *     path="/api/payments",
     *     summary="List payments",
     *     description="Retrieve a list of payments with optional filtering, sorting, and pagination.",
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
     *         description="Search term for filtering payments by amount",
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
     *         description="List of payments",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Payment")
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

        $query = Payment::where('amount', 'like', '%' . $search . '%')
                         ->orderBy($sort, $order);

        if ($items === 'paginate') {
            $payments = $query->paginate($items_per_page);
        } else if ($items == 'all') {
            $payments = $query->get();
        }
        return response()->json($payments);
    }

    /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *     path="/api/payments",
     * tags={"Payments"},
     *     summary="Create a new payment",
     *     description="Add a new payment to the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
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
            "tenant_id" => ["required", "exists:tenants,id"],
            "payment_date" => ["required", "date"],
            "amount" => ["required", "numeric"],
            "settled" => ["nullable", "boolean"],
        ]);

        if ($validator->fails()) {
            $arr = $validator->errors()->all();
            $message = $arr[0] ?? 'Validation error';
            return response()->json(["message" => $message], 400);
        }

        $payment = new Payment();
        $payment->tenant_id = $request->tenant_id;
        $payment->payment_date = $request->payment_date;
        $payment->amount = $request->amount;
        $payment->settled = $request->settled ?? false;

        $payment->save();
       
       
        Mail::to('test@gmail.com')->send(new PaymentReceived($payment));

        return response()->json($payment, 201);
    }

    /**
     * @OA\Get(
     * security={{"bearerAuth":{}}},
     *     path="/api/payments/{id}",
     * tags={"Payments"},
     *     summary="Retrieve a specific payment",
     *     description="Get detailed information about a specific payment by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the payment to retrieve",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment details",
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(Payment $payment)
    {
        if ($payment) {
            return response()->json($payment);
        }

        return response()->json(['message' => 'Payment not found'], 404);
    }

    /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *     path="/api/payments/{id}",
     * tags={"Payments"},
     *     summary="Update a specific payment",
     *     description="Update details of a specific payment by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the payment to update",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
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
     *         description="Payment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(), [
            "tenant_id" => ["sometimes", "exists:tenants,id"],
            "payment_date" => ["sometimes", "date"],
            "amount" => ["sometimes", "numeric"],
            "settled" => ["nullable", "boolean"],
        ]);

        if ($validator->fails()) {
            $arr = $validator->errors()->all();
            $message = $arr[0] ?? 'Validation error';
            return response()->json(["message" => $message], 400);
        }

        $payment->tenant_id = $request->tenant_id ?? $payment->tenant_id;
        $payment->payment_date = $request->payment_date ?? $payment->payment_date;
        $payment->amount = $request->amount ?? $payment->amount;
        $payment->settled = $request->settled ?? $payment->settled;

        $payment->save();
        return response()->json($payment);
    }

    /**
     * @OA\Delete(
     * security={{"bearerAuth":{}}},
     *     path="/api/payments/{id}",
     * tags={"Payments"},
     *     summary="Delete a specific payment",
     *     description="Remove a payment from the database by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the payment to delete",
     *         required=true,
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Payment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(Payment $payment)
    {
        if ($payment) {
            $payment->delete();
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'Payment not found'], 404);
    }
}
