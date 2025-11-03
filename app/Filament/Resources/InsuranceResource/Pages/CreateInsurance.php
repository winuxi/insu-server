<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use App\Models\Installment;
use App\Models\PolicyPricing;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Added Auth facade

class CreateInsurance extends CreateRecord
{
    protected static string $resource = InsuranceResource::class;

    protected static bool $canCreateAnother = false;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('messages.common.back'))
                ->outlined()
                ->url(static::getResource()::getUrl()),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.insurance.create_insurance_title');
    }

    protected function handleRecordCreation(array $input): Model
    {
        if (Auth::user()->hasRole(User::AGENT)) {
            $input['agent_id'] = Auth::id();
        }

        return parent::handleRecordCreation($input);
    }

    public function afterCreate(): void
    {
        $policyPricing = PolicyPricing::where('id', $this->data['policy_pricing_id'])->with(['duration'])->first();

        $months = $policyPricing->duration->duration_in_months;
        $totalAmount = (float) $policyPricing['price'];
        $insuranceId = $this->record->id;
        $customerId = $this->data['customer_id'];
        $startDate = $this->data['start_date'];
        $baseAmount = $totalAmount / $months;
        $remaining = $totalAmount - ($baseAmount * $months);
        $startDate = Carbon::parse($this->data['start_date']);
        for ($i = 0; $i < $months; $i++) {
            $amount = $baseAmount;
            if ($i === $months - 1) {
                $amount += $remaining;
            }

            Installment::create([
                'insurance_id' => $insuranceId,
                'customer_id' => $customerId,
                'policy_id' => $this->data['policy_id'],
                'order_no' => $i + 1,
                'start_date' => $startDate->copy()->addMonths($i),
                'amount' => round($amount, 2),
            ]);
        }
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.insurance.insurance_created_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
