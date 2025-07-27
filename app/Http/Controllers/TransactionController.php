<?php

namespace App\Http\Controllers;

use App\Enums\Core\FilterFieldTypeEnum;
use App\Enums\Core\FilterResourceEnum;
use App\Enums\Core\SortOrderEnum;
use App\Enums\Order\OrderFieldsEnum;
use App\Enums\Transaction\TransactionExpandEnum;
use App\Enums\Transaction\TransactionFiltersEnum;
use App\Enums\Transaction\TransactionPaidThroughEnum;
use App\Enums\Transaction\TransactionSortFieldsEnum;
use App\Helpers\BaseHelper;
use App\Http\Requests\Transaction\TransactionIndexRequest;
use App\Services\TransactionService;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionService $service)
    {
    }

    public function index(TransactionIndexRequest $request): Response
    {
        $params = $request->validated();
        $params['expand'] = array_unique(array_merge($params['expand'] ?? [], [
            TransactionExpandEnum::ORDER->value,
        ]));

        return Inertia::render(
            component: 'Transaction/Index',
            props: [
                'transactions' => $this->service->getAll($params),
                'filters'      => [
                    TransactionFiltersEnum::TRANSACTION_NUMBER->value => [
                        'label'       => TransactionFiltersEnum::TRANSACTION_NUMBER->label(),
                        'placeholder' => __('placeholders.enter') . ' ' . strtolower(TransactionFiltersEnum::TRANSACTION_NUMBER->label()),
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[TransactionFiltersEnum::TRANSACTION_NUMBER->value] ?? "",
                    ],
                    TransactionFiltersEnum::ORDER_ID->value           => [
                        'label'         => TransactionFiltersEnum::ORDER_ID->label(),
                        'placeholder'   => __('placeholders.select') . ' ' . strtolower(TransactionFiltersEnum::ORDER_ID->label()),
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[TransactionFiltersEnum::ORDER_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::ORDERS->value,
                        'resourceLabel' => OrderFieldsEnum::ORDER_NUMBER->value,
                    ],
                    TransactionFiltersEnum::AMOUNT->value             => [
                        'label'       => TransactionFiltersEnum::AMOUNT->label(),
                        'placeholder' => __('placeholders.enter') . ' ' . strtolower(TransactionFiltersEnum::AMOUNT->label()),
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[TransactionFiltersEnum::AMOUNT->value] ?? "",
                    ],
                    TransactionFiltersEnum::PAID_THROUGH->value       => [
                        'label'       => TransactionFiltersEnum::PAID_THROUGH->label(),
                        'placeholder' => __('placeholders.select') . ' ' . strtolower(TransactionFiltersEnum::PAID_THROUGH->label()),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()[TransactionFiltersEnum::PAID_THROUGH->value] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(TransactionPaidThroughEnum::choices()),
                    ],
                    "sort_by"                                         => [
                        'label'       => __('placeholders.sort_by'),
                        'placeholder' => __('placeholders.select_sort_field'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_by'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(TransactionSortFieldsEnum::choices()),
                    ],
                    "sort_order"                                      => [
                        'label'       => __('placeholders.sort_order'),
                        'placeholder' => __('placeholders.select_sort_order'),
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_order'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(SortOrderEnum::choices()),
                    ],
                    TransactionFiltersEnum::CREATED_AT->value         => [
                        'label'       => TransactionFiltersEnum::CREATED_AT->label(),
                        'placeholder' => __('placeholders.enter') . ' ' . strtolower(TransactionFiltersEnum::CREATED_AT->label()),
                        'type'        => FilterFieldTypeEnum::DATETIME_RANGE->value,
                        'value'       => $request->validated()[TransactionFiltersEnum::CREATED_AT->value] ?? "",
                    ],
                ],
            ]);
    }
}
