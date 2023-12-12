<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Contact; 
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *     title="Contact API",
 *     version="1.0.0",
 *     description="API for managing contact information"
 * )
 */
class ContactApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/contacts",
     *     operationId="getContactsList",
     *     tags={"Contacts"},
     *     summary="Get list of contacts",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contact"))
     *     )
     * )
     */
    public function index()
    {
        $contacts = Contact::all();
        return response()->json($contacts, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/contacts/{id}",
     *     operationId="getContactById",
     *     tags={"Contacts"},
     *     summary="Get contact information by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="Contact id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact not found"
     *     )
     * )
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/contacts",
     *     operationId="addContact",
     *     tags={"Contacts"},
     *     summary="Add a new contact",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Contact object that needs to be added to the store",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact created",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $contact = Contact::create($validatedData);
        return response()->json($contact, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/contacts/store",
     *     operationId="storeContact",
     *     tags={"Contacts"},
     *     summary="Store a newly created contact in storage",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Contact object to be stored",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $contact = Contact::create($validatedData);
        return response()->json($contact, 200);
    }

    // You may continue to add additional methods with appropriate OpenAPI annotations
}
