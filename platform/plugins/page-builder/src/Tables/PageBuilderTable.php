<?php

namespace Botble\PageBuilder\Tables;

use Botble\PageBuilder\Models\PageBuilder;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class PageBuilderTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(PageBuilder::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('page-builder.create'))
            ->addActions([
                EditAction::make()->route('page-builder.edit'),
                DeleteAction::make()->route('page-builder.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('page-builder.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('page-builder.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'created_at',
                    'status',
                ]);
            });
    }
}
