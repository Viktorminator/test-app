<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Modules\Companies\Repositories\CompanyRepository;
use App\Modules\Companies\Services\CreateCompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private CompanyRepository $repository;

    /**
     * @param CompanyRepository $repository
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *     path="/api/user/companies",
     *     operationId="getUserCompanies",
     *     tags={"Users"},
     *     summary="Get companies related to the user",
     *     description="Retrieves companies associated with the user through a specific relation.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="1", description="Company id"),
     *                 @OA\Property(property="title", type="string", example="ABC Corporation", description="Company title"),
     *                 @OA\Property(property="phone", type="string", example="123-456-7890", description="Company phone number"),
     *                 @OA\Property(property="description", type="string", example="A company description", description="Company description"),
     *                 @OA\Property(property="user_id", type="string", example="1", description="User id"),
     *                 @OA\Property(property="created_at", type="string", example="2023-07-20T14:47:58.000000Z", description="Created at"),
     *                 @OA\Property(property="updated_at", type="string", example="2023-07-20T14:47:58.000000Z", description="Updated at"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User does not have access.")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function getCompanies(): JsonResponse
    {
        $user = Auth::user();
        return response()->json($this->repository->getCompaniesByUserId($user->id)->all());
    }

    /**
     * @OA\Post(
     *     path="/api/user/companies",
     *     operationId="createCompany",
     *     tags={"Users"},
     *     summary="Create a new company",
     *     description="Creates a new company associated with the user.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"title", "phone", "description"},
     *             @OA\Property(property="title", type="string", example="ABC Corporation", description="Company title"),
     *             @OA\Property(property="phone", type="string", example="123-456-7890", description="Company phone number"),
     *             @OA\Property(property="description", type="string", example="A company description", description="Company description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Company created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Company created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Company")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User does not have access.")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Schema(
     *     schema="Company",
     *     type="object",
     *     @OA\Property(property="title", type="string", example="ABC Corporation", description="Company title"),
     *     @OA\Property(property="phone", type="string", example="123-456-7890", description="Company phone number"),
     *     @OA\Property(property="description", type="string", example="A company description", description="Company description")
     * )
     */
    public function createCompany(CreateCompanyRequest $request, CreateCompanyService $service): JsonResponse
    {
        $company = $service->create($request->getParams()->all());
        return response()->json($company, 201);
    }
}
