<?php

namespace App\Http\Controllers;

use App\Enums\Category\CategoryFieldsEnum;
use App\Enums\Core\FilterFieldTypeEnum;
use App\Enums\Core\FilterResourceEnum;
use App\Enums\Core\SortOrderEnum;
use App\Enums\Product\ProductExpandEnum;
use App\Enums\Product\ProductFiltersEnum;
use App\Enums\Product\ProductSortFieldsEnum;
use App\Enums\Product\ProductStatusEnum;
use App\Enums\Supplier\SupplierFieldsEnum;
use App\Enums\UnitType\UnitTypeFieldsEnum;
use App\Exceptions\ProductNotFoundException;
use App\Helpers\BaseHelper;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service)
    {
    }

    public function index(ProductIndexRequest $request): Response
    {
        $params = $request->validated();
        $params['expand'] = array_unique(array_merge($params['expand'] ?? [], [
            ProductExpandEnum::CATEGORY->value,
            ProductExpandEnum::SUPPLIER->value,
            ProductExpandEnum::UNIT_TYPE->value,
        ]));

        return Inertia::render(
            component: 'Product/Index',
            props: [
                'products' => $this->service->getAll($params),
                'filters'  => [
                    ProductFiltersEnum::KEYWORD->value        => [
                        'label'       => ProductFiltersEnum::KEYWORD->label(),
                        'placeholder' => __('placeholders.enter_keyword'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::KEYWORD->value] ?? "",
                    ],
                    ProductFiltersEnum::NAME->value           => [
                        'label'       => ProductFiltersEnum::NAME->label(),
                        'placeholder' => __('placeholders.enter_name'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::NAME->value] ?? "",
                    ],
                    ProductFiltersEnum::PRODUCT_NUMBER->value => [
                        'label'       => ProductFiltersEnum::PRODUCT_NUMBER->label(),
                        'placeholder' => __('placeholders.enter_product_number'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::PRODUCT_NUMBER->value] ?? "",
                    ],
                    ProductFiltersEnum::PRODUCT_CODE->value   => [
                        'label'       => ProductFiltersEnum::PRODUCT_CODE->label(),
                        'placeholder' => __('placeholders.enter_product_code'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::PRODUCT_CODE->value] ?? "",
                    ],
                    ProductFiltersEnum::CATEGORY_ID->value    => [
                        'label'         => ProductFiltersEnum::CATEGORY_ID->label(),
                        'placeholder'   => __('placeholders.select_category'),
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[ProductFiltersEnum::CATEGORY_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::CATEGORIES->value,
                        'resourceLabel' => CategoryFieldsEnum::NAME->value,
                    ],
                    ProductFiltersEnum::SUPPLIER_ID->value    => [
                        'label'         => ProductFiltersEnum::SUPPLIER_ID->label(),
                        'placeholder'   => __('placeholders.select_supplier'),
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[ProductFiltersEnum::SUPPLIER_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::SUPPLIERS->value,
                        'resourceLabel' => SupplierFieldsEnum::NAME->value,
                    ],
                    ProductFiltersEnum::BUYING_PRICE->value   => [
                        'label'       => ProductFiltersEnum::BUYING_PRICE->label(),
                        'placeholder' => __('placeholders.enter_buying_price'),
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::BUYING_PRICE->value] ?? "",
                    ],
                    ProductFiltersEnum::SELLING_PRICE->value  => [
                        'label'       => ProductFiltersEnum::SELLING_PRICE->label(),
                        'placeholder' => __('placeholders.enter_selling_price'),
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::SELLING_PRICE->value] ?? "",
                    ],
                    ProductFiltersEnum::BUYING_DATE->value    => [
                        'label'       => ProductFiltersEnum::BUYING_DATE->label(),
                        'placeholder' => __('placeholders.enter_buying_date'),
                        'type'        => FilterFieldTypeEnum::DATE_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::BUYING_DATE->value] ?? "",
                    ],
                    ProductFiltersEnum::UNIT_TYPE_ID->value     => [
                        'label'         => ProductFiltersEnum::UNIT_TYPE_ID->label(),
                        'placeholder'   => __('placeholders.select_unit_type'),
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[ProductFiltersEnum::UNIT_TYPE_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::UNIT_TYPES->value,
                        'resourceLabel' => UnitTypeFieldsEnum::NAME->value,
                    ],
                    ProductFiltersEnum::QUANTITIES->value     => [
                        'label'       => ProductFiltersEnum::QUANTITIES->label(),
                        'placeholder' => __('placeholders.enter_quantity_range'),
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::QUANTITIES->value] ?? "",
                    ],
                    ProductFiltersEnum::STATUS->value         => [
                        'label'       => ProductFiltersEnum::STATUS->label(),
                        'placeholder' => __('placeholders.select_status'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()[ProductFiltersEnum::STATUS->value] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(ProductStatusEnum::choices()),
                    ],
                    "sort_by"                                 => [
                        'label'       => __('placeholders.sort_by'),
                        'placeholder' => __('placeholders.select_sort_field'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_by'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(ProductSortFieldsEnum::choices()),
                    ],
                    "sort_order"                              => [
                        'label'       => __('placeholders.sort_order'),
                        'placeholder' => __('placeholders.select_sort_order'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_order'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(SortOrderEnum::choices()),
                    ],
                    ProductFiltersEnum::CREATED_AT->value     => [
                        'label'       => ProductFiltersEnum::CREATED_AT->label(),
                        'placeholder' => __('placeholders.enter_created_at'),
                        'type'        => FilterFieldTypeEnum::DATETIME_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::CREATED_AT->value] ?? "",
                    ],
                ],
            ]);
    }

    public function create(): Response
    {
        return Inertia::render(
            component: 'Product/Create'
        );
    }

    public function store(ProductCreateRequest $request): RedirectResponse
    {
        try {
            $this->service->create(
                payload: $request->validated()
            );
            $flash = [
                "message" => __('success_messages.product_created')
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.product_creation_failed'),
            ];

            Log::error("Product creation failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('flash', $flash);
    }

    public function edit(Product $product): Response|RedirectResponse
    {
        return Inertia::render(
            component: 'Product/Edit',
            props: [
                "product" => $product
            ]
        );
    }

    public function update(ProductUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $this->service->update(
                id: $id,
                payload: $request->validated()
            );
            $flash = [
                "message" => __('success_messages.product_updated')
            ];
        } catch (ProductNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.product_update_failed'),
            ];

            Log::error("Product update failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('flash', $flash);
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->service->delete(id: $id);
            $flash = [
                "message" => __('success_messages.product_deleted')
            ];
        } catch (ProductNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.product_deletion_failed'),
            ];

            Log::error("Product deletion failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('flash', $flash);
    }
}
