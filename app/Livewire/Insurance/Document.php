<?php

namespace App\Livewire\Insurance;

use App\Models\InsuranceDocument as DocumentModel;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class Document extends Component implements HasForms, HasTable
{
    use \Filament\Forms\Concerns\InteractsWithForms,
        \Filament\Tables\Concerns\InteractsWithTable;

    public $insuranceId;

    public function mount($id)
    {
        $this->insuranceId = $id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('messages.insurance_document.documents_heading'))
            ->query(DocumentModel::query()->where('insurance_id', $this->insuranceId))
            ->headerActions([
                CreateAction::make()
                    ->model(DocumentModel::class)
                    ->createAnother(false)
                    ->form($this->createForm())
                    ->successNotificationTitle(__('messages.insurance_document.notification.created_successfully'))
                    ->modalHeading(__('messages.insurance_document.modal.new_document_heading'))
                    ->label(__('messages.insurance_document.button.add_document')),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->columns([
                TextColumn::make('media.0.name')
                    ->label(__('messages.insurance_document.table.file')),
                TextColumn::make('documentType.name')
                    ->label(__('messages.insurance_document.table.document_type'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('messages.insurance_document.table.status'))
                    ->formatStateUsing(fn ($state) => DocumentModel::STATUS[$state])
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->actionsColumnLabel(__('messages.insurance_document.table.actions'))
            ->actions([
                DeleteAction::make()
                    ->action(function ($record) {
                        $record->delete();

                        return notify(__('messages.insurance_document.notification.deleted_successfully'));
                    })
                    ->iconButton(),
            ]);
    }

    public function createForm()
    {
        return [
            Group::make([
                Hidden::make('insurance_id')
                    ->default($this->insuranceId),
                Select::make('document_type_id')
                    ->label(__('messages.insurance_document.form.document_type'))
                    ->relationship('documentType', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
                SpatieMediaLibraryFileUpload::make('file')
                    ->label(__('messages.insurance_document.form.file'))
                    ->collection(DocumentModel::FILE)
                    ->disk(config('app.media_disk'))
                    ->required(),
                Select::make('status')
                    ->label(__('messages.insurance_document.form.status'))
                    ->options(DocumentModel::STATUS)
                    ->required()
                    ->native(false),
            ])
                ->columns(1),
        ];
    }

    public function render()
    {
        return <<<'HTML'
        <div>
           {{ $this->table }}
        </div>
        HTML;
    }
}
