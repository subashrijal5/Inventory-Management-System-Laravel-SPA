<?php

namespace App\Http\Controllers;

use App\Enums\Core\FilterFieldTypeEnum;
use App\Enums\Core\SortOrderEnum;
use App\Enums\Customer\CustomerFiltersEnum;
use App\Enums\Customer\CustomerSortFieldsEnum;
use App\Exceptions\CustomerNotFoundException;
use App\Helpers\BaseHelper;
use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerIndexRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Services\CustomerService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerService $service)
    {
    }

    public function index(CustomerIndexRequest $request): LengthAwarePaginator|Response
    {
        if ($request->inertia == "disabled"){
            $query = $request->validated();
            $query["sort_by"] = CustomerSortFieldsEnum::NAME->value;
            return $this->service->getAll($query);
        }

        return Inertia::render(
            component: 'Customer/Index',
            props: [
                'customers' => $this->service->getAll($request->validated()),
                'filters'   => [
                    CustomerFiltersEnum::NAME->value       => [
                        'label'       => CustomerFiltersEnum::NAME->label(),
                        'placeholder' => __('placeholders.enter_name'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[CustomerFiltersEnum::NAME->value] ?? "",
                    ],
                    CustomerFiltersEnum::EMAIL->value      => [
                        'label'       => CustomerFiltersEnum::EMAIL->label(),
                        'placeholder' => __('placeholders.enter_email'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[CustomerFiltersEnum::EMAIL->value] ?? "",
                    ],
                    CustomerFiltersEnum::PHONE->value      => [
                        'label'       => CustomerFiltersEnum::PHONE->label(),
                        'placeholder' => __('placeholders.enter_phone'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[CustomerFiltersEnum::PHONE->value] ?? "",
                    ],
                    "sort_by"                              => [
                        'label'       => __('placeholders.sort_by'),
                        'placeholder' => __('placeholders.select_sort_field'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_by'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(CustomerSortFieldsEnum::choices()),
                    ],
                    "sort_order"                           => [
                        'label'       => __('placeholders.sort_order'),
                        'placeholder' => __('placeholders.select_sort_order'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_order'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(SortOrderEnum::choices()),
                    ],
                    CustomerFiltersEnum::CREATED_AT->value => [
                        'label'       => CustomerFiltersEnum::CREATED_AT->label(),
                        'placeholder' => __('placeholders.enter_created_at'),
                        'type'        => FilterFieldTypeEnum::DATETIME_RANGE->value,
                        'value'       => $request->validated()[CustomerFiltersEnum::CREATED_AT->value] ?? "",
                    ],
                ],
            ]);
    }

    public function store(CustomerCreateRequest $request): RedirectResponse
    {
        try {
            $this->service->create(
                payload: $request->validated()
            );
            $flash = [
                "message" => __('success_messages.customer_created')
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.customer_creation_failed'),
            ];

            Log::error("Customer creation failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('flash', $flash);
    }

    public function update(CustomerUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $this->service->update(
                id: $id,
                payload: $request->validated()
            );
            $flash = [
                "message" => __('success_messages.customer_updated')
            ];
        } catch (CustomerNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.customer_update_failed'),
            ];

            Log::error("Customer update failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('flash', $flash);
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->service->delete(id: $id);
            $flash = [
                "message" => __('success_messages.customer_deleted')
            ];
        } catch (CustomerNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.customer_deletion_failed'),
            ];

            Log::error("Customer deletion failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('flash', $flash);
    }
}
