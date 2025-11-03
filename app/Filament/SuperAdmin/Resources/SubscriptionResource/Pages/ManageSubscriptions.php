<?php

namespace App\Filament\SuperAdmin\Resources\SubscriptionResource\Pages;

use App\Filament\SuperAdmin\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth; // Added Auth facade
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ManageSubscriptions extends ManageRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected $i = 1;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->icon('heroicon-o-arrow-right-start-on-rectangle')
                ->label(__('messages.subscription.export'))
                ->visible(Auth::user()->hasRole(User::ADMIN))
                ->hidden(fn () => Subscription::where('user_id', Auth::id())->count() == 0)
                ->exports([
                    ExcelExport::make()
                        ->withFilename(__('transactions').'-'.now()->format('Y-m-d').'.xlsx')
                        ->modifyQueryUsing(function ($query) {
                            $q = $query->where('user_id', Auth::id());

                            return $q;
                        })->withColumns([
                            Column::make('id')->heading('No')->formatStateUsing(function () {
                                return $this->i++;
                            }),
                            Column::make('plan.title')->heading(heading: __('Plan')),
                            Column::make('amount')->heading(heading: __('Amount'))->formatStateUsing(fn ($state) => currencySymbol().$state),
                            Column::make('payment_method')->heading(heading: __('Payment Method')),
                            Column::make('payment_status')->heading(heading: __('Payment Status'))->formatStateUsing(fn ($state) => Subscription::PAYMENT_STATUS[$state]),
                            Column::make('payment_status')->heading(heading: __('Status'))->formatStateUsing(fn ($state) => Subscription::STATUSES[$state]),
                            Column::make('created_at')->heading(heading: __('Created At'))->formatStateUsing(fn ($state) => Carbon::parse($state)->format('M d, Y')),
                            Column::make('start_date')->heading(heading: __('Start Date'))->formatStateUsing(fn ($state) => ! empty($state) ? Carbon::parse($state)->format('M d, Y') : ''),
                            Column::make('end_date')->heading(heading: __('End Date'))->formatStateUsing(fn ($state) => ! empty($state) ? Carbon::parse($state)->format('M d, Y') : ''),
                        ]),
                ]),
        ];
    }

    public function changePaymentStatus($id, $userId, $status): void
    {
        if ($status == Subscription::PAID) {

            $subscription = Subscription::where('id', $id)->where('user_id', $userId)->first();

            if (! $subscription) {
                return;
            }

            if ($status == Subscription::PAID) {
                Subscription::where('user_id', $userId)
                    ->where('id', '!=', $id)
                    ->where('is_active', Subscription::ACTIVE)
                    ->update(['is_active' => Subscription::INACTIVE]);

                $subscription->payment_status = $status;
                $subscription->is_active = Subscription::ACTIVE;
                $subscription->start_date = now();
                $subscription->end_date = $subscription->plan->interval == 1
                    ? now()->addMonth()
                    : now()->addYear();

                $subscription->save();
            }
        } else {
            $subscription = Subscription::find($id);
            $subscription->payment_status = $status;
            $subscription->is_active = Subscription::INACTIVE;
            $subscription->start_date = now();
            $subscription->end_date = $subscription->plan->interval == 1 ? now()->addMonths(1) : now()->addYears(1);
            $subscription->save();
        }

    }
}
