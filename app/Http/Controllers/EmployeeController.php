<?php

namespace App\Http\Controllers;

use App\Enums\Core\FilterFieldTypeEnum;
use App\Enums\Core\SortOrderEnum;
use App\Enums\Employee\EmployeeFiltersEnum;
use App\Enums\Employee\EmployeeSortFieldsEnum;
use App\Exceptions\EmployeeNotFoundException;
use App\Helpers\BaseHelper;
use App\Http\Requests\Employee\EmployeeCreateRequest;
use App\Http\Requests\Employee\EmployeeIndexRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeService $service)
    {
    }

    public function index(EmployeeIndexRequest $request)
    {
        if ($request->inertia == "disabled"){
            $query = $request->validated();
            $query["sort_by"] = EmployeeSortFieldsEnum::NAME->value;
            return $this->service->getAll($query);
        }

        return Inertia::render(
            component: 'Employee/Index',
            props: [
                'employees' => $this->service->getAll($request->validated()),
                'filters'   => [
                    EmployeeFiltersEnum::NAME->value         => [
                        'label'       => EmployeeFiltersEnum::NAME->label(),
                        'placeholder' => __('placeholders.enter_name'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::NAME->value] ?? "",
                    ],
                    EmployeeFiltersEnum::EMAIL->value        => [
                        'label'       => EmployeeFiltersEnum::EMAIL->label(),
                        'placeholder' => __('placeholders.enter_email'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::EMAIL->value] ?? "",
                    ],
                    EmployeeFiltersEnum::PHONE->value        => [
                        'label'       => EmployeeFiltersEnum::PHONE->label(),
                        'placeholder' => __('placeholders.enter_phone'),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::PHONE->value] ?? "",
                    ],
                    EmployeeFiltersEnum::NID->value          => [
                        'label'       => EmployeeFiltersEnum::NID->label(),
                        'placeholder' => __('placeholders.enter') . ' ' . strtolower(EmployeeFiltersEnum::NID->label()),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::NID->value] ?? "",
                    ],
                    EmployeeFiltersEnum::SALARY->value       => [
                        'label'       => EmployeeFiltersEnum::SALARY->label(),
                        'placeholder' => __('placeholders.enter') . ' ' . strtolower(EmployeeFiltersEnum::SALARY->label()),
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::SALARY->value] ?? "",
                    ],
                    EmployeeFiltersEnum::JOINING_DATE->value => [
                        'label'       => EmployeeFiltersEnum::JOINING_DATE->label(),
                        'placeholder' => __('placeholders.enter') . ' ' . strtolower(EmployeeFiltersEnum::JOINING_DATE->label()),
                        'type'        => FilterFieldTypeEnum::DATE_RANGE->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::JOINING_DATE->value] ?? "",
                    ],
                    "sort_by"                                => [
                        'label'       => __('placeholders.sort_by'),
                        'placeholder' => __('placeholders.select_sort_field'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_by'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(EmployeeSortFieldsEnum::choices()),
                    ],
                    "sort_order"                             => [
                        'label'       => __('placeholders.sort_order'),
                        'placeholder' => __('placeholders.select_sort_order'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_order'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(SortOrderEnum::choices()),
                    ],
                    EmployeeFiltersEnum::CREATED_AT->value   => [
                        'label'       => EmployeeFiltersEnum::CREATED_AT->label(),
                        'placeholder' => __('placeholders.enter_created_at'),
                        'type'        => FilterFieldTypeEnum::DATETIME_RANGE->value,
                        'value'       => $request->validated()[EmployeeFiltersEnum::CREATED_AT->value] ?? "",
                    ],
                ],
            ]);
    }

    public function store(EmployeeCreateRequest $request): RedirectResponse
    {
        try {
            $this->service->create(
                payload: $request->validated()
            );
            $flash = [
                "message" => __('success_messages.employee_created')
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.employee_creation_failed'),
            ];

            Log::error("Employee creation failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with('flash', $flash);
    }

    public function update(EmployeeUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $this->service->update(
                id: $id,
                payload: $request->validated()
            );
            $flash = [
                "message" => __('success_messages.employee_updated')
            ];
        } catch (EmployeeNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.employee_update_failed'),
            ];

            Log::error("Employee update failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with('flash', $flash);
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->service->delete(id: $id);
            $flash = [
                "message" => __('success_messages.employee_deleted')
            ];
        } catch (EmployeeNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => __('error_messages.employee_deletion_failed'),
            ];

            Log::error("Employee deletion failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with('flash', $flash);
    }
}
